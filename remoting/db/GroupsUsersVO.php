<?php
include_once('generated/GroupsUsers.php');

class GroupsUsersVO extends GroupsUsers
{
	//Override
	public function add()
	{
		//Prevents adding a User to a group more than once
		$query = $this->db_connection->prepare("SELECT * FROM groups_users WHERE user_id=? AND group_id=?");
		$query->execute(array($this->user_id,$this->group_id));
		
		if($query->fetch())
			return false;
		
		return GroupsUsers::add();	
		
	}
	
	
}
?>