<?php
define('DEBUG',1);
define('ZEND_PATH','../../../frameworks/zendframework/1.10');
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

function exception_error_handler($errno, $errstr, $errfile, $errline ) 
{
    throw new ErrorHandler($errstr, 0, $errno, $errfile, $errline);

	return true;
}

set_error_handler("exception_error_handler", E_ALL);

ini_set("include_path",ini_get("include_path").":".ZEND_PATH.":db");

//require_once 'RaacsAmfServer.php';
require_once 'Zend/Amf/Server.php';
require_once 'Zend/Session.php';

//require_once 'Zend/Acl.php';
//require_once 'Zend/Amf/Auth/Abstract.php';
require_once 'DataServices.php';


function __autoload($className){
	
	$fileName = $className.".php";
	include_once($fileName);
	}

/*$acl = new Zend_Acl();
$acl->addRole(new Zend_Acl_Role("student"));
$acl->addRole(new Zend_Acl_Role("professor"),"student");
$acl->addRole(new Zend_Acl_Role("admin"));*/

$server = new Zend_Amf_Server();

//$server->setAuth(new TEDAuth());
//$server->setAcl($acl);

//ZEND AMF Browser
/*if(DEBUG)
{
	require_once( "browser/ZendAmfServiceBrowser.php" );
	$server->setClass( "ZendAmfServiceBrowser" );
	ZendAmfServiceBrowser::$ZEND_AMF_SERVER = $server;
}*/
//////////////////
Zend_Session::start();
$server->setSession();

$server->setClass("DataServices");

$server->setClassMap("LoginVO","LoginVO");
$server->setClassMap("AuthUserVO","AuthUserVO");
$server->setClassMap("AnswersVO","AnswersVO");
$server->setClassMap("GroupsVO","GroupsVO");
$server->setClassMap("QuizzesUsersVO","QuizzesUsersVO");
$server->setClassMap("QuizForUserVO","QuizForUserVO");
$server->setClassMap("QuizzesVO","QuizzesVO");
$server->setClassMap("QuestionInQuizVO","QuestionInQuizVO");
$server->setClassMap("QuestionPartsVO","QuestionPartsVO");

if(DEBUG)
	$server->setProduction(false);

$response = $server->handle();
echo $response;
?>
