<?php
	require_once('tools/jbbinit.php');
    require_once ('tools/sbtools.php');
	
	if(isset($_GET['uid']))
		$foreign = $_GET['uid'];
	
		if(!getAndCheck())
			die('Error en la sesión');
	
		$usinfo = getUsInfo($usmail, $ussid);
		if(!$usinfo)
			die('Error en el usuario');
		$id = getUsId($usmail, $ussid);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Socialbook - Confirmar amistad</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8"/>
        <link href="css/socialbook.css" rel="stylesheet" type="text/css"/>
		<script src="js/jquery-1.12.0.js" type="text/javascript"></script>
		<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
	</head>
	<body>
	<br/><br/>
	<div id="entradas">
	<?php include('template/head.php'); ?>
	<?php
		if(!isset($_GET['aid']) || !isset($_GET['bid']))
			die('Error.');
			
		$friend = $_GET['aid'];
		$me = $_GET['bid'];
		$action = 0;
		
		if($id != $me)
			die('<br/><br/><br/><br/>OPERACIÓN DENEGADA');
		
		if(isset($_GET['act']))
			$action = $_GET['act'];
		
		$meinfo = getIdInfo($me);
		$uinfo = getIdInfo($friend);
		
		switch($action){
			case 1:
				$mysqlman->sqlquery("INSERT INTO AMISTADES VALUES($me,$friend,0)");
				$mysqlman->sqlquery("INSERT INTO MENSAJES VALUES('',$me,$friend,NOW(),'<!>')");
				echo("<article><center><b>AMISTAD SOLICITADA A $uinfo[NOM]</b></center></article>");
			break;
			case 2:
				$mysqlman->sqlquery("DELETE FROM AMISTADES WHERE OWNID=$me AND REL=$friend");
				$mysqlman->sqlquery("DELETE FROM AMISTADES WHERE OWNID=$friend AND REL=$me");
				echo("<article><center><b>YA NO ERES AMIGO DE $uinfo[NOM]</b></center></article>");
			break;
			case -1:
				$mysqlman->sqlquery("UPDATE AMISTADES SET STATUS=2 WHERE OWNID=$friend AND REL=$me");
				$mysqlman->sqlquery("INSERT INTO AMISTADES VALUES($me,$friend,2)");
				$mysqlman->sqlquery("DELETE FROM MENSAJES WHERE IDNO=$friend AND DEST=$me AND CONT='<!>'");
				echo("<article><center><b>AMISTAD CON $uinfo[NOM] RECHAZADA</b></center></article>");
			break;
			case -2:
				$mysqlman->sqlquery("UPDATE AMISTADES SET STATUS=3 WHERE OWNID=$friend AND REL=$me");
				$mysqlman->sqlquery("UPDATE AMISTADES SET STATUS=3 WHERE OWNID=$me AND REL=$friend");
				$mysqlman->sqlquery("DELETE FROM MENSAJES WHERE IDNO=$me AND DEST=$friend AND CONT='<!>'");
				echo("<article><center><b>USUARIO $uinfo[NOM] BLOQUEADO</b></center></article>");
			break;
			default:
				$mysqlman->sqlquery("UPDATE AMISTADES SET STATUS=1 WHERE OWNID=$friend AND REL=$me");
				$mysqlman->sqlquery("INSERT INTO AMISTADES VALUES($me,$friend,1)");
				$mysqlman->sqlquery("DELETE FROM MENSAJES WHERE IDNO=$friend AND DEST=$me AND CONT='<!>'");
				$mysqlman->sqlquery("INSERT INTO MENSAJES VALUES('',$friend,$friend,NOW(),'[b]AHORA ERES AMIGO DE $meinfo[NOM] $uinfo[APE1] $uinfo[APE2][/b]')");
				$mysqlman->sqlquery("INSERT INTO MENSAJES VALUES('',$me,$me,NOW(),'[b]AHORA ERES AMIGO DE $uinfo[NOM] $uinfo[APE1] $uinfo[APE2][/b]')");
				echo("<article><center><b>AHORA ERES AMIGO DE $uinfo[NOM]</b></center></article>");
			break;
		}
	?>
	</body>
</html>