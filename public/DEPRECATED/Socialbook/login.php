<?php
	require_once('tools/sbtools.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
	function jstimeout(){
		echo "<script language=\"javascript\">";
		echo "setTimeout(\"window.location.href='portada.php';\", 3000);";
		echo "</script>";	
	}
	
	if($mysqlman->sqlquery("SELECT USHASH FROM USUARIOS WHERE USMAIL='$_POST[txtMailLog]'"))
	{
		$fetch = $mysqlman->sqlfetchrow();
		$ushash = $fetch[0];
	}else{
		echo("<b>Error: " + $mysqlman->sqlerror() + "</b>");	
	}
	$pass = md5($_POST['txtPasswdLog'],false);
	
	if($mysqlman->sqlquery("SELECT NOM FROM USUARIOS WHERE USMAIL='".$_POST['txtMailLog']."' AND PASSWD='".$pass."'"))
	{
		if($mysqlman->numrows() > 0)
		{
			
			$nombre = $mysqlman->sqlfetchrow();
			
			if(!isset($_COOKIE['sessionid']) || !isset($_COOKIE['sessionmail']))
			{
				if(!setSession($_POST['txtMailLog'], $pass))
					echo("<pre>Error: ".$mysqlman->sqlerror()."</pre>");
				echo("<b>Bienvenido, " . $nombre[0] . "</b>");
				jstimeout();
			}else{
				if(checkSession($_COOKIE['sessionmail'], $_COOKIE['sessionid'])){
					echo("<b>Sesión ya en curso: ".$_COOKIE['sessionmail']."</b>");
					jstimeout();
				}else {
					echo("<b>Sesión erronea.</b>");
					closeSession();
				}
			}
				
			
		}else{
			echo("<b>Login incorrecto.</b>");	
		}
	
	}else{
		echo("<b>Error: " . $mysqlman->sqlerror() . "</b>");	
	}
	
?>
</body>

</html>
<?php
	$mysqlman->endconnection();
?>