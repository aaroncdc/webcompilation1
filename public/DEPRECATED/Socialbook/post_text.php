<?php
    require_once ('tools/sbtools.php');
	if(!isset($_POST['usermail']) || !isset($_POST['usersid']))
		die(".!E Usuario o ID no especificados (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	if(!checkSession($_POST['usermail'], $_POST['usersid']))
		die(".!E Sesión erronea (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	$ussid = $_POST['usersid'];
	if(isset($_POST['txtentrada']))
	{
		$content = $_POST['txtentrada'];
		$mysqlman->sqlquery("SELECT IDNO FROM USUARIOS WHERE SESSIONID='$ussid'");
		$res = $mysqlman->sqlfetchassoc();
		$usid = $res['IDNO'];
		if($mysqlman->sqlquery("INSERT INTO TEXTOS VALUES('',$usid,'','$content')"))
		{
			die("update");
		}else{
			die("!:E " . $mysqlman->sqlerror());
		}
	}else{
		die("!:E Sin entrada");
	}
	
	$mysqlman->endconnection();