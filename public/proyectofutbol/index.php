<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Base de datos de fútbol</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script>
		//Función que pide al servidor una lista.
		//El resultado depende del modo establecido (modo = int)
		function queryLista(modo)
		{
			$("#loadscr").fadeIn(300);
			$.post("listados.php", {
				mode: modo
			}, function(data, status){
				$("#resultados").html(data);
				$("#loadscr").fadeOut(300);
			});
		}

		//(jQuery)Evento al cargar la página
		$(window).on('load',function(){
			//Ocultar divs
			$("#insertar").slideUp(0);
			$("#buscar").slideUp(0);
			$("#loadscr").fadeOut(0);

			//Click en el botón de Añadir
			$("#bi").click(function(){
				//Mostrar el div con el formulario
				$("#insertar").slideToggle(500);
			});

			//Click en el botón de búsqueda
			$("#bb").click(function(){
				$("#buscar").slideToggle(500);
			});

			//Click en el botón de búsqueda por patrocinadores
			$("#bus5Submit").click(function(){
				var pats = [];
				$("#loadscr").fadeIn(300);
				//Selecciona todos los patrocinadores seleccionados y
				//los añade a un array.
				$('#bus5 input:checked').each(function(){
					pats.push(($(this).attr('id')).replace(/_/g," "));
				});

				//Manda la petición de búsqueda
				$.post("busqueda.php", {
					patrocinador: pats
				}, function(data, status){
						$("#resultados").html(data);
						$("#loadscr").fadeOut(300);
					});

			});

			//Bucle que genera automáticamente parámetros de búsqueda.
			for(var x = 1; x <= 7; x++)
			{
				//Oculta cada sección
				$('#bus'+x).slideUp(0);

				//Omite la búsqueda por patrocinadores
				if(x==5)
					continue;

				//Añade eventos onclick a cada botón de submit
				$('#bus'+x+'Submit').click(function(){
					//Al clickar sobre un submit, muestra la pantalla de carga
					$("#loadscr").fadeIn(300);

					//Obtiene la parte común de la ID del botón (busx, donde x es un número)
					var sid = $(this).attr('id').replace("Submit", "");

					//Generar un texto JSON con los parámetros de búsqueda.
					//Dichos parametros los saca del nombre de cada campo, y su valor.
					//Los nombres de cada campo coinciden con los campos en la base de datos.
					var data = "{";
					$("#"+sid+' input[type="text"], #'+sid+' select, #'+sid+' input[type="checkbox"]').each(function() {
							//console.log($(this).attr('name')+", "+$(this).val());
							data+='"'+$(this).attr('name')+'":"'+$(this).val()+'",';
					});

					data+='"end":0}';

					//Genera automáticamente un array con los datos creados
					//console.log(data);
					var proc = JSON.parse(data);
					//Envia los datos al servidor.
					$.post("busqueda.php", proc, function(data, status){
						//Muestra los resultados recividos
						$("#resultados").html(data);
						//Oculta la pantalla de carga
						$("#loadscr").fadeOut(300);
					});
				});
			}

			//Eventos click de los botones de búsqueda
			$("#b1").click(function(){queryLista(0);});
			$("#b2").click(function(){queryLista(1);});
			$("#b3").click(function(){queryLista(2);});
			$("#b4").click(function(){$("#bus1").slideToggle(300);});
			$("#b5").click(function(){$("#bus2").slideToggle(300);});
			$("#b6").click(function(){$("#bus3").slideToggle(300);});
			$("#b7").click(function(){$("#bus4").slideToggle(300);});
			$("#b8").click(function(){$("#bus5").slideToggle(300);});
			$("#b9").click(function(){$("#bus6").slideToggle(300);});
			$("#b10").click(function(){$("#bus7").slideToggle(300);});
			$("#b11").click(function(){queryLista(10);});
			$("#b12").click(function(){queryLista(11);});
			$("#b13").click(function(){queryLista(12);});
		});
	</script>
