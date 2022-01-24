<?php
	require_once('tools/jbbinit.php');
	require_once('tools/sbtools.php');
	session_start();
	
		if(!isset($_POST['usermail']) || !isset($_POST['usersid']))
			die(".!E Usuario o ID no especificados (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	if(!checkSession($_POST['usermail'], $_POST['usersid']))
		die(".!E Sesión erronea (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	$query = "SELECT IDNO FROM USUARIOS WHERE USMAIL='$_POST[usermail]' AND SESSIONID='$_POST[usersid]'";

	$mysqlman->sqlquery($query);
	$res = $mysqlman->sqlfetchassoc();
	
	if(isset($_SESSION['lastpost']))
		$lastid = $_SESSION['lastpost'];
	else
		$lastid = -1;
	$usid = $res['IDNO'];
	
	//echo("<article>".$usid."</article>");
		
	if($lastid == -1)
		$order = "DESC LIMIT 15";
	else
		$order = "ASC";
	
	$amigos = "$usid";
	
	if(!$mysqlman->sqlquery("SELECT * FROM AMISTADES WHERE OWNID=$usid"))
		echo($mysqlman->sqlerror());

	if($mysqlman->numrows() > 0)
	{
		$amigos .= ",";
		while($r =  $mysqlman->sqlfetchassoc())
			$amigos .= $r['REL'].",";
	
		$amigos = rtrim($amigos, ',');
	}
	
		
	if(!$mysqlman->sqlquery("SELECT * FROM TEXTOS WHERE IDNO IN ($amigos) ORDER BY TID $order"))
			echo(".!E " . $mysqlman->sqlerror());
	
	if($mysqlman->numrows() > 0)
	{
		$cnt = 0;
		if($lastid == -1) {
			while($rw = $mysqlman->sqlfetchassoc())
			{
				$query = $mysqlman->sqlquery_ns("SELECT * FROM USUARIOS WHERE IDNO=$rw[IDNO]");
				$ru = $mysqlman->sqlfetchassoc_ns($query);
				echo("<article>");
				echo("<b>$ru[NOM] $ru[APE1] $ru[APE2]</b><hr/>");
				
				$extensions = array('.jpg','.png','.gif');
				$imgurl = "";
				for($i = 0; $i < sizeof($extensions); $i++)
				{
					if(file_exists("perfiles/$ru[IDNO]/$ru[IDNO]$extensions[$i]"))
						$imgurl = "perfiles/$ru[IDNO]/$ru[IDNO]$extensions[$i]";
				}
					
				if($imgurl == "")
					$imgurl = "static/person.png";
				
				echo('<a href="perfil.php?uid='.$ru['IDNO'].'"><img src="'.$imgurl.'" class="prof-article"/></a>');
				$parser->parse($rw['CONT']);
				echo('<p class="article">'.$parser->getAsHtml().'</p>');
				echo("</article>");
				$cnt++;
			}
			$_SESSION['lastpost'] = $cnt;
		}else{
			while($rw = $mysqlman->sqlfetchassoc())
			{
				if($cnt >= $lastid)
				{
					$query = $mysqlman->sqlquery_ns("SELECT * FROM USUARIOS WHERE IDNO=$rw[IDNO]");
					$ru = $mysqlman->sqlfetchassoc_ns($query);
					echo("<article>");
					echo("<b>$ru[NOM] $ru[APE1] $ru[APE2]</b><hr/>");
				$extensions = array('.jpg','.png','.gif');
				$imgurl = "";
				for($i = 0; $i < sizeof($extensions); $i++)
				{
					if(file_exists("perfiles/$ru[IDNO]/$ru[IDNO]$extensions[$i]"))
						$imgurl = "perfiles/$ru[IDNO]/$ru[IDNO]$extensions[$i]";
				}
					
				if($imgurl == "")
					$imgurl = "static/person.png";
				
				echo('<a href="perfil.php?uid='.$ru['IDNO'].'"><img src="'.$imgurl.'" class="prof-article"/></a>');
					$parser->parse($rw['CONT']);
					echo('<p class="article">'.$parser->getAsHtml().'</p>');
					echo("</article>");
				}
				$cnt++;
			}
			$_SESSION['lastpost'] = $cnt;
		}
	}