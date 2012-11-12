<?php
include_once('generated/Quizzes.php');

class QuizzesVO extends Quizzes
{
	
	public $questions;
	
	public function getQuestions($get_parts)
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("SELECT questions_quizzes.*,questions.title,questions.text,questions.answer_type,questions.picture FROM `questions_quizzes` LEFT JOIN `questions` ON questions_quizzes.question_id = questions.id WHERE questions_quizzes.quiz_id = ? ORDER BY questions_quizzes.order");
			$query->execute(array($this->id));
			$query->setFetchMode(PDO::FETCH_CLASS,"QuestionInQuizVO");

			$this->questions = $query->fetchAll();
		
			if($get_parts)
			{
				foreach($this->questions as $q)
				{
					$q->getParts();
				}
			}
			
		}
		
	}
}
?>