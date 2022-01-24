<?php
	require_once ('tools/sbtools.php');
	if(!isset($_POST['usermail']) || !isset($_POST['usersid']))
		die(".!E Usuario o ID no especificados (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	if(!checkSession($_POST['usermail'], $_POST['usersid']))
		die(".!E Sesión erronea (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	$uid = getUsId($_POST['usermail'], $_POST['usersid']);
	$ussid = $_POST['usersid'];
	
	if(isset($_POST['dest_select']))
		$dest = $_POST['dest_select'];
	else
		die(".!E Destinatario no especificado " + $_POST['dest_select']);
	
	
	if(isset($_POST['txtentrada']))
		$contenido = $_POST['txtentrada'];
	else
		die(".!E Sin mensaje");
	
	$mysqlman->sqlquery("SELECT * FROM AMISTADES WHERE OWNID=$uid AND REL=$dest AND STATUS=1");
	if($mysqlman->numrows() < 1)
		die(".!E El destinatario no se encuentra en su lísta de amigos.");

	if(!$mysqlman->sqlquery("INSERT INTO MENSAJES VALUES ('',$uid,$dest,NOW(),'$contenido')"))
		die(".!E " + $mysqlman->sqqlerror());
	else
		die(".!S ");