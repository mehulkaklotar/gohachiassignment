<?php
include_once ("configure/configure.php");

if (!$_POST['emailsignin'] || !$_POST['passwordsignin']) {

	die('You did not complete all of the required fields');

} else {

	$sql = "select * from user where email ='" . $_POST['emailsignin'] . "'";
	$res = mysql_query($sql);
	$check = mysql_num_rows($res);
	if ($check != 0) {
		$row = mysql_fetch_array($res); 
		if ($row['password'] == $_POST['passwordsignin']) {
			$_SESSION['user'] = $_POST['emailsignin'];
			header("location:oauth.php");
		} else {
			$msg = "Invalid password!!!";
			header("location:index.php?alert=" . $msg);
		}
	} else {
		$msg = "Invalid details!!!";
		header("location:index.php?alert=" . $msg);
	}
}
?>