<?php

include_once('DBConn.php');

class Comments
{
	public $id;
	public $answer_id;
	public $creator_id;
	public $media_type;
	public $comment;
	public $timestamp;	
	
	protected $db_connection;
	
	const TABLE = "comments";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `comments` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `comments` (`answer_id`,`creator_id`,`media_type`,`comment`) VALUES (?,?,?,?)");
			$query->execute(array($this->answer_id, $this->creator_id, $this->media_type, $this->comment));
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
			$query = $this->db_connection->prepare("UPDATE `comments` SET `answer_id` = ?, `creator_id` = ?, `media_type` = ?, `comment` = ? WHERE `id` = ?");
			$query->execute(array($this->answer_id, $this->creator_id, $this->media_type, $this->comment, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM comments WHERE `id` = ?");
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