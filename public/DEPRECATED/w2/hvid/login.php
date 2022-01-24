<?php
	  $link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
		mysql_select_db("magnus98_userlist", $link);

		if (! $link){
		echo '<font color="#FF0000">Connection with SQL database failed!</font>';
		exit;
		}
	  
	  $user=$_POST['user'];
	  $usnam=$_POST['user'];
	  $pass=$_POST['password'];
	  $pasx=$_POST['password'];
	  
	  $sql = "SELECT * FROM userinfo WHERE username = '$user' ORDER BY username";
	  $result = mysql_query($sql, $link);
	  if($user = mysql_fetch_row($result)){
	  $ust = true;
	  }else{
	  $ust = false;
	  }
	  
	  $sql = "SELECT * FROM userinfo WHERE password = '$pass' ORDER BY password";
	  $result = mysql_query($sql, $link);
	  if($pass = mysql_fetch_row($result)){
	  $pt = true;
	  }else{
	  $pt = false;
	  }
	  
	  if($pasx != "" && $ust==true && $pt==true){
	  echo "¡Bienvenido" . $usnam . "! ";
	  echo "<a href=\"privado95674247.php\">Sección privada</a>";
	  setcookie("logged", "1", time() + 900);
	  }else{
	  echo "No se encuentra el usuario o la contraseña no coincide";
	  }
	  ?>