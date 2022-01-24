<?php
	//Insertar un nuevo jugador en la base de datos
	header("Content-Type: text/html;charset=utf-8");
	function register()
	{
		header("Content-Type: text/html;charset=utf-8");
		require_once("conexion.php");

		$imgpath = "fotos/";
		if(empty($_FILES["vFoto"]["name"]) || !$_FILES["vFoto"]["error"])
		{
			$imagen1=!$_FILES['vFoto']['error']?$_FILES['vFoto']['name']:$imgpath.'default.jpg';
			$tipo = ($imagen1!=="default.jpg")?str_replace("image/","",str_replace("jpeg", "jpg", $_FILES["vFoto"]["type"])):"jpg";

			//Evitar guardar archivos no deseados
			if($tipo != "jpg" && $tipo != "png" && $tipo != "gif" && $tipo != "")
			{
				if(!$_FILES['vFoto']['error'])
					unlink($_FILES["vFoto"]["tmp_name"]);
				endconnection();
				return "NSFT 0021";
			}

			//Filtrar algunos caracteres ilegales en el nombre del archivo
			$fname = iconv('UTF-8', 'ASCII//IGNORE', str_replace(" ", "", $imgpath.$_POST["vNombre"].$_POST["vApellido"].".".$tipo));

			if(!$_FILES['vFoto']['error'])
				move_uploaded_file($_FILES["vFoto"]["tmp_name"],$fname);
			else
				$fname = $imagen1;

			if(!file_exists($fname) && !$_FILES['vFoto']['error'])
			{
				unlink($_FILES["vFoto"]["tmp_name"]);
				endconnection();
				return "IME 0036";
			}

			//TODO: Falta usar mysql_real_escape en los campos POST
			$query = "INSERT INTO jugadores (nombre,apellido,foto,nacimiento,provincia,debutante,actual,posicion,numero,patrocinador,preciofichaje) VALUES (";
			$query .= (isset($_POST["vNombre"]) && $_POST["vNombre"] != "")?"'{$_POST["vNombre"]}',":"null,";
			$query .= (isset($_POST["vApellido"]) && $_POST["vApellido"] != "")?"'{$_POST["vApellido"]}',":"null,";
			$query .= "'$fname',";
			$query .= (isset($_POST["vNacimiento"]) && $_POST["vNacimiento"] != "")?"'{$_POST["vNacimiento"]}',":"null,";
			$query .= (isset($_POST["vProvincia"]) && $_POST["vProvincia"] != "")?"'{$_POST["vProvincia"]}',":"null,";
			$query .= (isset($_POST["vDebutante"]) && $_POST["vDebutante"] != "")?"'{$_POST["vDebutante"]}',":"null,";
			$query .= (isset($_POST["vActual"]) && $_POST["vActual"] != "")?"'{$_POST["vActual"]}',":"null,";
			$query .= (isset($_POST["vPosicion"]) && $_POST["vPosicion"] != "")?"'{$_POST["vPosicion"]}',":"null,";
			$query .= (isset($_POST["vNumero"]) && $_POST["vNumero"] != "")?"'{$_POST["vNumero"]}',":"null,";
			$query .= (isset($_POST["vPatrocinador"]) && $_POST["vPatrocinador"] != "")?"'{$_POST["vPatrocinador"]}',":"null,";
			$query .= (isset($_POST["vPrecio"]) && $_POST["vPrecio"] != "")?"'{$_POST["vPrecio"]}')":"null)";

			$query = htmlentities($query);

			$res = mysqli_query($con, $query);

			if(!$res)
			{
				endconnection();
				return "URE 0059 - " . mysqli_error($con) . " <br> " . $query;
			}else{
				endconnection();
				return "OK";
			}

		}else{
			endconnection();
			return "IUE 0067";
		}

		endconnection();
		return "NFE 0071";
	}

?>