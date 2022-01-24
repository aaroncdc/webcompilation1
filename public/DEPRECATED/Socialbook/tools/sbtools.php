<?php

if(file_exists('config/connect.php'))
	require_once('config/connect.php');
else if(file_exists('connect.php'))
	require_once('connect.php');
else
	require_once('../config/connect.php');
	
if(file_exists('tools/hashgen.php'))
	require_once('tools/hashgen.php');
else if(file_exists('hashgen.php'))
	require_once('hashgen.php');
else
	require_once('../hashgen.php');

$isloggedin = false;
$usname = null;
$usmail = null;
$ussid = null;

function getSession() {
	global $isloggedin;
	global $usname;
	global $usmail;
	global $ussid;
	global $mysqlman;
	
	if(isset($_COOKIE['sessionid']))
	{
		$ussid = $_COOKIE['sessionid'];
		$usmail = $_COOKIE['sessionmail'];
		if($mysqlman->sqlquery("SELECT NOM FROM USUARIOS WHERE USMAIL='".$usmail."' AND SESSIONID='".$ussid."'"))
		{
			$res = $mysqlman->sqlfetchassoc();
			if($res && $mysqlman->numrows()>0)
			{
				$usname = $res['NOM'];
				return true;
			}else{
				return false;
			}
		}else{ return false; }
	}
}

function setSession($mail, $pass) {
	global $mysqlman;
	$sessionid = genhash();
	if(!$mysqlman->sqlquery("UPDATE USUARIOS SET SESSIONID='$sessionid' WHERE USMAIL='".$mail."' AND PASSWD='".$pass."'"))
	{
		return false;
	}else{
		setcookie("sessionid",$sessionid,time()+60*60*24*30,"/");
		setcookie("sessionmail",$mail,time()+60*60*24*30,"/");
		return true;
	}
}

function checkSession($mail, $sid) {
	global $mysqlman;
	global $isloggedin;
	
	if(!$mysqlman->sqlquery("SELECT SESSIONID FROM USUARIOS WHERE USMAIL='$mail'"))
	{
		return false;
	}
	$res = $mysqlman->sqlfetchassoc();
	if($res['SESSIONID'] == $sid)
	{
		$isloggedin = true;
		return true;
	}else
		return false;
}

function getAndCheck() {
	global $isloggedin;
	global $usmail;
	global $ussid;
	
	if(!getSession())
		return false;
		
	if(!checkSession($usmail, $ussid))
		return false;
		
	return true;
}

function getUsId($mail, $session)
{
	global $mysqlman;
	if(!$mysqlman->sqlquery("SELECT IDNO FROM USUARIOS WHERE USMAIL='$mail' AND SESSIONID='$session'"))
	{
		return null;
	}else{
		if($mysqlman->numrows() < 1)
			return null;
		$res = $mysqlman->sqlfetchassoc();
		return $res['IDNO'];
	}
}

function getUsInfo($mail, $session)
{
	global $mysqlman;
	//echo("<b>Query: </b>SELECT * FROM USUARIOS WHERE USMAIL='$mail' AND SESSIONID='$session'<br/>");
	if(!$mysqlman->sqlquery("SELECT * FROM USUARIOS WHERE USMAIL='$mail' AND SESSIONID='$session'"))
	{
		return null;
	}else{
		if($mysqlman->numrows() < 1)
			return null;
		$res = $mysqlman->sqlfetchassoc();
		return $res;
	}
}

function getIdInfo($idno)
{
	global $mysqlman;
	//echo("<b>Query: </b>SELECT * FROM USUARIOS WHERE USMAIL='$mail' AND SESSIONID='$session'<br/>");
	if(!$mysqlman->sqlquery("SELECT * FROM USUARIOS WHERE IDNO=$idno"))
	{
		return null;
	}else{
		if($mysqlman->numrows() < 1)
			return null;
		$res = $mysqlman->sqlfetchassoc();
		return $res;
	}
}

function listAllFriends($mail, $session)
{
	global $mysqlman;
	$mid = getUsId($mail, $session);
	return $mysqlman->sqlquery("SELECT REL FROM AMISTADES WHERE OWNID=$mid AND STATUS=1");
}

function listAllFriendNames($list)
{
	global $mysqlman;
	$namelist = array();
	while($uid = $mysqlman->sqlfetchassoc_ns($list))
	{
		$name = $mysqlman->sqlquery("SELECT NOM, APE1, APE2 FROM USUARIOS WHERE IDNO=$uid[REL]");
		$r = $mysqlman->sqlfetchassoc();
		array_push($namelist, $r['NOM'] . ' ' . $r['APE1'] . ' ' . $r['APE2']);
	}
	return $namelist;
}

function isFriend($uid, $me)
{
	global $mysqlman;
	$fquery = $mysqlman->sqlquery("SELECT REL FROM AMISTADES WHERE OWNID=$me AND REL=$uid AND STATUS=1");
	$mysqlman->sqlfetchassoc();
	if($mysqlman->numrows() < 1)
		return false;
	else
		return true;
}

function isLoggedIn() {
	global $isloggedin;
	return $isloggedin;
}

function closeSession()
{
		setcookie("sessionid","",time()-60,"/");
		setcookie("sessionmail","",time()-60,"/");
}