<?php
include_once('generated/Groups.php');

class GroupsVO extends Groups
{
	public function getGroupsForUser($user_id,$admin=false)
	{
		$u = new UsersVO($user_id);
		$adminRestrict = "";
		
		if($admin)
			$adminRestrict = "AND groups_users.group_admin = 1";
		
		if($u->role < 3)
			$query = $this->db_connection->prepare("SELECT groups.* FROM groups,groups_users WHERE groups.id = groups_users.group_id AND groups_users.user_id = ? $adminRestrict ORDER BY groups.id DESC");
			else
				$query = $this->db_connection->prepare("SELECT * FROM groups ORDER BY groups.id DESC");
				
			
		$query->execute(array($user_id));
		$query->setFetchMode(PDO::FETCH_CLASS,"GroupsVO");
		
		return $query->fetchAll();
	}
	
	public function getUsers()
	{
		$query = $this->db_connection->prepare("SELECT users.*,groups_users.group_admin FROM users,groups_users WHERE groups_users.group_id = ? AND users.id = groups_users.user_id");
			
		
		$query->execute(array($this->id));
		$query->setFetchMode(PDO::FETCH_CLASS,"UsersVO");
	
		$users = array();
		while($user = $query->fetch())
		{
			//must cast this to get the proper type instead of string
			$user->group_admin = (bool)$user->group_admin;
			$users[] = $user;
		}
		
		return $users;
		
	}
	
	public function isAdmin($user_id)
	{
		$query = $this->db_connection->prepare("SELECT * FROM groups_users WHERE user_id = ? AND group_id = ? AND group_admin = 1");
		$query->execute(array($user_id,$this->id));
		
		if($query->fetch())
			return true;
			else
				return false;
	}
	
	public function updateAdmin($user_id,$group_admin)
	{
		$query = $this->db_connection->prepare("SELECT * FROM groups_users WHERE user_id = ? AND group_id = ?");
		$query->execute(array($user_id,$this->id));
		$query->setFetchMode(PDO::FETCH_CLASS,"GroupsUsersVO");
		
		if($gu = $query->fetch())
		{
			$gu->group_admin = $group_admin;
			$gu->save();
		}
		
	}
	
	public function addUsers($user_array)
	{
		$users_added = 0;
		
		foreach($user_array as $u)
		{
			if(!$u->checkUIN())
			{
				$u->add();	
			}
			else
			{
				//echo "User ".$u->id." Exists\n";
			}	
				
			$gu = new GroupsUsersVO();
			$gu->group_id = $this->id;
			$gu->user_id = $u->id;
			$gu->group_admin = 0;
			
			if($gu->add())
				$users_added++;
		}
		
		return $users_added;
	}
	
	public function removeUsers($user_array)
	{
		foreach($user_array as $u)
		{
			$query = $this->db_connection->prepare("DELETE comments FROM comments LEFT JOIN answers ON (comments.answer_id = answers.id) LEFT JOIN questions_quizzes ON (answers.questions_quiz_id = questions_quizzes.id) WHERE questions_quizzes.quiz_id IN (SELECT id from quizzes WHERE group_id = ?) AND answers.user_id = ?");
			$query->execute(array($this->id,$u->id));
			
			$query = $this->db_connection->prepare("DELETE answers 
													FROM answers LEFT JOIN questions_quizzes ON (answers.questions_quiz_id = questions_quizzes.id) 
													WHERE questions_quizzes.quiz_id IN (SELECT id from quizzes WHERE group_id = ?) AND answers.user_id = ?");
			$query->execute(array($this->id,$u->id));
			
			$query = $this->db_connection->prepare("DELETE FROM quizzes_users WHERE quiz_id IN (SELECT id from quizzes WHERE group_id = ?) AND user_id = ?");
			$query->execute(array($this->id,$u->id));
			
			$query = $this->db_connection->prepare("DELETE FROM groups_users WHERE group_id = ? AND user_id = ?");
			$query->execute(array($this->id,$u->id));
														
		}	
	}
	
	public function getQuizzes()
	{
		$query = $this->db_connection->prepare("SELECT * FROM quizzes WHERE group_id = ?");
		$query->execute(array($this->id));
		$query->setFetchMode(PDO::FETCH_CLASS,"QuizzesVO");
		
		$quizzes = array();
		
		while($q = $query->fetch())
		{
			$q->publish_start = new DateTime($q->publish_start,new DateTimeZone("America/Chicago"));
			$q->publish_end = new DateTime($q->publish_end,new DateTimeZone("America/Chicago"));
			
			$quizzes[] = $q;
		}
		
		return $quizzes;
	}
}
?>