</head>
<body>
	<?php
		if(isset($_POST["vNombre"]))
		{
			require_once("sql/insertar.php");
			$r = register();
		}
	?>
	<div id="contenedor">
		<header>
			<h3>Seleccione una operación: </h3>
			<input type="button" value="Búsqueda" id="bb">
			<input type="button" value="Añadir" id="bi">
		</header>
		<?php if(isset($r)): ?>
		<div id="resultado">
			<h1>Resultado de la operación</h1>
			<?php if($r === "OK"): ?>
			<p>La operación se ha realizado correctamente.</p>
			<?php else: ?>
			<p>Ha ocurrido un error durante la operación. El código del error es <?php echo $r ?></p>
			<?php endif ?>
		</div>
		<?php endif ?>
		<div id="insertar">
			<h1>Registrar nuevo jugador</h1>
			<form method="POST" action="index.php" enctype="multipart/form-data">
				<table>
					<tr>
						<td><label>Nombre:</label></td>
						<td><input type="text" name="vNombre"></td>
					</tr>
					<tr>
						<td><label>Apellido:</label></td>
						<td><input type="text" name="vApellido"></td>
					</tr>
					<tr>
						<td><label>Fecha de nacimiento:</label></td>
						<td><input type="date" name="vNacimiento"></td>
					</tr>
					<tr>
						<td><label>Provincia:</label></td>
						<td><input type="text" name="vProvincia"></td>
					</tr>
					<tr>
						<td><label>Equipo debutante:</label></td>
						<td><input type="text" name="vDebutante"></td>
					</tr>
					<tr>
						<td><label>Equipo actual:</label></td>
						<td><input type="text" name="vActual"></td>
					</tr>
					<tr>
						<td><label>Posición:</label></td>
						<td><select name="vPosicion">
							<option value="" selected>-- Seleccionar --</option>
							<option value="Delantero Centro">Delantero Centro</option>
							<option value="Delantero Lateral Izquierdo">Delantero Lateral Izquierdo</option>
							<option value="Delantero Lateral Derecho">Delantero Lateral Derecho</option>
							<option value="Centrocampista">Centrocampista</option>
							<option value="Lateral Derecho">Lateral Derecho</option>
							<option value="Lateral Izquierdo">Lateral Izquierdo</option>
							<option value="Defensa">Defensa</option>
							<option value="Portero">Portero</option>
						</select></td>
					</tr>
					<tr>
						<td><label>Número:</label></td>
						<td><input type="text" name="vNumero"></td>
					</tr>
					<tr>
						<td><label>Patrocinador:</label></td>
						<td><input type="text" name="vPatrocinador"></td>
					</tr>
					<tr>
						<td><label>Precio de fichaje:</label></td>
						<td><input type="text" name="vPrecio"></td>
					</tr>
					<tr>
						<td><label>Foto:</label></td>
						<td><input type="file" name="vFoto"></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Registrar"></td>
					</tr>
				</table>
			</form>
		</div>
		<div id="buscar">
			<h1>Buscador de jugadores</h1>
			<h3>Listados</h3>
			<div id="selectorlistados">
				<input type="button" value="Listado (Por Nombre)" id="b1">
				<input type="button" value="Listado (Por Numero)" id="b2">
				<input type="button" value="Listado (Por Equipo y Nombre)" id="b3">
				<input type="button" value="Listado Sub-17" id="b11">
				<input type="button" value="Listado Sub-21" id="b12">
				<input type="button" value="Listado Jugadores Senior" id="b13">
			</div>
			<h3>Búsquedas</h3>
			<div id="selectorbusquedas">
				<input type="button" value="Búsqueda (Por Equipo)" id="b4">
				<input type="button" value="Búsqueda (Por Posicion)" id="b5">
				<input type="button" value="Búsqueda (Por equipo debutante)" id="b6">
				<input type="button" value="Búsqueda (Por Provincia)" id="b7">
				<input type="button" value="Búsqueda (Patrocinados por marca)" id="b8">
				<input type="button" value="Búsqueda (Por Nombre y Apellido)" id="b9">
				<input type="button" value="Búsqueda (Por Numero)" id="b10">
			</div>
			<div id="formularios">
				<div id="bus1">
					<h3>Buscar por equipo:</h3>
					<label>Equipo:</label>
					<input type="text" name="actual">
					<input type="button" value="Buscar" id="bus1Submit">
				</div>
				<div id="bus2">
					<h3>Buscar por posicion:</h3>
					<label>Posición:</label>
					<select name="posicion">
						<?php
							//Genera las distintas opciones de las posiciones en la BDD
							require_once("sql/conexion.php");
							$query = "SELECT DISTINCT posicion FROM jugadores";
							$res = mysqli_query($con,$query);
							if($res)
							{
								$x = 0;
								$row = mysqli_fetch_row($res);
								do{
									echo '<option value="'.$row[0].'" id="pat'.$x.'">'.$row[0].'</option>';
									$x++;
								}while($row = mysqli_fetch_row($res));
							}
						?>
					</select>
					<input type="button" value="Buscar" id="bus2Submit">
				</div>
				<div id="bus3">
					<h3>Buscar por equipo debutante:</h3>
					<label>Equipo:</label>
					<input type="text" name="debutante">
					<input type="button" value="Buscar" id="bus3Submit">
				</div>
				<div id="bus4">
					<h3>Buscar por provincia:</h3>
					<label>Provincia:</label>
					<input type="text" name="provincia">
					<input type="button" value="Buscar" id="bus4Submit">
				</div>
				<div id="bus5">
					<h3>Buscar por patrocinadores:</h3>
					<?php
						//Genera checkboxes con los distintos patrocinadores
						$query = "SELECT DISTINCT patrocinador FROM jugadores";
						$res = mysqli_query($con,$query);
						if($res)
						{
							$x = 0;
							$row = mysqli_fetch_row($res);
							do{
								if($row[0]!="" || $row[0]!=null)
									echo '<input type="checkbox" id="'.str_replace(" ", "_", $row[0]).'"><label>'.$row[0].'</label> ';
								$x++;
							}while($row = mysqli_fetch_row($res));
						}
						endconnection();
					?>
					<br><input type="button" value="Buscar" id="bus5Submit">
				</div>
				<div id="bus6">
					<h3>Buscar por nombre y/o apellidos:</h3>
					<label>Nombre:</label>
					<input type="text" name="nombre"><br>
					<label>Apellido:</label>
					<input type="text" name="apellido">
					<input type="button" value="Buscar" id="bus6Submit">
				</div>
				<div id="bus7">
					<h3>Buscar por número:</h3>
					<label>Número:</label>
					<input type="text" name="numero">
					<input type="button" value="Buscar" id="bus7Submit">
				</div>
			</div>
			<h3>Resultados</h3>
			<div id="resultados">
				<h3>Por favor, introduzca un criterio de búsqueda.</h3>
			</div>
			<div class="loading" id="loadscr">
					<img src="img/Loading.gif">
			</div>

		</div>
	</div>
</body>
</html>