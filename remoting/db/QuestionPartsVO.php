<?php
include_once('generated/QuestionParts.php');

class QuestionPartsVO extends QuestionParts
{
	
	public $deleteFlag;
	
	public function getUntimedMedia()
	{
		$query = $this->db_connection->prepare("SELECT * FROM `question_parts` WHERE media IS NOT NULL AND duration IS NULL");
		$query->execute();
		$query->setFetchMode(PDO::FETCH_CLASS,"QuestionPartsVO");
		
		return $query->fetchAll();
	}

	public function __sleep()
	{
		return array('question_id','part_order','media','media_type','in_point','out_point','duration','stop_at_end');
	}
	
	public function __wakeup()
	{
		$this->db_connection = DBConn::get();
	}
}
?>