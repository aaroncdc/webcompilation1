<?php
$pid = $_GET["pid"];
$name = $pid*2;
$vot = $_COOKIE[$name];
if($vot != $pid){
setcookie ($name, $pid, time () + 3600);
require("res/connect.php");
$result = mysql_query("SELECT karma FROM comentarios WHERE pid=" . $pid);
$row = mysql_fetch_assoc($result);
$kar = $row['karma'];
//Añadimos el karma al comentario con el pid suministrado
$kar++;
mysql_query("UPDATE comentarios SET karma=" . $kar . " WHERE pid=" . $pid, $link);
echo("Un momento...");
}else{
echo("Ya has votado a este comentario antes. Espera un ratito...<br>Pulse ATRAS en su navegador");
exit;
}
?>
<script type="text/JavaScript">
<!--
setTimeout("location.href = 'blog.php';",2000);
-->
</script>
<html></html>