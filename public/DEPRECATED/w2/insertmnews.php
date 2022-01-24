<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INSERTAR NUEVA NOTICIA</title>
<style type="text/css">
<!--
body,td,th {
	color: #0000FF;
}
body {
	background-color: #000000;
}
-->
</style></head>

<body>
<table width="747" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="219" height="55">&nbsp;</td>
    <td width="321">&nbsp;</td>
    <td width="207">&nbsp;</td>
  </tr>
  <tr>
    <td height="306">&nbsp;</td>
    <td valign="top"><div align="center">T&Iacute;TULO</div>
      <div align="center">
	  <form action="insertmnews2.php" method=POST>
        <div align="center">
          <input name="title" type="text" id="title" />
          </div>
          <div align="center">
          <br />
          TEXTO<br />
          <textarea name="news" id="news" rows="20" cols="50"></textarea>
          <input type="submit" name="Submit" value="Enviar" />
        </div>
	  </form>
	  <?php
		$link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
		mysql_select_db("magnus98_userlist", $link);

		if (! $link){
		echo '<font color="#FF0000">Connection with SQL database failed!</font>';
		exit;
		}
		
		$title=$_POST['title'];
		$text=$_POST['news'];
		$textt=$_POST['news'];
		if($textt != ""){
		$sql = "INSERT INTO music_news (title, date, text) ";
		$sql .= "VALUES ('$title', NOW(), '$text')";
		$result = mysql_query($sql);
		echo mysql_errno().": ".mysql_error()."<BR>";
		}
		?>
        <br />
        <br />
      </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
