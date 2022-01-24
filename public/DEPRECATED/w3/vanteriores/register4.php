<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>REGISTRO EN HAXORZONE</title>
</head>

<body>
<blockquote>
  <blockquote>
    <blockquote>
	<form action="register4.php" method=POST>
      <p align="center">Nombre de Usuario:
        <input type="text" name="user" />
        <br />
        Contrase&ntilde;a:
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
      <input type="text" name="password" />
        <br />
        Repetir contrase&ntilde;a:&nbsp;&nbsp; 
        <input type="text" name="passt" />
        <br />
        Direcci&oacute;n de email:&nbsp;&nbsp;
        <input type="text" name="email" />
        <br />
        <input type="submit" name="Submit" value="Siguiente&gt;" />
      </p>
	  </form>
	  <?php
	  $link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
		mysql_select_db("magnus98_userlist", $link);

		if (! $link){
		echo '<font color="#FF0000">Connection with SQL database failed!</font>';
		exit;
		}
		
		$user=$_POST['user'];
	  	$pass=$_POST['password'];
		$passt=$_POST['passt'];
		$email=$_POST['email'];
		
		if($pass == $passt){
		$sql = 'INSERT INTO `userinfo` (`id`, `username`, `usermail`, `password`) VALUES (\'0\', '$user', '$mail', '$pass');';
		$result = mysql_query($sql);
		}else{
		echo '<font color="#FF0000">Las contraseñas no coinciden, ¡Revisalas!</font>';
		exit;
		}
	  ?>
    </blockquote>
  </blockquote>
</blockquote>
</body>
</html>
