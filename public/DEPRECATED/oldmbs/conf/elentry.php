<?php
require("../res/connect.php");
$id = $_GET['id'];
$password = $_POST['password'];
if($password != $passwrd_){
echo 'Contrasena no valida. Contacte al administrador';
exit;
}
mysql_query('DELETE FROM entradas WHERE id = ' . $id);
echo mysql_error();
echo 'Completado con exito!';
?>