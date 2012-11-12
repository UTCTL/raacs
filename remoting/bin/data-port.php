<?php
error_reporting(E_ALL|E_STRICT);
ini_set("display_errors","on");
ini_set("include_path",ini_get("include_path").":../db");

include("QuestionsVO.php");
include("QuestionPartsVO.php");

$server="belmondo.cit.utexas.edu";
$username="sope_user";
$password="frg4\$L7";


$sqlconnect=mysql_connect($server, $username, $password);
		
if( !$sqlconnect )
	throw new Exception( "cannot connect to mysql database" );

if( !mysql_select_db('sope_live') )
	throw new Exception( "cannot select sope database" );


$result = mysql_query("SELECT * FROM questions WHERE id >= 100");

if (!$result) {
    die('Invalid query: ' . mysql_error());
}

$qArray = array();

while($q = mysql_fetch_object($result)) 
{
	
	$sections = mysql_query("SELECT * FROM sections WHERE quesID = $q->id ORDER BY `order`");
	$q->sections = array();
	
	echo "Adding:{$q->title}\n";
	
	$newQues = new QuestionsVO();
	$newQues->creator_id = 1;
	$newQues->title = $q->title;
	$newQues->text = $q->blurb;
	$newQues->picture = $q->image;
	$newQues->answer_type = 1;
	
	$insert_id = $newQues->add();
	
	$parts = array();
	while($s = mysql_fetch_object($sections))
	{
		$p = new QuestionPartsVO();
		$p->question_id = $insert_id;
		$p->part_order = $s->order;
		$p->media_type = 1;
		$p->media = $s->audio;
		$parts[] = $p;
	}
	
	$parts[0]->add();
	
	$think = new QuestionPartsVO();
	$think->question_id = $insert_id;
	$think->part_order = 2;
	$think->media_type = 8;
	$think->duration = 60;
	
	$think->add();
	
	$parts[1]->part_order++;
	$parts[1]->add();
	
	$record = new QuestionPartsVO();
	$record->question_id = $insert_id;
	$record->part_order = 4;
	$record->media_type = 5;
	$record->duration = 120;
	
	$record->add();
	
}

exit;


?>