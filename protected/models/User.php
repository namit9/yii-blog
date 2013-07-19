<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $profile
 *
 * The followings are the available model relations:
 * @property Post[] $posts
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $newPassword;
	public $confirmNewPassword;
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return array(
			array('username, password, email', 'required'),
	//		array('newPassword, confirmNewPassword','required','on'=>'update'),
			array('username, password, email', 'length', 'max'=>128),
			array('newPassword,confirmNewPassword','length','max'=>128,'on'=>'update'),
			array('username','unique','message'=>'Username already exists!'),
			array('email','email'),
			array('email','unique','message'=>'Email already exists!'),
			array('profile', 'safe'),
	//		array('password','compareOldPassword'),
			array('confirmNewPassword','compare','compareAttribute'=>'newPassword','message'=>'The two passwords do not match','on'=>'update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, profile', 'safe', 'on'=>'search'),
		);
	}
	public function compareOldPassword($attribute,$params)
	{
		$this->password=$this->oldPassword($_GET["id"]);
		if(!$this->validatePassword($attribute))
		{
			$this->addError('password','The old password does not match');

		}
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
			'postCount'=>array(self::STAT,'Post','author_id','condition'=>'status='.Post::STATUS_PUBLISHED),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'profile' => 'Profile',
		);
	}
	public function oldPassword($id)
	{
		$model=User::model()->findByPk($id);
		return $model->password;
	}
	
	protected function beforeSave()
        {
                if(parent::beforeSave())
                {
                        if(!$this->isNewRecord)
			{
				$this->password=$this->oldPassword($_GET["id"]);
				if(!$this->validatePassword($_POST['User']['password']))
				{
					$this->addError('password','The old password does not match');	
				return false;
				}
			
				if(isset($_POST['User']['newPassword']) && $_POST['User']['newPassword']!=NULL)
                               	{
				 	$this->password=$this->hashPassword($_POST['User']['newPassword']);//$_POST['Post'] returns an array
                        	return true;
				}
				else
				{
					if($_POST['User']['newPassword']==NULL && $_POST['User']['confirmNewPassword']==NULL)
						 $this->password=$this->hashPassword($_POST['User']['password']);
				return true;
				}
			}
			else
			{	
				$this->password=$this->hashPassword($_POST['User']['password']);
			return true;
               		}
		 }	
                else
                        return false;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('profile',$this->profile,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
        {
                return crypt($password,$this->password)===$this->password;
        }

        public function hashPassword($password)
        {
                return crypt($password,'$2a$10$JTJf6/XqC94rrOtzuF397O');
        }

}
