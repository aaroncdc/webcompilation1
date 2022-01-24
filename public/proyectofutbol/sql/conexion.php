<?php
	header("Content-Type: text/html;charset=utf-8");
	define("hostname", "localhost");
	define("dbuser", "root");
	define("dbpassword", "");
	define("database", "aaron");

	$con = mysqli_connect(hostname, dbuser, dbpassword, database);

	if(mysqli_connect_errno())
		die(mysqli_connect_error());

	$con->query("SET NAMES 'utf8'");

	function endconnection(){
		global $con;
		if($con)
			mysqli_close($con);
	}
?>