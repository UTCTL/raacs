<?php
include_once('generated/Users.php');

class UsersVO extends Users
{
	public $group_admin;
	
	public function getAll()
	{
		$query = $this->db_connection->query("SELECT * FROM users");
		$query->setFetchMode(PDO::FETCH_CLASS,"UsersVO");
		return $query->fetchAll();
	}
	
	public function getAuthUser()
	{
		$au = new AuthUserVO();
		$au->first_name = $this->first_name;
		$au->last_name = $this->last_name;
		
		if($this->role == 3)
			$au->role = $this->role;
		else
		{
			//if the user is the admin of any groups, access is allowed to the admin interface
			$query = $this->db_connection->prepare("SELECT * FROM groups_users WHERE user_id = ? AND group_admin = 1");
			$query->execute(array($this->id));
			
			if($query->fetch())
				$au->role = 2;
			else
				$au->role = 1;
		}
			
		$au->uin = $this->uin;
		
		return $au;
	}

	public function directorySearch($searchInfo)
	{
		$allowed_fields = array("uid","utexasEduPersonClassUniqueNbr");
		
		if(!in_array($searchInfo->f,$allowed_fields))
			return;
		
	
		$ldapconn = ldap_connect('ldaps://entdir.utexas.edu', 636);

		// bind with service account
		$ldapbind = ldap_bind($ldapconn,BIND_ID,BIND_PASS);
		$search = ldap_search($ldapconn, 'dc=entdir,dc=utexas,dc=edu', "$searchInfo->f=$searchInfo->s"); 
		$entries = ldap_get_entries($ldapconn, $search);	
	
		

		$users = array();
		
		//Map TED info into UsersVO Object
		for($i=0;$i<$entries["count"];$i++)
		{
			$user_info = $entries[$i];
			
			$temp = new UsersVO();
			$temp->first_name = $user_info["givenname"][0];
			$temp->last_name = $user_info["sn"][0];
			$temp->eid = $user_info["uid"][0];
			$temp->uin = $user_info["utexasedupersonuin"][0];
			$temp->role = 1;
			$users[] = $temp;
		}
		
		return $users;
	}
	
	//TODO: Should integrate this check into override of the add() function
	public function checkUIN()
	{
		
		$query = $this->db_connection->prepare("SELECT * FROM ".self::TABLE." WHERE uin=? LIMIT 1");
		$query->execute(array($this->uin));
		$query->setFetchMode(PDO::FETCH_COLUMN,0);
		
		$user = $query->fetch();
		if($user !== false){
			$this->id = $user;
			return true;
			}
			else
				return false;
	}
	
	public function getAssignments()
	{	
		$g = new GroupsVO();
		$groups = $g->getGroupsForUser($this->id);
		
		$vars = array();
		foreach($groups as $g)
		{
			$vars[] = $g->id;
		} 
		
		$numVars = count($vars);
		$ph = "";
		for($i=0;$i<$numVars;$i++)
		{
			$ph .= "?";
			
			if($i<$numVars-1)
				$ph.=',';
		}
	

		$query = $this->db_connection->prepare("SELECT * FROM quizzes WHERE group_id IN ($ph) ORDER BY quizzes.publish_end ASC");
		$query->execute($vars);
		$query->setFetchMode(PDO::FETCH_CLASS,"QuizForUserVO");
		
		$assignments = $query->fetchAll();
		
		//Get Status and Time overrides
		foreach($assignments as $a)
		{
			$query = $this->db_connection->prepare("SELECT * FROM quizzes_users WHERE user_id = ? AND quiz_id = ?");
			$query->execute(array($this->id,$a->id));
			$query->setFetchMode(PDO::FETCH_OBJ);
			$temp = $query->fetch();
			
			if($temp)
			{
				$a->status = $temp->status;
				$a->override_publish_start = $temp->override_publish_start;
				$a->override_publish_end = $temp->override_publish_end;
			}
			
			$a->publish_start = new DateTime($a->publish_start,new DateTimeZone("America/Chicago"));
			$a->publish_end = new DateTime($a->publish_end,new DateTimeZone("America/Chicago"));
		}
		
		return $assignments;
	}
	
	public function authenticate()
	{
		try	
		{
			$ldapconn = ldap_connect('ldaps://entdir.utexas.edu', 636);
			
			// bind with service account
			$ldapbind = ldap_bind($ldapconn,BIND_ID,BIND_PASS);
			$search = ldap_search($ldapconn, 'dc=entdir,dc=utexas,dc=edu', "uid=$this->eid"); 
			$entries = ldap_get_entries($ldapconn, $search);
			
			//Authenticate EID with TED
			if($entries["count"])
			{
				$user_info = $entries[0];
				$user_auth = ldap_bind($ldapconn,$user_info["dn"],$this->password);
			}	
			else
				throw new Exception("Invalid EID");
		
			ldap_unbind($ldapconn);
		}
		catch(Exception $e)
		{
			return false;
		}
		
			
		if($user_auth)
		{	
			
			$query = $this->db_connection->prepare("SELECT * FROM ".self::TABLE." WHERE uin=? LIMIT 1");
			$query->execute(array($user_info["utexasedupersonuin"][0]));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			
			if($query->fetch())
			{
				$_SESSION['user_id'] = $this->id;
				return true;
			}
			else
			{
				$this->first_name = $user_info["givenname"][0];
				$this->last_name = $user_info["sn"][0];
				$this->uin = $user_info["utexasedupersonuin"][0];
				$this->password = NULL;
				
				if(array_search("faculty",$user_info["edupersonaffiliation"]))
					$this->role = 2;
					else
						$this->role = 1;
				
				if($this->add())
				{
					$_SESSION['user_id'] = $this->id;
					return true;
				}
				else
					return false;
			}
			
		}
		else
		{
			return false;
		}
				
	}
	
	public function authenticate_test()
	{
		$_SESSION['user_id'] = 1;
		return true;
	}
	
	public function authenticate_test2()
	{
		$query = $this->db_connection->prepare("SELECT id FROM ".self::TABLE." WHERE eid=? LIMIT 1");
		$query->execute(array($this->eid));

		if($this->id = $query->fetchColumn(0))
		{
			$_SESSION['user_id'] = $this->id;
			return true;
		}
		else
			return false;
	}
	
	//Overrides
	public function remove()
	{
		$query1 = $this->db_connection->prepare("DELETE FROM quizzes_users WHERE user_id = ?");
		$query1->execute(array($this->id));
		$query2 = $this->db_connection->prepare("DELETE FROM answers WHERE user_id = ?");
		$query2->execute(array($this->id));
		$query3 = $this->db_connection->prepare("DELETE FROM groups_users WHERE user_id = ?");
		$query3->execute(array($this->id));
		
		parent::remove();
	}
	
	
}
?>