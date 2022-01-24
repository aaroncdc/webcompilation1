<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="210" height="337" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  
  <tr>
    <td width="277" height="276" valign="top" style="text-align:justify"><?php
	$link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
	mysql_select_db("magnus98_userlist", $link);
	
	if (! $link){
	echo '<font color="#FF0000">Connection with SQL database failed! (Hoy no hay noticias)</font>';
	exit;
	}
	
	$news = mysql_query("SELECT * FROM shoutbox", $link);
	$count=9999;
	while($count > 0){
	if(mysql_result($news, $count, "text") != ""){
	echo '<b>' . mysql_result($news, $count, "name") . '</b>';
	echo "\n";
	echo '<b>' . mysql_result($news, $count, "date") . '</b>';
	echo '<br>';
	echo mysql_result($news, $count, "text");
	echo '</br>';
	echo '<hr />';
	echo "\n";
	}
	$count--;
	}
	?>&nbsp;</td>
  </tr>
</table>
</body>
</html>
