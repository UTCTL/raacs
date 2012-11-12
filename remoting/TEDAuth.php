<?php
include_once 'db/UsersVO.php';

class TEDAuth extends Zend_Amf_Auth_Abstract
{
	
	public function authenticate()
	{
		try	
		{
			//$this->_username = addcslashes($this->_username, '');
			//$this->_password = addcslashes($this->_password, "\"':;");
			$ldapconn = ldap_connect('ldaps://entdir.utexas.edu', 636);
			
			// bind with service account
			$ldapbind = ldap_bind($ldapconn,BIND_ID,BIND_PASS);
			$search = ldap_search($ldapconn, 'dc=entdir,dc=utexas,dc=edu', "uid=$this->_username"); 
			$entries = ldap_get_entries($ldapconn, $search);
			
			//Authenticate EID with TED
			if($entries["count"])
			{
				$user_info = $entries[0];
				$user_auth = ldap_bind($ldapconn,$user_info["dn"],$this->_password);
			}	
			else
				throw new Exception("Invalid EID");
		
			ldap_unbind($ldapconn);
		}
		catch(Exception $e)
		{
			return new Zend_Auth_Result(Zend_Auth_Result::FAILURE,$this->_username,array($this->_password,$this->_username));
		}
		
			
		if($user_auth)
		{	
			
			$user = new UsersVO();
			$identity = new stdClass();
			
			$query = DBConn::get()->prepare("SELECT * FROM users WHERE uin=? LIMIT 1");
			$query->execute(array($user_info["utexasedupersonuin"][0]));
			$query->setFetchMode(PDO::FETCH_INTO,$user);
			
			if($query->fetch())
			{
				$identity->id = $user->id;
				$identity->role = $this->translateRole($user->role);
				
				return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,$identity);
			}
			else
			{
				$user->first_name = $user_info["givenname"][0];
				$user->last_name = $user_info["sn"][0];
				$user->uin = $user_info["utexasedupersonuin"][0];
				$user->eid = $user_info["uid"][0];
				$user->password = NULL;
				
				/*if(array_search("faculty",$user_info["edupersonaffiliation"]))
					$user->role = 2;
					else*/
				$user->role = 1;
				
				if($user->add())
				{
					$identity->id = $user->id;
					$identity->role = $this->translateRole($user->role);
					
					return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,$identity);
				}
					
			}
			
		}
		
		
		return new Zend_Auth_Result(Zend_Auth_Result::FAILURE,$this->_username);
	}
	
	private function translateRole($roleInt)
	{
		switch($roleInt)
		{
			case 1:
				return "student";
			case 2:
				return "professor";
			case 3:
				return "admin";
		}
	}
	
	
}


?>