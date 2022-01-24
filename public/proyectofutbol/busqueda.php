<?php
	//Búsquedas de jugadores

	header("Content-Type: text/html;charset=utf-8");
	$data = array();
	for($x = 0; $x < count($_POST); $x++)
	{
		$v = current($_POST);
		if(key($_POST)!="end" && $v != "")
			array_push($data, mysql_real_escape_string(key($_POST)));
		next($_POST);
	}
	reset($_POST);
	require_once("sql/conexion.php");

	//Construir una query SQL
	$sql = "SELECT * FROM jugadores WHERE ";
	$set = false; //<- Al menos un campo ha sido incluido en la búsqueda
	for($x = 0; $x < count($data); $x++)
	{
		if($_POST[$data[$x]]=="")
			continue;

		//Si ya hay un campo en la búsqueda, incluir un OR
		if($set)
			$sql .= ' OR ';

		//Si los datos son de patrocinadores, indicar que la búsqueda es entre una
		//serie de textos
		if($data[$x]=="patrocinador")
		{
			$sql .= $data[$x] . " IN (";
			$y = 0;
			foreach($_POST[$data[$x]] as $patro)
			{
				$sql .= "'" . mysql_real_escape_string($patro) . "'".(($y<=count($_POST[$data[$x]])-2)?",":")");
				$y++;
			}

		}else{
			//En cualquier otro caso, añadir el parámetro de búsqueda con un LIKE
			$sql .= $data[$x] . ' LIKE "%' . mysql_real_escape_string($_POST[$data[$x]]) . '%"';
		}
		
		
		$set = true;
	}

	//Realizar la búsqueda
	$res = mysqli_query($con,$sql);
	$numres = ($res)?mysqli_num_rows($res):0;

	//Construir la tabla, si hay resultados
	if($numres>0)
	{
		$cells = 0;
			$table = '<table class="resultados">';
			$row = mysqli_fetch_assoc($res);

			//Cabeceras
			$table .= '<tr>';
			while($cell = current($row))
			{
				if(key($row)!="ID")
					$table	.= '<th>' . ucfirst(strtolower(key($row))) . '</th>';
				$cells++;
				next($row);
			}
			reset($row);
			//Cuerpo de la tabla
			do{
					$table .= '<tr>';
					for($x = 0; $x < $cells; $x++)
					{
						$cell = current($row);
						if(key($row)!="ID")
						{
							if(key($row) == "foto")
								$table	.= '<td><img src="' . htmlentities($cell) . '"></td>';
						else
							$table	.= '<td>' . htmlentities($cell) . '</td>';
						}

						next($row);
					}
					reset($row);
			}while($row = mysqli_fetch_assoc($res));
			$table .= '</table>';
			endconnection();
			die($table);
	}else{
		die("<h3>No se han encontrado datos para su búsqueda</h3>");
	}
	endconnection();
?>