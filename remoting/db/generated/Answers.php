<?php

include_once('DBConn.php');

class Answers
{
	public $id;
	public $user_id;
	public $questions_quiz_id;
	public $answer_media;
	public $duration;
	public $answer_type;
	public $timestamp;
	public $grade;
	public $total_points;	
	
	protected $db_connection;
	
	const TABLE = "answers";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `answers` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `answers` (`user_id`,`questions_quiz_id`,`answer_media`,`duration`,`answer_type`,`grade`,`total_points`) VALUES (?,?,?,?,?,?,?)");
			$query->execute(array($this->user_id, $this->questions_quiz_id, $this->answer_media, $this->duration, $this->answer_type, $this->grade, $this->total_points));
			$this->id = $this->db_connection->lastInsertId();
			
			if($this->id)
	        	return $this->id;
	        	else
	        		return 0;
		}
		else
			return 0;
	}
	
	public function edit()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("UPDATE `answers` SET `user_id` = ?, `questions_quiz_id` = ?, `answer_media` = ?, `duration` = ?, `answer_type` = ?, `grade` = ?, `total_points` = ? WHERE `id` = ?");
			$query->execute(array($this->user_id, $this->questions_quiz_id, $this->answer_media, $this->duration, $this->answer_type, $this->grade, $this->total_points, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM answers WHERE `id` = ?");
			$query->execute(array($this->id));
		}
	}
	
	public function save()
	{
		if($this->id)
			$this->edit();
			else
				$this->add();
	}
	
}
?>