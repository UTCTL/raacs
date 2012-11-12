<?php
include_once('generated/Questions.php');

class QuestionsVO extends Questions
{
	public $parts;
	
	public function getAll()
	{
		$query = $this->db_connection->query("SELECT * FROM ".self::TABLE);
		$query->setFetchMode(PDO::FETCH_CLASS,"QuestionsVO");
		return $query->fetchAll();
	}
	
	public function getAllCreatedBy($user_id)
	{
		$query = $this->db_connection->prepare("SELECT * FROM ".self::TABLE." WHERE creator_id = ? ORDER BY title");
		$query->execute(array($user_id));
		$query->setFetchMode(PDO::FETCH_CLASS,"QuestionsVO");
		return $query->fetchAll();
	}
	
	//TODO: This is duplicated in QuestionInQuizVO
	public function getParts()
	{
		if($this->id)
		{
			$db = DBConn::get();
			$query = $db->prepare("SELECT * FROM question_parts WHERE question_id = ? ORDER BY part_order");
			$query->execute(array($this->id));
			$query->setFetchMode(PDO::FETCH_CLASS,"QuestionPartsVO");

			$this->parts = $query->fetchAll();
		}
	}
	
	public function __sleep()
	{
		return array('creator_id','title','text','picture','answer_type','shared','keywords','parts');
	}
	
	public function __wakeup()
	{
		$this->db_connection = DBConn::get();
	}
}
?>