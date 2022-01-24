<?php
	require_once('../config/connect.php');
	require_once('hashgen.php');

	$ip = "0.0.0.0";
	$proxy = "0.0.0.0";
	$exist = false;
	$tr = 0;
	
	if(isset($_SERVER['REMOTE_ADDR']))
		$ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];
		
	$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "ipban WHERE IP = '$ip' OR PROXY = '$proxy'");
	if($mysqlman->numrows() > 0)
	{
		if($mysqlman->numrows() > 1)
			$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "ipban WHERE IP = '$ip' AND PROXY = '$proxy'");
		if($mysqlman->numrows() > 0)
		{
			$res = $mysqlman->sqlfetchassoc();
			$ld = $res['DATE'];
			$ll = date_create_from_format('Y-m-d H:i:s', $ld);
			$la = $ll->getTimestamp();
			$dt = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
			$dd = $la - $dt->getTimestamp();
			if($dd < 0)
			{
				$mysqlman->sqlquery("DELETE FROM " . constant('tab_prefix') . "ipban WHERE IP = '$ip'");
			}else{
				die('@E. You have been BANNED from this service and can\'t log in anymore. Ban expires on ' . $ll->format("l j F Y - H:i:s"));
			}
		}
	}
		
	$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "loginattempts WHERE IP = '$ip' AND PROXY = '$proxy'");
	if($mysqlman->numrows() > 0)
	{
		$exist = true;
		$res = $mysqlman->sqlfetchassoc();
		$ld = $res['DATE'];
		$ll = date_create_from_format('Y-m-d H:i:s', $ld);
		$la = $ll->getTimestamp();
		$tr = $res['TRIES'];
		if($tr >= 3)
		{
			$dt = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
			$dd = $dt->getTimestamp() - $la;
			if($dd >= 1800)
			{
				$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "loginattempts SET TRIES = 0, DATE = NOW() WHERE IP = '$ip' AND PROXY = '$proxy'");
				$tr = 0;
			}else{
				die('@E. Login attempts exceeded. You have to wait for another ' . ceil((1800 - $dd)/60) . ' minutes in order to try again.');
			}
		}
	}

	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
		die('@E. Unautorized.');

	if(!$mysqlman->is_connected())
		die('@E. Could not connect to the database.');


	$user = $mysqlman->real_escape_string($_POST['login_name']);
	$pass = $mysqlman->real_escape_string($_POST['login_password']);
	$md5pass = md5($pass, false);

	if(!$user || !$pass)
		die('@E. Incorrect login request.');
		
	$res = $mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "users WHERE (NAME = '$user' OR MAIL = '$user') AND PASSWORD = '$md5pass'");
	
	if($mysqlman->numrows() < 1)
	{
		$ttr = $tr + 1;
		if($exist)
		{
			$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "loginattempts SET TRIES = TRIES + 1, DATE = NOW() WHERE IP = '$ip' AND PROXY = '$proxy'");
			if($tr+1 < 3)
				die('@E. The username and password do not match, or the user does not exist. Attempt: ' . $ttr . ' out of 3.');
			else
				die('@E. The username and password do not match, or the user does not exist. Attempt: ' . $ttr . ' out of 3, you must wait 30 minutes from now before trying again!');

		}
		else
		{
			$mysqlman->sqlquery("INSERT INTO " . constant('tab_prefix') . "loginattempts VALUES ('$ip','$proxy',NOW(),1)");
				die('@E. The username and password do not match, or the user does not exist. Attempt: ' . $ttr . ' out of 3');
		}
	}
	

	
	$user = $mysqlman->sqlfetchassoc_ns($res);
	$ld = $user['BAN'];
	$ll = date_create_from_format('Y-m-d H:i:s', $ld);
	$la = $ll->getTimestamp();
	$dt = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
	$dd = $dt->getTimestamp() - $la;
	if($dd < 0)
	{
		die('@E. You have been BANNED from this service and can\'t log in anymore. Ban expires on ' . $ll->format("l j F Y - H:i:s"));
	}
	
	$session = genhash();

	$mysqlman->sqlquery("UPDATE ". constant('tab_prefix') . "users SET SESSION = '$session', IP = '$ip', PROXY = '$proxy' WHERE ID = $user[ID]");
	echo("@1. " . $session);