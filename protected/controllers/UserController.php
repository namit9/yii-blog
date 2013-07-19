<?php

class UserController extends Controller
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
				'actions'=>array('create'),
				'users'=>array('?'),//? for guests
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('update'),
				'users'=>array('@'),
				'expression'=>'$_GET["id"]==Yii::app()->user->id',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
			//	'actions'=>array('admin','delete'),
				'users'=>array('namit'),
			),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'posts'=>Post::model()->posts($id),
		));
	}

/*	protected function userPosts($id)
	{
		$posts=Post::model()->findAll(array('condition'=>'author_id=:id','order'=>'update_time DESC','params'=>array(':id'=>$id)));
		return $posts;
	}*/
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
		//	$model->password=$model->hashPassword($_POST['User']['password']);//$_POST['Post'] returns an array
			if($model->save())
				$this->redirect(array('post/index'));
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
//		if($id==Yii::app()->user->id)
//		{
			$model=$this->loadModel($id);
//			User::model()->oldPassword=$model->password;
			$model->unsetAttributes(array('password'));

			// Uncomment the following line if AJAX validation is needed
			 $this->performAjaxValidation($model);

			if(isset($_POST['User']))
			{
			//	if(User::model()->hashPassword($_POST['User']['password'])!=$oldPassword)
			//		$model->addError('password','The old password does not match');
				$model->attributes=$_POST['User'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}

			$this->render('update',array(
				'model'=>$model,
			));
//		}
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array(''));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
