<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form action="uploadtest.php" method="post" enctype="multipart/form-data">
    <b>Campo de tipo texto:</b>
    <br>
    <input type="text" name="cadenatexto" size="20" maxlength="100">
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    <br>
    <br>
    <b>Enviar un nuevo archivo: </b>
    <br>
    <input name="userfile" type="file">
    <br>
    <input type="submit" value="Enviar">
</form>
<?php
//tomo el valor de un elemento de tipo texto del formulario
$cadenatexto = $_POST["cadenatexto"];
echo "Escribió en el campo de texto: " . $cadenatexto . "<br><br>";

//datos del arhivo
$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];
//compruebo si las características del archivo son las que deseo
if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 100000))) {
    echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
}else{
    if (move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $nombre_archivo)){
       echo "El archivo ha sido cargado correctamente.";
    }else{
       echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
    }
}
?> 
</body>
</html>
