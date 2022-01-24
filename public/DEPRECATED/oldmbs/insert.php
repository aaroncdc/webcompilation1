<script type="text/JavaScript">
<!--
setTimeout("location.href = 'main.php';",3000);
-->
</script>
<?php
require("res/connect.php");
$password = $_POST["password"];
if($password != $passwrd_){
echo 'Contrasena no valida. Contacte al administrador';
exit;
}
	$title = $_POST['titulo'];
	$content = $_POST['contenido'];
	$tag = $_POST['tags'];
	if($title == "" || $content == ""){
	echo '<font color="#FF0000">ERROR: Uno o varios campos están vacios. Presione ATRAS en su navegador e intentelo de nuevo. </font>';
	exit;
	}
	$date = "NOW()";
	mysql_query("INSERT INTO entradas (id, titulo, fecha, contenido, tags) VALUES (null, '" . $title . "'," . $date . ",'" . $content . "','" . $tag . "')", $link) or die(mysql_error());
	echo("Entrada a&ntilde;adida con exito! :) Se le redireccionara en 3 segundos...");
?>