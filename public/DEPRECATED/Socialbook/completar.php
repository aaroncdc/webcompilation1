<?php
	require_once('tools/sbtools.php');
	
	function jstimeout(){
		echo "<script language=\"javascript\">";
		echo "setTimeout(\"window.location.href='portada.php';\", 3000);";
		echo "</script>";	
	}

	$bdate = $_POST['selAnyo'] + "-" + $_POST['selMes'] + "-" + $_POST['selDia'];
	
	if($mysqlman->sqlquery("CALL NewUser('".$_POST['txtNombre']."', '".$_POST['txtApe1']."', '".$_POST['txtApe2']."', '".$_POST['txtMail']."', NOW(), '".$bdate."', '".$_POST['txtDir']."', '".$_POST['selPais']."', '".$_POST['txtFijo']."', '".$_POST['txtMovil']."', '".$_POST['txtDesc']."', '".$_POST['txtPasswd']."', '".$_POST['txtHash']."')"))
                echo("<h1>Registro completado</h1>");
			else
                echo("<h1>Registro no completado</h1> " . $mysqlman->sqlerror());
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width-device-width, initial-scale=1"/>
        <link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
        <link href="css/solarized.css" rel="stylesheet" type="text/css"/>
        
        <script src="res/country-esp.js" type="text/javascript"></script>
        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
        <script src="js/jquery.kwicks-1.5.1.pack.js" type="text/javascript"></script>
        <title>Registrarse en Socialbook...</title>
        <?php
			if(setSession($_POST['txtMail'], $_POST['txtPasswd']))
					jstimeout();
		?>
	</head>
	<body>
	<h1>Resúmen...</h1>
	<table border="1">
	<tr>
	<td>Nombre: </td>
	<td><?php echo $_POST['txtNombre']; ?></td>
	<td>Apellidos: </td>
	<td><?php echo $_POST['txtApe1']; $_POST['txtApe2']; ?></td>
	</tr>
	<tr>
	<td>Dirección: </td>
	<td colspan="3"><?php echo $_POST['txtDir']; ?></td>
	</tr>
	<tr>
	<td>País: </td>
	<td colspan="3"><?php echo $_POST['selPais']; ?></td>
	</tr>
	<tr>
	<td>Fecha de Nacimiento: </td>
	<td><?php echo $bdate; ?></td>
	<td></td>
	<td></td>
	</tr>
	<tr>
	<td>Teléfono (Fijo): </td>
	<td><?php echo $_POST['txtFijo']; ?></td>
	<td>Teléfono (Movil): </td>
	<td><?php echo $_POST['txtMovil']; ?></td>
	</tr>
    <tr>
    <td>Correo:</td>
    <td colspan="3"><?php echo $_POST['txtMail']; ?></td>
    </tr>
	<tr>
	<td>Tu descripción: </td>
	<td colspan="3"><?php echo $_POST['txtDesc']; ?></td>
	</tr>
	</table>
	</body>
</html>
<?php
	$mysqlman->endconnection();
?>