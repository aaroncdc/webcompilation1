<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<?php require_once("headerdata.php"); ?>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/validacion.js"></script>
</head>
<body>
<div id="main-container">
<header>
    <a href="index.php"><img src="static/logopidger.png" class="logohead">
    <span class="title title-bootstrap">Pidger</span></a>
</header>
	<aside id="error"><strong>¡Parece que hay algunos errores!</strong> <p>Los campos marcados en ROJO contienen errores. Por favor, corrígelos para poder continuar.</p></aside>
		<div id="formulario">
			<h1>Registrarse en Pidger</h1>
			<form method="POST" action="regnewuser.php">
			<fieldset>
					<legend>Información de cuenta</legend>
					<table>
						<tr>
							<td><label>Nombre de usuario (*):</label></td>
							<td><input type="text" name="vUsuario" data-toggle="tooltip" title="Un nombre de usuario. No tiene por qué ser tu nombre real.">
							<div class="alert alert-danger" id="alert-1">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
						</td>
						</tr>
						<tr>
							<td><label>Contraseña (*):</label></td>
							<td><input type="password" name="vPassword" data-toggle="tooltip" title="Una contraseña. Debe contener 6 caracteres, incluyendo letras y números.">
							<div class="alert alert-danger" id="alert-2">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
						<tr>
							<td><label>Repetir contraseña (*):</label></td>
							<td><input type="password" name="vRPassword" data-toggle="tooltip" title="Repite la mísma contraseña que has escrito en el apartado anterior.">
							<div class="alert alert-danger" id="alert-3">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Datos Personales</legend>
					<table>
						<tr>
							<td><label>Nombre (*):</label></td>
							<td><input type="text" name="vNombre" data-toggle="tooltip" title="Tu nombre. Éste sí debería ser el nombre real.">
							<div class="alert alert-danger" id="alert-4">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
						<tr>
							<td><label>Apellidos:</label></td>
							<td><input type="text" name="vApellidos" data-toggle="tooltip" title="Tus apellidos.">
							</td>
						</tr>
						<tr>
							<td><label>Fecha de nacimiento (*):<label></td>
							<td><input type="date" name="vNacimiento" data-toggle="tooltip" title="Tu fecha de nacimiento (dia, mes y año)">
							<div class="alert alert-danger" id="alert-5">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
						<tr>
							<td><label>Sexo:</label></td>
							<td><select name="vSexo" data-toggle="tooltip" title="Tu género. Si te incomoda, puedes dejarlo sin especificar.">
								<option value="N">Sin especificar</option>
								<option value="H">Hombre</option>
								<option value="M">Mujer</option>
								<option value="O">Otro</option>
							</select></td>
						</tr>
						<tr>
							<td><label>Dirección:</label></td>
							<td><textarea name="vDireccion" data-toggle="tooltip" title="Aquí puedes escribir tu dirección física."></textarea>
							</td>
						</tr>
						<tr>
							<td><label>Nacionalidad:</label></td>
							<td><select name="vNacionalidad" data-toggle="tooltip" rel="" title="Selecciona cual es tu país de origen.">
								<?php
									$fl = false;
									if (($gestor = fopen("csv/paises.csv", "r")) !== FALSE){
										while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE){
											if(!$fl)
											{
												$fl = true;
												continue;
											}
											echo '<option name="'.$datos[5].'" value="'.$datos[0].'">'.$datos[0].'</option>';
										}
									}
								?>
							</select>
						</td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Contacto</legend>
					<table>
						<tr>
							<td><label>Correo Electrónico (*):</label></td>
							<td><input name="vCorreo" type="text" data-toggle="tooltip" title="Escribe aquí una dirección de correo válida.">
							<div class="alert alert-danger" id="alert-6">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
						<tr>
							<td><label>Teléfono:</label></td>
							<td><input name="vTelefono" type="text" data-toggle="tooltip" title="Introduce un número de teléfono"></td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Lo que nadie se lee</legend>
					<table>
						<tr>
							<td><label>Condiciones de uso (*):</label></td>
							<td><input type="checkbox" name="vCondiciones" data-toggle="tooltip" title="Debes aceptar nuestras condiciones de uso para continuar."> He leido y acepto las <a href="legal/condiciones.html" target="_blank">condiciones de uso</a> de éste sitio web.
							<div class="alert alert-danger" id="alert-7">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
						<tr>
							<td><label>Newsletter:</label></td>
							<td><input name="vNews" type="checkbox" data-toggle="tooltip" title="(OPCIONAL). Recibirás correos con noticias si marcas ésta casilla. Si la desmarcas, recibirás sólo mensajes importantes."> Deseo recibir noticias acerca del sitio en mi correo.</td>
						</tr>
						<tr>
							<td><label>Cookies (*):</label></td>
							<td><input name="vCookies" type="checkbox" data-toggle="tooltip" title="Es información acerca de las cookies que usamos en nuestro sitio. Debes aceptar usarlas."> He leido y acepto las <a href="legal/cookies.html" target="_blank">políticas de cookies</a> de éste sitio web.
							<div class="alert alert-danger" id="alert-8">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
						<tr>
							<td><label>Privacidad (*):</label></td>
							<td><input name="vPrivacidad" type="checkbox" data-toggle="tooltip" title="Es información acerca del uso que le damos a tus datos. Debes leer las condiciones y aceptarlas."> He leido y acepto las <a href="legal/privacidad.html" target="_blank">políticas de privacidad</a> de éste sitio web.
							<div class="alert alert-danger" id="alert-9">
							<strong>Error:</strong> El nombre de usuario debe contener al menos 5 caracteres.
							</div>
							</td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Finalizar</legend>
					<table>
						<tr>
							<td colspan="2"><input type="submit" value="Completar registro" id="subm"></td>
						</tr>
					</table>
				</fieldset>
				</form>
			<p><strong>Nota: </strong> Los campos marcados con un asterísco (*) son <em>obligatorios</em>.</p>
		</div>
		<footer></footer>
	</div>
</body>
</html>