<?php
include_once('generated/Comments.php');

class CommentsVO extends Comments
{
	public $creator_name;
	
	public function getWithCreatorName()
	{
		$query = $this->db_connection->prepare("SELECT comments.*,CONCAT(users.first_name,' ',users.last_name) as creator_name FROM `comments`,users WHERE comments.creator_id = users.id AND comments.id = ?");
		$query->execute(array($this->id));
		$query->setFetchMode(PDO::FETCH_INTO,$this);
		$query->fetch();
	}
}
?>