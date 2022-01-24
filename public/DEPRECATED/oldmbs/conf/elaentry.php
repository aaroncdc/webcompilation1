<?php
require("../res/connect.php");
$password = $_POST['password'];
if($password != $passwrd_){
echo 'Contrasena no valida. Contacte al administrador';
exit;
}
mysql_query('TRUNCATE TABLE comentarios');
echo mysql_error();
echo 'COMPLETADO CON EXITO!';
?>