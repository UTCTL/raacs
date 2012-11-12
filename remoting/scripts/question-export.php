<?php
error_reporting(E_ALL|E_STRICT);
ini_set("display_errors","on");
ini_set("include_path",ini_get("include_path").":../db");

include("QuestionsVO.php");
include("QuestionPartsVO.php");

$vo = new QuestionsVO();

$db = DBConn::get();

$query = $db->query("SELECT * FROM `questions` WHERE creator_id = 1");
$query->setFetchMode(PDO::FETCH_CLASS,"QuestionsVO");

$list = $query->fetchAll();

foreach($list as $q)
{
	$q->getParts();
	
}

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="export.txt"');

echo serialize($list);



?>