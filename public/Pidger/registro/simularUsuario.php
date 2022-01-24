<?php
$nombres = ["Usuario1", "Magnus", "Aaron","Paco","Pepe","Jacinto"];
$correos = ["correo@web.com", "uno@web.com"];

$op = htmlentities($_POST["op"]);
$data = htmlentities($_POST["data"]);

switch($op){
	case 0:
		for($x = 0; $x < sizeof($nombres); $x++)
			if($nombres[$x] == $data)
				die("ERR");
		die("OK");
	break;
	case 1:
	for($x = 0; $x < sizeof($correos); $x++)
			if($correos[$x] == $data)
				die("ERR");
		die("OK");
	break;
	default:
	die("ERR");
}

die("ERR");
?>