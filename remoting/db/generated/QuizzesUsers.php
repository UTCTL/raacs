<?php

include_once('DBConn.php');

class QuizzesUsers
{
	public $id;
	public $user_id;
	public $quiz_id;
	public $override_publish_start;
	public $override_publish_end;
	public $grade;
	public $status;	
	
	protected $db_connection;
	
	const TABLE = "quizzes_users";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `quizzes_users` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `quizzes_users` (`user_id`,`quiz_id`,`override_publish_start`,`override_publish_end`,`grade`,`status`) VALUES (?,?,?,?,?,?)");
			$query->execute(array($this->user_id, $this->quiz_id, $this->override_publish_start, $this->override_publish_end, $this->grade, $this->status));
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
			$query = $this->db_connection->prepare("UPDATE `quizzes_users` SET `user_id` = ?, `quiz_id` = ?, `override_publish_start` = ?, `override_publish_end` = ?, `grade` = ?, `status` = ? WHERE `id` = ?");
			$query->execute(array($this->user_id, $this->quiz_id, $this->override_publish_start, $this->override_publish_end, $this->grade, $this->status, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM quizzes_users WHERE `id` = ?");
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