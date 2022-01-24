<?php
	//Listas de jugadores
	header("Content-Type: text/html;charset=utf-8");

	//Función principal de búsqueda.
	function search($query, $ficha=true, $date=null, $datemode=0)
	{
		require_once("sql/conexion.php");

		//$query = $query;
		$res = mysqli_query($con, $query);
		if(!$res)
		{
			//Esto no debería de ocurrir, en cualquier caso
			endconnection();
			die("La búsqueda no arroja resultados.");
		}else{
			//Generar lista de resultados
			$cells = 0;
			$table = '<table class="resultados">';
			$row = mysqli_fetch_assoc($res);

			$table .= '<tr>';
			while($cell = current($row))
			{
				if(key($row)!="ID")
					$table	.= '<th>' . ucfirst(strtolower(key($row))) . '</th>';
				$cells++;
				next($row);
			}
			reset($row);

			$table .= ($ficha)?'<th>Ficha</th></tr>':'</tr>';
			do{
				//Si la búsqueda es por fechas, filtrar resultados
				if($date)
				{
					$n = new DateTime($row['nacimiento']);
					$pass = false;
					$diff = $date->diff($n);
					switch($datemode)
					{
						// Sub17
						case 0:
							$pass = ($diff->y <= 17)?true:false;
						break;
						// Sub21
						case 1:
							$pass = ($diff->y <= 21 && $diff->y > 17)?true:false;
						break;
						// Senior
						case 2:
							$pass = ($diff->y > 21)?true:false;
						break;
					}
					//Mostrar sólo si pasa el filtro
					if($pass)
					{
						$table .= '<tr>';
						for($x = 0; $x < $cells; $x++)
						{
							$cell = current($row);
							if(key($row)!="ID")
							{
								if(key($row) == "foto")
									$table	.= '<td><img src="' . htmlentities($cell) . '"></td>';
							else
								$table	.= '<td>' . $cell . '</td>';
							}

							next($row);
						}
						reset($row);
						$table .= ($ficha)?'<td><a href="ficha.php?id='.current($row).'">Ver ficha</a></td></tr>':'</tr>';
						continue;
					}
				}else{
					//En caso de no filtrar por fechas, mostrar todos los resultados.
					//Ocultando la ID.
					$table .= '<tr>';
					for($x = 0; $x < $cells; $x++)
					{
						$cell = current($row);
						if(key($row)!="ID")
						{
							if(key($row) == "foto")
								$table	.= '<td><img src="' . htmlentities($cell) . '"></td>';
						else
							$table	.= '<td>' . $cell . '</td>';
						}

						next($row);
					}
					reset($row);
					$table .= ($ficha)?'<td><a href="ficha.php?id='.current($row).'">Ver ficha</a></td></tr>':'</tr>';
				}
			}while($row = mysqli_fetch_assoc($res));
			$table .= '<table>';

			endconnection();
			die($table);
		}

		endconnection();
	}

	//El modo especifica qué debemos mostrar
	if(isset($_POST["mode"]))
	{
		$mode = intval($_POST["mode"]);
		switch($mode){
			//Todos, por nombre
			case 0:
				search("SELECT * FROM jugadores ORDER BY nombre");
			break;
			//Todos, por número
			case 1:
				search("SELECT * FROM jugadores ORDER BY numero ASC");
			break;
			//Todos, por equipo, y luego por nombre
			case 2:
				search("SELECT ID,nombre,apellido,actual FROM jugadores ORDER BY actual ASC, nombre ASC");
			break;
			//Sub17
			case 10:
				$current = new DateTime();
				search("SELECT * FROM jugadores ORDER BY nombre ASC", false, $current);
			break;
			//Sub21
			case 11:
				$current = new DateTime();
				search("SELECT * FROM jugadores ORDER BY nombre ASC", false, $current, 1);
			break;
			//Senior
			case 12:
				$current = new DateTime();
				search("SELECT * FROM jugadores ORDER BY nombre ASC", false, $current, 2);
			break;
			//Modo no implementado
			default:
				die("Modo no implementado: " + $mode);
		}
	}else{
		die("Uso incorrecto");
	}
?>