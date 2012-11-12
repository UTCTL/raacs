<?php

include_once('DBConn.php');

class QuestionParts
{
	public $id;
	public $question_id;
	public $part_order;
	public $media;
	public $media_type;
	public $in_point;
	public $out_point;
	public $duration;
	public $stop_at_end;	
	
	protected $db_connection;
	
	const TABLE = "question_parts";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `question_parts` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `question_parts` (`question_id`,`part_order`,`media`,`media_type`,`in_point`,`out_point`,`duration`,`stop_at_end`) VALUES (?,?,?,?,?,?,?,?)");
			$query->execute(array($this->question_id, $this->part_order, $this->media, $this->media_type, $this->in_point, $this->out_point, $this->duration, $this->stop_at_end));
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
			$query = $this->db_connection->prepare("UPDATE `question_parts` SET `question_id` = ?, `part_order` = ?, `media` = ?, `media_type` = ?, `in_point` = ?, `out_point` = ?, `duration` = ?, `stop_at_end` = ? WHERE `id` = ?");
			$query->execute(array($this->question_id, $this->part_order, $this->media, $this->media_type, $this->in_point, $this->out_point, $this->duration, $this->stop_at_end, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM question_parts WHERE `id` = ?");
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