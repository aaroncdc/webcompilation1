<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Noticias Haxorzone</title>
<style type="text/css">
<!--
body,td,th {
	color: #000000;
}
body {
	background-color: #FFFFFF;
}
-->
</style></head>

<body>
<table width="473" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="472" height="54" valign="top"><?php
	$link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
	mysql_select_db("magnus98_userlist", $link);
	
	if (! $link){
	echo '<font color="#FF0000">Connection with SQL database failed! (Hoy no hay noticias)</font>';
	exit;
	}
	
	$news = mysql_query("SELECT * FROM news", $link);
	$count=9999;
	while($count > -1){
	if(mysql_result($news, $count, "text") != ""){
	echo '<hr />';
	echo '<h3>' . mysql_result($news, $count, "title") . '</h>';
	echo "\n";
	echo '<hr />';
	echo "\n";
	echo '<h5>Posteado el ' . mysql_result($news, $count, "date") . '</h5>';
	echo "\n";
	echo mysql_result($news, $count, "text");
	echo '<hr />';
	echo "\n";
	}
	$count--;
	}
	?>      &nbsp;</td>
  <td width="1">&nbsp;</td>
  </tr>
  <tr>
    <td height="353">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
