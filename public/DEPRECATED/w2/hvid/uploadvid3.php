<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>HAXORZONE - PORTADA</title>
<style type="text/css">
<!--
body {
	background-color: #E2E2E2;
}
body,td,th {
	color: #00FF00;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
a:link {
	color: #FFFF00;
}
a:visited {
	color: #FF0000;
}
a:hover {
	color: #FF9900;
}
a:active {
	color: #FF9966;
}
.Estilo6 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF}
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {color: #FF0000}
-->
</style>
</head>

<body>
<table width="867" border="0" cellpadding="0" cellspacing="0" bgcolor="#E2E2E2">
  <!--DWLayoutTable-->
  <tr>
    <td width="103" height="19"></td>
    <td colspan="14" valign="top" bgcolor="#FFFFFF"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr>
    <td height="98"></td>
    <td colspan="4" valign="top" bgcolor="#0707FF"><img src="../img/hz_headlogo.jpg" width="179" height="98" /></td>
    <td colspan="10" valign="top" bgcolor="#0504FF"><img src="../img/hz_headtitle.jpg" width="420" height="98" /></td>
  </tr>
  <tr>
    <td height="36"></td>
    <td width="86" valign="top" background="../../img/butt/01.jpg" bgcolor="#FFFFFF"><a href="../index.html"><img src="../img/butt/01.jpg" width="84" height="36" border="0" /></a></td>
    <td width="86" valign="top" background="../../img/butt/02.jpg" bgcolor="#FFFFFF"><a href="../news.html"><img src="../img/butt/02.jpg" width="84" height="36" border="0" /></a></td>
    <td colspan="3" valign="top" background="../../img/butt/03.jpg" bgcolor="#FFFFFF"><a href="../computers.html"><img src="../img/butt/03.jpg" width="84" height="36" border="0" /></a></td>
    <td width="84" valign="top" background="../../img/butt/04.jpg" bgcolor="#FFFFFF"><a href="../music.html"><img src="../img/butt/04.jpg" width="84" height="36" border="0" /></a></td>
    <td colspan="2" valign="top" background="../../img/butt/05.jpg" bgcolor="#FFFFFF"><a href="../videos.html"><img src="../img/butt/05.jpg" width="84" height="36" border="0" /></a></td>
    <td width="84" valign="top" background="../../img/butt/06.jpg" bgcolor="#FFFFFF"><a href="http://chat.crearwebgratis.com/index.php?chat=ElchatdeHaxorzone"><img src="../img/butt/06.jpg" width="84" height="36" border="0" /></a></td>
    <td colspan="2" valign="top" background="../../img/butt/07.jpg" bgcolor="#FFFFFF"><img src="../img/butt/07.jpg" width="84" height="36" /></td>
    <td width="84" valign="top" background="../../img/tab.jpg" bgcolor="#FFFFFF"><a href="../sponsors.html"><img src="../img/butt/08.jpg" width="84" height="36" border="0" /></a></td>
    <td colspan="2" valign="top"><a href="../info.html"><img src="../img/butt/09.jpg" width="84" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td height="19"></td>
    <td colspan="14" valign="top" bgcolor="#0000FE"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr>
    <td height="58"></td>
    <td colspan="3" rowspan="3" valign="top" bgcolor="#0000FE">
      
      <div align="center"><span class="Estilo5">INICIO DE SESI&Oacute;N</span></div>
      <form action="../login.php" method=POST>
        <br />
        User:&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="text" name="user" />
        <br />
        C&oacute;digo:
        <input type="password" name="password" />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit" value="Entrar" />
        <br />
      <a href="../register.php">Registrarse</a>
      </form>
    
    <td colspan="10" valign="top" bgcolor="#FFFFFF"><img src="../img/video.jpg" width="504" height="58" />
    <td width="40" rowspan="5" valign="top" bgcolor="#FFFFFF"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr>
    <td height="30"></td>
    <td colspan="4" valign="top" bgcolor="#FFFFFF"> <span class="Estilo7">_    
    </span>
    <td colspan="3" valign="top" bgcolor="#FFFFFF">            <h2 class="Estilo6">SUBIR VIDEO                  </h2>
  <td colspan="3" valign="top" bgcolor="#FFFFFF"><span class="Estilo7">_  </span>  </tr>
  <tr>
    <td height="56"></td>
    <td colspan="10" rowspan="3" valign="top" bgcolor="#FFFFFF"><form action="uploadvid3.php" method="post" enctype="multipart/form-data">
    
      <div align="left">
        <input type="hidden" name="MAX_FILE_SIZE" value="10486000">
        <br>
        <br>
        <b>Enviar un nuevo video (No m&aacute;s de 10Mb, formatos MPG y WMV):<br />
          T&iacute;tulo:</b> &nbsp;&nbsp;
          <input type="text" name="title" />
          <br />
          <strong>Archivo:</strong> 
          <input name="userfile" type="file">
          <br />
          <strong>Comentarios:</strong><br />
          <textarea name="comment"></textarea>
          <br>
          <input type="submit" value="Enviar">
          <br />
          <span class="Estilo8">&iexcl;ATENCI&Oacute;N! </span>
          <span class="Estilo9">Cualquier video con contenido protegido por la ley ser&aacute; BORRADO y el usuario BANEADO.<br />
          </span>      </div>
  </form>
  <?php
//datos del arhivo
$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];
$titulo=$_POST['title'];
$comment=$_POST['comment'];
//compruebo si las características del archivo son las que deseo
if (!((strpos($tipo_archivo, "mpg") || strpos($tipo_archivo, "wmv")) && ($tamano_archivo < 10486000))) {
    echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .mpg o .wmv<br><li>se permiten archivos de 10Mb máximo (Unos 10 minutos).</td></tr></table>";
}else{
	echo '<img src="esladt.gif" /> Espere mientras se sube el video, puede tardar hasta 30 minutos dependiendo de su conexión y el estado del servidor.';
    if (move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], $nombre_archivo)){
       //conexion con la base de datos para agregar el video
	   $link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
		mysql_select_db("magnus98_userlist", $link);

		if (! $link){
		echo '<font color="#FF0000">Connection with SQL database failed!</font>';
		exit;
		}
		//insercion en la base de datos
		$urlx = $nombre_archivo;
		$sql = "INSERT INTO video (title, url, comment) ";
		$sql .= "VALUES ('$titulo', '$urlx', '$comment')";
		$result = mysql_query($sql);
		echo mysql_errno().": ".mysql_error()."<BR>";
		
	   echo "El archivo ha sido cargado correctamente. ¡Muchas gracias por su aportación!";
    }else{
       echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
    }
}
?>  </tr>
  <tr>
    <td height="90"></td>
    <td colspan="3" valign="top" bordercolor="#FF0000" bgcolor="#0000FF" style="border:groove">      <div align="center">BUSCAR<br />
      <input type="text" name="search" />
      <img src="../img/magnify.JPG" width="37" height="35" /><br />
      <input type="submit" name="Submit2" value="Buscar" />
    </div>
  </tr>
  <tr>
    <td height="201"></td>
    <td colspan="3" rowspan="3" valign="top" bgcolor="#FFFFFF">      
  </tr>
  
  

  <tr>
    <td height="57"></td>
    <td colspan="11" valign="top" bgcolor="#FFFFFF"><a href="http://www.freedomain.co.nr" style="border:hidden"><img src="http://magnus98.freeweb7.com/img/conr_ad.gif" /></a><img src="../img/firefox-anim110x32.gif" width="110" height="32" />&nbsp;</td>
  </tr>
  <tr>
    <td height="60"></td>
    <td colspan="11" valign="top" bgcolor="#FFFFFF"><div align="center">VISITANTES</span><br />
        <img src="http://www.easycounter.com/counter.php?pollavestruz" alt="Hit Counter" width="125" height="24"
border="0" />&nbsp;</div></td>
  </tr>
  
  
  
  
  
  
  <tr>
    <td height="25"></td>
    <td colspan="14" valign="top" bgcolor="#FFFFFF"><!--DWLayoutEmptyCell-->&nbsp;</td>
  </tr>
  <tr>
    <td height="99"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="48">&nbsp;</td>
    <td width="36">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="7">&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="74">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="44">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
