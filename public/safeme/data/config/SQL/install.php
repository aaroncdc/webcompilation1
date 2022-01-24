<?php
	/* Archivos de configuracion */
	require_once('data/config/.config.php');
	require_once('.trusted.php');
	
	echo('<link rel="stylesheet" href="css/solarized.css"/>');
	
	//Fecha y hora actual
	$timestamp = date('d/m/Y h:i:s a', time());
	//IP del solicitante
	$guest = $_SERVER['REMOTE_ADDR'];
	//PROXY desde el que se conecta el solicitante
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];
	
	$usqli = function_exists('mysqli_connect');
	
	/* Comprobar si el solicitante se encuentra en la lista de IPs admitidas */
	//En caso contrario, se le deniega el acceso al programa.
	if($checkclientaddr)
		if(!check_guest($guest))
			die("<h1>ACCESS DENIED</h1><br/><h4>You do not have permission to access this resource.</h4>");
	
	//Crear un log donde se registra todo lo que ocurra
	$logfile = @fopen("./.install_log", "a+");
	
	echo ("<center><h1>DATABASE AUTOINSTALLER</h1>");
	echo ("<pre>By Aaron C.d.C (aaroncdcalcala@gmail.com)</pre><hr/></center>");
	
	/* Mostrar y obtener la hora y el solicitante, y en qu� servidor se est� realizando la acci�n */
	echo("<pre><b>TIMESTAMP: </b>" . $timestamp . " </pre>");
	fwrite($logfile,"-- INSTALL REQUEST --\nTIMESTAMP: " . $timestamp . "\n");
	echo("<pre><b>HOST: </b>" . constant('hostname') . " </pre>");
	fwrite($logfile,"HOST: " . constant('hostname') . "\n");
	echo("<pre><b>REQUEST BY: </b>" . $guest . " </pre>");
	fwrite($logfile,"GUEST: " . $guest . "\n");
	if(isset($proxy)) {
		echo("<pre><b>PROXY: </b>" . $proxy . " </pre>");
		fwrite($logfile,"PROXY: " . $proxy . "\n");
	}else{
		echo("<pre><b>PROXY NOT DETECTED </b></pre>");
		fwrite($logfile,"PROXY NOT DETECTED\n");
	}
	
	if($usqli)
	{
		echo("<pre><b>MYSQLI Extension detected, using it. </b> </pre><hr/>");
		fwrite($logfile,"MYSQLI Extension detected, using it.\n");
	}else{
		echo("<pre><b>MYSQLI Extension not detected. Using standard MySQL </b> </pre><hr/>");
		fwrite($logfile,"MYSQLI Extension not detected. Using standard MySQL\n");
	}
	
	//Abrir el script con los datos de la base de datos
	$sqlfile = file("data/config/SQL/install.sql", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	//Conectar con la base de datos
	if($usqli)
		$session = mysqli_connect(constant('hostname'),
			constant('db_username'), constant('db_password'), '') or die("<h1>" . mysqli_connect_error() . "</h1>");
	else
		$session = mysqli_connect(constant('hostname'),
			constant('db_username'), constant('db_password')) or die("<h1>" . mysqli_connect_error() . "</h1>");
	
	/* Funciones para mostrar mensajes */
	function printmsg($msg) {
		echo("<b>" . $msg ."</b><hr/>");
	}
	
	function printerror($msg) {
		echo("<b><font color=\"red\">Error:</font>" . $msg ."</b><hr/>");
	}
	
	function printsuccess($msg) {
		echo("<b><font color=\"green\">O </font>" . $msg ."</b><hr/>");
	}
	
	//Variable con cada query
	$query = "";
	
	//Procesar el archivo sql y ejecutar todas las acciones contenidas en �l
	if($sqlfile)
	{
		foreach($sqlfile as $line_num => $line)
		{
			$query .= $line;
			if(substr($line, -1) == ';')
			{
				$tquery = str_replace("@tp", constant('tab_prefix'), str_replace("@db", constant('db_name'), $query));
				$timestamp = date('d/m/Y h:i:s a', time());
				echo "<pre>" . $tquery . "</pre><br/>";
				if($usqli)
					$qr = mysqli_query($session, $tquery);
				else
					$qr = mysql_query($tquery);
					
				if($qr)
				{
					printsuccess("Query OK");
					fwrite($logfile,"\n" .$timestamp .": query: " . $tquery . "\nOK\n");
					$query = "";
				}else{
					fwrite($logfile,"\n" .$timestamp .": query: " . $tquery . "\nERROR\n" . mysql_error() ."\n");
					if($usqli)
						printerror(" @ " . $line_num . ": " . mysqli_error($session));
					else
						printerror(" @ " . $line_num . ": " . mysql_error());
					$query = "";
				}
			}
		}
		fwrite($logfile,"\n-- END OF LOG FILE --\n");
		fclose($logfile);
	}else{
		fwrite($logfile,"\n-- ERROR OPENING SQL FILE --\n");
		die("<h1>Error: could not open SQL file</h1>");
		fclose($logfile);
	}
	
	if($usqli)
		mysqli_close($session);
	else
		mysql_close($session);
	