<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$proxy = (isset($_SERVER['HTTP_X_FORWARDED_FOR']))?$_SERVER['HTTP_X_FORWARDED_FOR']:null;
	
	function getDatetimeNow() {
		$tz_object = new DateTimeZone('Europe/Madrid');
		//date_default_timezone_set('Brazil/East');

		$datetime = new DateTime();
		$datetime->setTimezone($tz_object);
		return $datetime->format('Y-m-d H:i:s');
	}
	
	function RegisterActivity($mysqlman, $cooldown)
	{
		global $ip;
		global $proxy;
		$check = ($proxy == null || $proxy == '')?$ip:$proxy;
		$mysqlman->sqlquery("SELECT ID FROM " . constant('tab_prefix') . "users WHERE IP = '$check'");
		if($mysqlman->numrows())
		{
			$id = $mysqlman->sqlfetchrow()[0];
			$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "users SET LASTSEEN = NOW(), COOLDOWN = DATE_ADD(NOW(),INTERVAL $cooldown second) WHERE ID = $id");
		}else{
			echo $mysqlman->sqlerror();
			$mysqlman->sqlquery("INSERT INTO " . constant('tab_prefix') . "users (IP,LASTSEEN,COOLDOWN) VALUES ('$check',NOW(),DATE_ADD(NOW(),INTERVAL $cooldown second))");
		}
	}
	
	function IsOnCoolDown($mysqlman)
	{
		global $ip;
		global $proxy;
		$check = ($proxy == null || $proxy == '')?$ip:$proxy;
		$mysqlman->sqlquery("SELECT COOLDOWN FROM " . constant('tab_prefix') . "users WHERE IP = '$check'");
		if($mysqlman->numrows())
		{
			$now = getDatetimeNow();
			$cdtimer = $mysqlman->sqlfetchrow()[0];
			if($now >= $cdtimer)
				return false;
			else
				return true;
		}else return false;
	}
	
	function GetCoolDown($mysqlman)
	{
		global $ip;
		global $proxy;
		$check = ($proxy == null || $proxy == '')?$ip:$proxy;
		$mysqlman->sqlquery("SELECT COOLDOWN FROM " . constant('tab_prefix') . "users WHERE IP = '$check'");
		if($mysqlman->numrows())
			return DateTime::createFromFormat('Y-m-d H:i:s', $mysqlman->sqlfetchrow()[0]);
		else
			return getDatetimeNow();
	}
	
	function IsBanned($mysqlman)
	{
		global $ip;
		global $proxy;
		$check = ($proxy == null || $proxy == '')?$ip:$proxy;
		$mysqlman->sqlquery("SELECT BAN,BANEXPIRES FROM " . constant('tab_prefix') . "users WHERE IP = '$check'");
		$ban = $mysqlman->sqlfetchrow();
		if($ban[0] == 1)
		{
			$expires = $ban[1];
			$now = getDatetimeNow();
			if($now >= $expires)
			{
				$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . " users SET BAN = 0 WHERE IP = '$check'");
				return false;
			}else return true;
		}else if ($ban[0] == 2)
			return true;
		else return false;
	}
?>