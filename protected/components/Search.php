<?php 
Yii::import('zii.widgets.CPortlet');

class Search extends CPortlet
{
	public function searchUser()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('r',User::model()->username,true);
		return new CActiveDataProvider('User',array(
			'criteria'=>$criteria,	
		));
	}

	public function searchPost()
        {
                $criteria=new CDbCriteria;      
                $criteria->compare('r',Post::model()->title,true);
                return new CActiveDataProvider('Post',array(    
                        'criteria'=>$criteria,
                ));
        }
	public function searchTag()
        {
                $criteria=new CDbCriteria;      
                $criteria->compare('r',Tag::model()->name,true);
                return new CActiveDataProvider('Post',array(    
                        'criteria'=>$criteria,
                ));
        }
	protected function renderContent()
	{
		$this->render();
}

