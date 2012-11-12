<?php

class DBConn {

	private static $db;
	
	final private function __construct(){}
	final private function __clone(){}

	public static function get(){
		
		if(is_null(self::$db)){
			
			self::$db = new PDO('mysql:dbname=raacs;host=localhost','raacs_user','(a)>"Q!a@,Wtbq6');
			}
			
		return self::$db;
		}
}
