<?php

define('DEBUG',1);
define('ZEND_PATH','../../frameworks/latest');
define('BIND_ID','uid=4975nhmf,ou=services,dc=entdir,dc=utexas,dc=edu');
define('BIND_PASS','znpae#ptiy#fjrc#=x=2dxwqs2r!pat;ya');

class ErrorHandler extends Exception {
    protected $severity;
   
    public function __construct($message, $code, $severity, $filename, $lineno) {
        $this->message = $message;
        $this->code = $code;
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
    }
   
    public function getSeverity() {
        return $this->severity;
    }
}



if(DEBUG)
{
	error_reporting(E_ALL|E_STRICT);
	ini_set("display_errors","on");
}

function exception_error_handler($errno, $errstr, $errfile, $errline ) {    

	throw new ErrorHandler($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler("exception_error_handler", E_ALL);

ini_set("include_path",ini_get("include_path").":".ZEND_PATH.":db");


function __autoload($className){
	
	$fileName = $className.".php";
	include_once($fileName);
	
	}


$ds = new DataServices();

$ds->authenticate_test();

$obj = new stdClass();
$obj->f = "utexasEduPersonClassUniqueNbr";
$obj->s = "75385";

$ds->addUsersToGroup(2,$obj);

print_r($ds->getUsersForGroup(new GroupsVO(2)));








?>