<?php
require("../res/connect.php");
$password = $_POST['password'];
if($password != $passwrd_){
echo 'Contrasena no valida. Contacte al administrador';
exit;
}
mysql_query('DROP TABLE entradas');
mysql_query('DROP TABLE comentarios');
echo 'Tarea completada con exito! Las tablas de la base de datos de MBS han sido eliminadas de la misma.';
?>