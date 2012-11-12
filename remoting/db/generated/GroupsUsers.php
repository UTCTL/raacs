<?php

include_once('DBConn.php');

class GroupsUsers
{
	public $id;
	public $user_id;
	public $group_id;
	public $group_admin;	
	
	protected $db_connection;
	
	const TABLE = "groups_users";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `groups_users` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `groups_users` (`user_id`,`group_id`,`group_admin`) VALUES (?,?,?)");
			$query->execute(array($this->user_id, $this->group_id, $this->group_admin));
			$this->id = $this->db_connection->lastInsertId();
			
			if($this->id)
	        	return $this->id;
	        	else
	        		return 0;
		}
		else
			return 0;
	}
	
	public function edit()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("UPDATE `groups_users` SET `user_id` = ?, `group_id` = ?, `group_admin` = ? WHERE `id` = ?");
			$query->execute(array($this->user_id, $this->group_id, $this->group_admin, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM groups_users WHERE `id` = ?");
			$query->execute(array($this->id));
		}
	}
	
	public function save()
	{
		if($this->id)
			$this->edit();
			else
				$this->add();
	}
	
}
?>