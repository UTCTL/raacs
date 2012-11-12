<?php

include_once('DBConn.php');

class QuestionsQuizzes
{
	public $id;
	public $quiz_id;
	public $question_id;
	public $think_time;
	public $record_time;
	public $max_takes;
	public $total_points;
	public $order;	
	
	protected $db_connection;
	
	const TABLE = "questions_quizzes";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `questions_quizzes` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `questions_quizzes` (`quiz_id`,`question_id`,`think_time`,`record_time`,`max_takes`,`total_points`,`order`) VALUES (?,?,?,?,?,?,?)");
			$query->execute(array($this->quiz_id, $this->question_id, $this->think_time, $this->record_time, $this->max_takes, $this->total_points, $this->order));
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
			$query = $this->db_connection->prepare("UPDATE `questions_quizzes` SET `quiz_id` = ?, `question_id` = ?, `think_time` = ?, `record_time` = ?, `max_takes` = ?, `total_points` = ?, `order` = ? WHERE `id` = ?");
			$query->execute(array($this->quiz_id, $this->question_id, $this->think_time, $this->record_time, $this->max_takes, $this->total_points, $this->order, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM questions_quizzes WHERE `id` = ?");
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