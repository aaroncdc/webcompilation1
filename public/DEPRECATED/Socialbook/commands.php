<?php
	session_start();
	require_once ('tools/sbtools.php');
	if(!isset($_POST['usermail']) || !isset($_POST['usersid']))
		die(".!E Usuario o ID no especificados (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	if(!checkSession($_POST['usermail'], $_POST['usersid']))
		die(".!E Sesión erronea (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	$uid = getUsId($_POST['usermail'], $_POST['usersid']);
	$ussid = $_POST['usersid'];
	
	if(!isset($_POST['command']))
		die(".!E Comando no especificado");
	
	$cmd = $_POST['command'];
	$param = $_POST['param'];
	
	switch(cmd)
	{
		//borrar mensaje
		case 0:
			$_SESSION['lastpost'] = "";
			if(!$mysqlman->sqlquery("DELETE FROM MENSAJES WHERE MID=$param"))
				die(".!E " . $mysqlman->sqlerror());
			else
				die("update");
		break;
		default:
			die(".!E Comando desconocido");
	}