<?php   
ob_start();
session_start();
error_reporting(0);
//error_reporting(E_ALL);
$hostname = 'localhost';


// $username = 'safetrak_root';
// $password ='nigeria123';
// //$password ='';
// $db_name = 'safetrak_dn';


$username = 'root';
$password ='';
//$password ='';
$db_name = 'promask';

global $obj;
		
ini_set('date.timezone', 'Asia/Kolkata');
require_once("db.class.php");
require_once("variable.php");
$obj = new DB($hostname, $username, $password, $db_name); 
@define('SITE_URL',"http://localhost/promask/");
@define('SITE_TITLE',"Promask");
$website_currency_code='<i class="fa fa-inr"></i>';
$website_currency_symbol="$";

?>
