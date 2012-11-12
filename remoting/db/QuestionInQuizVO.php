<?php


class QuestionInQuizVO
{
	public $id;
	public $quiz_id;
	public $question_id;
	public $think_time;
	public $record_time;
	public $max_takes;
	public $total_points;
	public $order;
	public $title;
	public $text;
	public $answer_type;
	public $picture;
	
	public $parts;
	public $deleteFlag;
	
	public function getParts()
	{
		if($this->id)
		{
			$db = DBConn::get();
			$query = $db->prepare("SELECT * FROM question_parts WHERE question_id = ? ORDER BY part_order");
			$query->execute(array($this->question_id));
			$query->setFetchMode(PDO::FETCH_CLASS,"QuestionPartsVO");

			$this->parts = $query->fetchAll();
		}
	}
}
?>