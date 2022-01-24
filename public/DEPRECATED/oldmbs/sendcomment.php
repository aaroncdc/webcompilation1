<script type="text/JavaScript">
<!--
setTimeout("location.href = 'blog.php';",3000);
-->
</script>

<?php
require("res/connect.php");
require("res/filter.php");
$pid = rand(1000,999999999);
$id = $_POST['nent'];
$name = $_POST['nombre'];
$mail = $_POST['mail'];
$url = $_POST['web'];
$data = $_POST['comentario'];
//Aqui se filtran algunas palabras indeseadas. Puedes añadir los terminos que desees al archivo 'filter.php'.
if(esSpam($data) >= 1 || esSpam($name) >= 1){
echo("Hay contenido SPAM en tu comentario. Se permiten algunas etiquetas HTML como b, i, u, br. NO se permiten algunas palabras ofensivas, ni publicidad indeseada, asi como codigos HTML que pudieran poner en riesgo a la pagina.");
exit;
}
if($name == "" || $name == null || $data == "" || $data == null){
echo '<font color="#FF0000">ERROR: Uno o varios campos están vacios. Presione ATRAS en su navegador e intentelo de nuevo. </font>';
exit;
}
mysql_query("INSERT INTO comentarios (id, nent, pid, nombre, mail, web, contenido) VALUES (null, '" . $id . "'," . $pid . ",'" . $name . "','" . $mail . "','" . $url . "','" . $data . "')", $link) or die(mysql_error());
echo("Comentario a&ntilde;adido con exito! :) Se le redireccionara en 3 segundos...");
?>
