<?php

include_once('DBConn.php');

class Quizzes
{
	public $id;
	public $group_id;
	public $title;
	public $instructions;
	public $publish_start;
	public $publish_end;	
	
	protected $db_connection;
	
	const TABLE = "quizzes";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `quizzes` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `quizzes` (`group_id`,`title`,`instructions`,`publish_start`,`publish_end`) VALUES (?,?,?,?,?)");
			$query->execute(array($this->group_id, $this->title, $this->instructions, $this->publish_start, $this->publish_end));
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
			$query = $this->db_connection->prepare("UPDATE `quizzes` SET `group_id` = ?, `title` = ?, `instructions` = ?, `publish_start` = ?, `publish_end` = ? WHERE `id` = ?");
			$query->execute(array($this->group_id, $this->title, $this->instructions, $this->publish_start, $this->publish_end, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM quizzes WHERE `id` = ?");
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