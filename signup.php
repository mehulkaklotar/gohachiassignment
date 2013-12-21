<?php
include_once ("configure/configure.php");
	if (!$_POST['email'] || !$_POST['password']) {

		die('You did not complete all of the required fields');

	} else {

		$sql = "select * from user where email ='" . $_POST['email'] ."'";
		$res = mysql_query($sql);
		$check = mysql_num_rows($res);
		if($check!=0){
			$msg = "Already Registred!!";
			header("location:index.php?msg=".$msg);
		}else {
			mysql_query("INSERT INTO user (email, password) VALUES ('" . $_POST['email'] . "', '" . $_POST['password'] . "')");
		}
	}
?>