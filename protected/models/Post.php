<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $author_id
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property User $author
 */
class Post extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}
	
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, status', 'required'),
	//		array('status, create_time, update_time, author_id', 'numerical', 'integerOnly'=>true),
			array('status','in','range'=>array(1,2,3)),
			array('tags','match','pattern'=>'/^[\w\s,]+$/','message'=>'Tags can only contain word characters.'),
			array('tags','normalizeTags'),
			array('title', 'length', 'max'=>128),
			array('tags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title, status', 'safe', 'on'=>'search'),//rule applied in search scenario
		);
	}

	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id','condition'=>'comments.status='.Comment::STATUS_APPROVED,'order'=>'comments.create_time DESC'),
			'commentCount'=>array(self::STAT, 'Comment', 'post_id','condition'=>'status='.Comment::STATUS_APPROVED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
		);
	}

	public function getUrl()
	{
		return Yii::app()->createUrl('post/view',array('id'=>$this->id,'title'=>$this->title,));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
			}
			else
				$this->update_time=time();
			return true;
		}
		else
			return false;
	}
	
	public function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	private $_oldTags;

	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
	}

	public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])//defined in params in main.php
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		$comment->post_id=$this->id;
		return $comment->save();//saves record in database as a row
	}
	
	public function posts($id)
	{
		$criteria=new CDbCriteria(array(
                                        'condition'=>'author_id='.$id.' and status='.Post::STATUS_PUBLISHED,
                                        'order'=>'update_time DESC',
                        ));
            //    if(isset($_GET['tag']))
            //            $criteria->addSearchCondition('tags',$_GET['tag']);

                $dataProvider=new CActiveDataProvider('Post',array(
                                        'criteria'=>$criteria,
                        ));
		return $dataProvider;
	}
	//used in access rules so user can only update,delete his/her posts
	public function allow($id)
	{
		$model=Post::model()->findByPk($id);
		return $model->author_id;
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
		
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

	//	$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);//true because it uses like property
	//	$criteria->compare('content',$this->content,true);
	//	$criteria->compare('tags',$this->tags,true);
		$criteria->compare('status',$this->status);
	//	$criteria->compare('create_time',$this->create_time);
	//	$criteria->compare('update_time',$this->update_time);
	//	$criteria->compare('author_id',$this->author_id);
		$criteria->addCondition('author_id='.Yii::app()->user->id);

		return new CActiveDataProvider($this, array(//$this refers to a model instance that holds the search parameters.It is not a model instance that has been retrieved from the database.
			'criteria'=>$criteria,
		));
	}
}
