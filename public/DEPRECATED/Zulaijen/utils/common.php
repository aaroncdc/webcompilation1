<?php

	require_once('config/connect.php');
	
	function checkSession($session, $name)
	{
		global $mysqlman;
		$ip = "0.0.0.0";
		$proxy = "0.0.0.0";
	
		if(isset($_SERVER['REMOTE_ADDR']))
			$ip = $_SERVER['REMOTE_ADDR'];
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];

		
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "ipban WHERE IP = '$ip' OR PROXY = '$proxy'");
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
					echo("UNBANNED<br/>");
					$mysqlman->sqlquery("DELETE FROM " . constant('tab_prefix') . "ipban WHERE IP = '$ip'");
				}else{
					echo("BANNED<br/>");
					return false;
				}
		}
		
		$res = $mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "users WHERE SESSION = '$session' AND (NAME = '$name' OR MAIL = '$name')");
		if($mysqlman->numrows() == 1)
		{
			$user = $mysqlman->sqlfetchassoc();
			
			$ld = $user['BAN'];
			$ll = date_create_from_format('Y-m-d H:i:s', $ld);
			$la = $ll->getTimestamp();
			$dt = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
			$dd = $dt->getTimestamp() - $la;
			if($dd < 0)
				return false;
			
			return true;
		}
		return false;
	}
?>