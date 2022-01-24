<?php
/*
* Aqui debe cambiar los siguientes datos por sus correspondientes:
*
* localhost: esto debería funcionar tal y como está, es el nombre del host. (No lo cambie
* a no ser que esté seguro de que debe cambiarlo)
*
* root: cambie esto por su nombre de usuario MySQL.
*
* password: cambie esto por su contraseña para acceder a la base de datos MySQL.
*
* nombredb: cambie esto por el nombre de la base de datos SQL que vaya a usar.
*
* EL RESTO DEJELO COMO ESTA
*
* Las configuraciones de MySQL debe hacerlas en el panel de control de su servicio de
* alojamiento web.
*/
$link = mysql_connect("localhost", "usuario", "password");
	mysql_select_db("base_de_datos", $link);
	if (! $link){
	echo '<font color="#FF0000">Connection with SQL database failed!</font><br>';
	echo mysql_error();
	exit;
	}
	
	/* Aqui aparece la contraseña que se usará para postear. Debe cambiarla por su seguridad.
	* Por defecto es 0537xyx9, debe cambiarla para que nadie pueda postear ni modificar
	* nada.
	*/
	$passwrd_ = "000000000";
?>
