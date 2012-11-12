<?php
include_once('generated/Answers.php');

class AnswersVO extends Answers
{
	public $title;
	public $order;
	
	public $comments;
	
	public function getComments()
	{
		$query = $this->db_connection->prepare("SELECT comments.*,CONCAT(users.first_name,' ',users.last_name) as creator_name FROM `comments`,users WHERE comments.creator_id = users.id AND comments.answer_id = ?");
		$query->execute(array($this->id));
		$query->setFetchMode(PDO::FETCH_CLASS,"CommentsVO");
		$this->comments = $query->fetchAll();
	}
	
	public function getUserAnswers($quiz_id,$user_id)
	{
		$query = $this->db_connection->prepare("SELECT `answers`.*,`questions_quizzes`.`order`,`questions`.`title` 
			FROM `answers` LEFT JOIN `questions_quizzes` ON (`answers`.`questions_quiz_id` = `questions_quizzes`.`id`) LEFT JOIN `questions` ON (`questions_quizzes`.`question_id` = `questions`.`id`)
			WHERE `answers`.`user_id` = ? AND `questions_quizzes`.`quiz_id` = ?
			ORDER BY `questions_quizzes`.`order`");
		$query->execute(array($user_id,$quiz_id));
		$query->setFetchMode(PDO::FETCH_CLASS,"AnswersVO");
		
		return $query->fetchAll();
	}
}
?>