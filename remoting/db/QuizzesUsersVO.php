<?php
include_once('generated/QuizzesUsers.php');

class QuizzesUsersVO extends QuizzesUsers
{
	public $first_name;
	public $last_name;
	
	public function getAllForQuiz($quiz_id)
	{
		$query = $this->db_connection->prepare("SELECT users.first_name,users.last_name,quizzes_users.* FROM users LEFT JOIN quizzes_users ON (users.id = quizzes_users.user_id) WHERE quizzes_users.quiz_id = ? AND quizzes_users.status >= 1");
		$query->execute(array($quiz_id));
		$query->setFetchMode(PDO::FETCH_CLASS, "QuizzesUsersVO");
		return $query->fetchAll();
	}
	
	public function getByQuizAndUserId($quiz_id,$user_id)
	{
		$query = $this->db_connection->prepare("SELECT * FROM quizzes_users WHERE quiz_id = ? AND user_id = ? LIMIT 1");
		$query->execute(array($quiz_id,$user_id));
		$query->setFetchMode(PDO::FETCH_INTO, $this);
		return $query->fetch();
	}
}
?>