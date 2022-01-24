<?php
	if(isset($_GET["id"]))
		$id = $_GET["id"];
	else
		die("<h1>Uso incorrecto de la pagina.</h1><a href=\"index.php\">Volver atras</a>");

	require_once("sql/conexion.php");
	$res = mysqli_query($con,"SELECT * FROM jugadores WHERE id = ".$id);
	$row = mysqli_fetch_assoc($res);
	if(!$row)
		die("<h1>Jugador no encontrado.</h1><a href=\"index.php\">Volver atras</a>")
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ficha de jugador</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	<?php if(isset($id)): ?>
	<div id="contenedor" class="cficha">
		<div id="ficha">
			<h1><?php echo $row["nombre"] . " " . $row["apellido"] ?></h1>
			<div class="encabezadoficha">
				<img src=<?php echo '"'.$row["foto"].'"' ?>>
				<strong>Nombre: </strong><span><?php echo $row["nombre"] . " " . $row["apellido"] ?></span><br>
				<strong>Fecha de Nacimiento: </strong><span><?php echo $row["nacimiento"] ?></span><br>
				<strong>Provincia: </strong><span><?php echo $row["provincia"] ?></span><br>
				<strong>Equipo debutante: </strong><span><?php echo $row["debutante"] ?></span><br>
				<strong>Equipo actual: </strong><span><?php echo $row["actual"] ?></span><br>
				<strong>Posición: </strong><span><?php echo $row["posicion"] ?></span><br>
				<strong>Dorsal: </strong><span><?php echo $row["numero"] ?></span><br>
				<strong>Patrocinador: </strong><span><?php echo $row["patrocinador"] ?></span><br>
				<strong>Precio en el mercado: </strong><span><?php echo $row["preciofichaje"] ?>€</span><br><br><br>
				<a href="index.php" class="alista">Volver al inicio</a>
			</div>
		</div>
	</div>
	<?php endif ?>
</body>
</html>