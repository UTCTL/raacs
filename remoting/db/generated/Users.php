<?php

include_once('DBConn.php');

class Users
{
	public $id;
	public $last_name;
	public $first_name;
	public $eid;
	public $uin;
	public $role;
	public $password;	
	
	protected $db_connection;
	
	const TABLE = "users";
	
	public function __construct($id=NULL)
	{
		$this->db_connection = DBConn::get();
		$query = NULL;
		
		if($id)
		{
			$query = $this->db_connection->prepare("SELECT * FROM `users` WHERE `id` = ? LIMIT 1");
			$query->execute(array($id));
			$query->setFetchMode(PDO::FETCH_INTO,$this);
			$query->fetch();
		}
		
		
	}
	
	public function add()
	{
		if(!$this->id)
		{
			$query = $this->db_connection->prepare("INSERT INTO `users` (`last_name`,`first_name`,`eid`,`uin`,`role`,`password`) VALUES (?,?,?,?,?,?)");
			$query->execute(array($this->last_name, $this->first_name, $this->eid, $this->uin, $this->role, $this->password));
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
			$query = $this->db_connection->prepare("UPDATE `users` SET `last_name` = ?, `first_name` = ?, `eid` = ?, `uin` = ?, `role` = ?, `password` = ? WHERE `id` = ?");
			$query->execute(array($this->last_name, $this->first_name, $this->eid, $this->uin, $this->role, $this->password, $this->id));
		}
		
	}
	
	public function remove()
	{
		if($this->id)
		{
			$query = $this->db_connection->prepare("DELETE FROM users WHERE `id` = ?");
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