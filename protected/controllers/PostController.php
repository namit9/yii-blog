<?php

class PostController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','search'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform any action
				'actions'=>array('update','delete'),
				'users'=>array('@'),
				'expression'=>'Post::model()->allow($_GET["id"])==Yii::app()->user->id',
				
			),
	/*	array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$post=$this->loadModel($id);
		$comment=$this->newComment($post);
		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}

	protected function newComment($post)
	{
		$comment=new Comment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);//validate comment-form according to rules in function rules
			Yii::app()->end();//terminates the application
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');//'commentSubmitted'--key of message  used in view
				$this->refresh();//refreshing w/o post data in form
			}
		}
		return $comment;
	}

	private $_model;
        public function loadModel($id)
        {
                if($this->_model===null)
                {
                        if(isset($_GET['id']))
                        {
                                if(Yii::app()->user->isGuest)
                                        $condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
                                else
                                        $condition='';
                                $this->_model=Post::model()->findByPk($_GET['id'], $condition);
                        }
                        //      $model=Post::model()->findByPk($id);
                        if($this->_model===null)
                                throw new CHttpException(404,'The requested page does not exist.');
                }
                return $this->_model;
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();//deletes row corresponding to this model

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('post_id='.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
					'condition'=>'status='.Post::STATUS_PUBLISHED,
					'order'=>'update_time DESC',
					'with'=>'commentCount',
					));
		if(isset($_GET['tag']))
			$criteria->addSearchCondition('tags',$_GET['tag']);//searches column tags for $_get[tag]

		$dataProvider=new CActiveDataProvider('Post', array(
					'pagination'=>array(//calls class cpagination	
						'pageSize'=>5,//property of cpagination class
						),
					'criteria'=>$criteria,
					));		
		$this->render('index',array(
					'dataProvider'=>$dataProvider,//can use variable $dataProvider in view index
					));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');//???
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
		{
			$model->attributes=$_GET['Post'];
		//	$model->author_id=Yii::app()->user->id;
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSearch()
	{
		//$this->createUrl('/post/search',array('q'=>$_GET['Post']['title']));
		$criteria=new CDbCriteria;
                $criteria->compare('title',$_GET['Post']['title'],true);
                $dataProvider=new CActiveDataProvider('Post',array(
                        'criteria'=>$criteria,
                ));
		$this->render('search',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
