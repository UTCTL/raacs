<?php

include_once('As3ClassBuilder.php');
include_once('PhpClassBuilder.php');

$db = DBConn::get();

$table_query = $db->query("SHOW TABLES");

while($table = $table_query->fetch(PDO::FETCH_COLUMN))
{
	//$as3_class = new As3ClassBuilder($table,'as3','edu.utexas.raacs.model.vo');
	//$as3_class->writeClass();
	
	$php_class = new PhpClassBuilder($table,'../db',array('timestamp'));
	$php_class->writeClass();
}

copy("DBConn.php","../db/DBConn.php");

?>