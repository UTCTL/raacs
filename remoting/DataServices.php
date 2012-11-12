<?php

class DataServices
{
	
	private $auth_user_id;
	
	public function __construct()
	{
		/*if(Zend_Auth::getInstance()->hasIdentity())
			$this->auth_user_id = Zend_Auth::getInstance()->getIdentity()->id;*/
	
		if(isset($_SESSION['user_id']))
			$this->auth_user_id = $_SESSION['user_id'];
	}
	
	/*public function initACL($acl)
	{
		$acl->allow('admin');
		$acl->allow('professor');
		$acl->allow('student');
		
		return true;
	}*/
	
	public function callback($string)
	{
		return $string;
	}
	
	protected function testAuth()
	{
		if(!isset($_SESSION['user_id']))
			throw new Exception("Auth.Required",311001);
	}
	
	public function getUserInfo()
	{
		$this->testAuth();	
		$user = new UsersVO($this->auth_user_id);
		
		return $user->getAuthUser();
	}
		
	public function authenticate($loginInfo)
	{	
		$user = new UsersVO();
		$user->eid = $loginInfo->userName;
		$user->password = $loginInfo->password;
		
		return $user->authenticate();
	}
	
	public function authenticate_test()
	{
		$user = new UsersVO();
		return $user->authenticate_test();
	}
	
	public function sessionLogout()
	{
		//Zend_Auth::getInstance()->clearIdentity();
		unset($_SESSION['user_id']);
	}
	
	//Student Module Services
	
	public function getStudentAssignments()
	{
		$this->testAuth();
		
		$user = new UsersVO($this->auth_user_id);
		
		return $user->getAssignments();
	}
	
	public function setAssignmentStatus($quiz_id,$status)
	{
		$this->testAuth();
		$a = new QuizzesUsersVO();
		if(!$a->getByQuizAndUserId($quiz_id,$this->auth_user_id))
		{
			$a->quiz_id = $quiz_id;
			$a->user_id = $this->auth_user_id;
		}
			
		$a->status = $status;
		$a->save();
		
		return $status;
	}
	
	public function getQuiz($quiz_id)
	{
		$this->testAuth();
				
		$quiz = new QuizzesVO($quiz_id);
		$quiz->publish_start = new DateTime($quiz->publish_start,new DateTimeZone("America/Chicago"));
		$quiz->publish_end = new DateTime($quiz->publish_end,new DateTimeZone("America/Chicago"));
		
		$quiz->getQuestions(true);
		return $quiz;	
	}
	
	public function getAnswers($quiz_id)
	{
		$this->testAuth();
		$a = new AnswersVO();
		
		$answers = $a->getUserAnswers($quiz_id,$this->auth_user_id);
		
		foreach($answers as $ans)
		{
			$ans->getComments();
		}
		
		return $answers;
	}
	
	public function saveAnswer($answer)
	{
		$this->testAuth();
		$answer->user_id = $this->auth_user_id;
		$answer->save();
	}
	
	public function clearAnswers($quiz_id)
	{
		$this->testAuth();
		$qu = new QuizzesUsersVO();
		if($qu->getByQuizAndUserId($quiz_id,$this->auth_user_id))
		{
			$qu->status = 0;
			$qu->save();
		}
			
		
		$a = new AnswersVO();
		$answers = $a->getUserAnswers($quiz_id,$this->auth_user_id);
		
		foreach($answers as $ans)
		{
			$ans->remove();
		}
		
		return $answers;
		
		
	}
	
	//Admin Module Services
	public function getAllUsers()
	{
		$this->testAuth();
		$u = new UsersVO();
		return $u->getAll();
	}
	
	public function removeUsers($users)
	{
		$this->testAuth();
		$removed = array();
		
		foreach($users as $u)
		{
			$u->remove();
			
		}
	}
	
	
	public function getGroups()
	{
		$this->testAuth();
		$g = new GroupsVO();
		
		return $g->getGroupsForUser($this->auth_user_id,true);
	}
	
	public function createGroup($group_obj)
	{
		
	}
	
	public function removeGroup($group_obj)
	{
		
	}
	
