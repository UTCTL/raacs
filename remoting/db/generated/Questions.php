<?php

include_once('DBConn.php');

class Questions
{
	public $id;
	public $creator_id;
	public $title;
	public $text;
	public $picture;
	public $answer_type;
	public $shared;
	public $keywords;	
	
	protected $db_connection;
	
	const TABLE = "questions";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `questions` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `questions` (`creator_id`,`title`,`text`,`picture`,`answer_type`,`shared`,`keywords`) VALUES (?,?,?,?,?,?,?)");
			$query->execute(array($this->creator_id, $this->title, $this->text, $this->picture, $this->answer_type, $this->shared, $this->keywords));
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
			$query = $this->db_connection->prepare("UPDATE `questions` SET `creator_id` = ?, `title` = ?, `text` = ?, `picture` = ?, `answer_type` = ?, `shared` = ?, `keywords` = ? WHERE `id` = ?");
			$query->execute(array($this->creator_id, $this->title, $this->text, $this->picture, $this->answer_type, $this->shared, $this->keywords, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM questions WHERE `id` = ?");
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