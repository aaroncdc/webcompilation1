<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Shoutbox</title>
<style type="text/css">
<!--
body,td,th {
	color: #0000FF;
}
body {
	background-color: #CCCCCC;
}
-->
</style></head>

<body>
<table width="198" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td width="198" height="205" valign="top"><?php
	$link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
	mysql_select_db("magnus98_userlist", $link);
	
	if (! $link){
	echo '<font color="#FF0000">Connection with SQL database failed! (Hoy no hay noticias)</font>';
	exit;
	}
	
	$news = mysql_query("SELECT * FROM shoutbox", $link);
	$count=9999;
	$entries=5;
	while($count > 0){
	if(mysql_result($news, $count, "text") != ""){
	echo '<h5>' . mysql_result($news, $count, "name") . '</h5>';
	echo "\n";
	echo mysql_result($news, $count, "date");
	echo '<br>';
	echo '<font size="-1">' . mysql_result($news, $count, "text") . '</font>';
	echo '</br>';
	echo '<hr />';
	echo "\n";
	}
	$count--;
	$entries--;
	if($entries == 0){
	exit;
	}
	}
	?>&nbsp;</td>
  </tr>
</table>
</body>
</html>
