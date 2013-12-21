<?php

$dPconfig['dbtype'] = 'mysql'; 
$dbhost = "localhost";
$dbuser = "adminHdDH4wG";
$dbpass = "ETu6-5dLEvIk";
$dbname = "php";
$dPconfig['dbpersist'] = false; 

/* 
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Loginbase";*/

$conn = mysql_pconnect($dbhost, $dbuser, $dbpass) or die(mysql_error()); 

//mysql_select_db($dbname)or die(mysql_error());
$db = mysql_select_db($dbname);
if(!$db) {
die("Unable to select database");
}

//Connect to mysql server

$serverRoot = "/";
$imgpath = "";

$root_folder_include = $serverRoot."";
/* define('JOBSITE_DIR', $root_folder_include);
define("PAGE_LIMIT",'10');
define("LINK_COUNT",'4');

putenv("TZ=Europe/Copenhagen");


if ($_REQUEST['language'] != null && $_REQUEST['language'] != "")	
$_SESSION['languageTemp'] = $_REQUEST['language'];
$language = $_SESSION['languageTemp'];	
if ($language == "" || $language == null)	
{
$_SESSION['languageTemp'] = "english";//english//danish
$language = $_SESSION['languageTemp'];
}
*/


?>