	public function updateGroupAdmin($user_id,$group_id,$admin)
	{
		$this->testAuth();
		$g = new GroupsVO($group_id);
		$u = new UsersVO($this->auth_user_id);
		
		if($u->role == 3 || $g->isAdmin($this->auth_user_id))
		{
			return $g->updateAdmin($user_id,$admin);
		}
		else
			return false;
	}
	
	public function getUsersForGroup($group_obj)
	{
		$this->testAuth();
		return $group_obj->getUsers();
	}
	
	public function addUsersToGroup($group_id,$search_info)
	{
		$this->testAuth();
		$u = new UsersVO();
		$results = $u->directorySearch($search_info);
		
		$c = count($results);
		
		if($c > 0)
		{
			$g = new GroupsVO($group_id);
			return $g->addUsers($results);
		}
		else
			return false;
		
	}
	
	public function removeUsersFromGroup($group_id,$users)
	{
		$this->testAuth();
		$g = new GroupsVO($group_id);
		
		$g->removeUsers($users);
	}
	
	public function getQuizzesForGroup($group_obj)
	{
		$this->testAuth();
		return $group_obj->getQuizzes();
	}
	
	
	public function saveQuiz(QuizzesVO $quiz_obj)
	{
		$this->testAuth();
		if($quiz_obj)
		{
			Zend_Date::setOptions(array('format_type' => 'php'));
			
			//convert DateTime objects back to strings for the database
			$quiz_obj->publish_start = $quiz_obj->publish_start->toString('Y-m-d H:i:s');
			$quiz_obj->publish_end = $quiz_obj->publish_end->toString('Y-m-d H:i:s');
			
			$quiz_obj->save();
		}
			
		
		//TODO: Update for all attributes of QuestionsQuizzesVO	
		foreach($quiz_obj->questions as $q)
		{
			$temp = new QuestionsQuizzesVO();
			$temp->id = $q->id;
			$temp->quiz_id = $quiz_obj->id;
			$temp->question_id = $q->question_id;
			$temp->order = $q->order;
			
			if($temp->id && $q->deleteFlag)
				$temp->remove();
				else
					$temp->save();
		}
	}
	
	public function removeQuiz(QuizzesVO $quiz_obj)
	{
		
	}
	
	public function loadUserQuizStatuses(QuizzesVO $quiz_obj)
	{
		$this->testAuth();
		$q = new QuizzesUsersVO();
		return $q->getAllForQuiz($quiz_obj->id);
	}
	
	public function adminGetAnswers(QuizzesUsersVO $qu)
	{
		$this->testAuth();
		$a = new AnswersVO();

		$answers = $a->getUserAnswers($qu->quiz_id,$qu->user_id);
		
		foreach($answers as $ans)
		{
			$ans->getComments();
		}
		
		return $answers;
		
	}
	
	public function saveComment(CommentsVO $comment)
	{
		$this->testAuth();
		$comment->creator_id = $this->auth_user_id;
		$comment->save();
		
		$comment->getWithCreatorName();
		
		return $comment;
	}
	
	
	public function getQuestionLibrary()
	{
		$this->testAuth();
		$q = new QuestionsVO();
		return $q->getAll();
		//return $q->getAllCreatedBy($this->auth_user_id);
	}
	
	public function getQuestionParts(QuestionsVO $q)
	{
		$this->testAuth();
		$q->getParts();
		
		return $q;
	}
	
	public function saveQuestion(QuestionsVO $q)
	{
		$this->testAuth();
		$q->creator_id = $this->auth_user_id;
		
		if($q)
			$q->save();
			
		foreach($q->parts as $p)
		{
			$p->question_id = $q->id;
			
			if($p->id && $p->deleteFlag)
				$p->remove();
				else
					$p->save();
		}
	}
	
	
	
	public function getUntimedMedia()
	{
		$this->testAuth();
		$p = new QuestionPartsVO();
		
		return $p->getUntimedMedia();
	}
	
	public function updateQuestionPart($part)
	{
		$this->testAuth();
		$part->edit();
	}
	
	
	
	
}