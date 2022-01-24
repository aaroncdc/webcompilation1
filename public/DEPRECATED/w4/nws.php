<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>news</title>
</head>

<body>
<?php
	$link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
	mysql_select_db("magnus98_userlist", $link);
	
	if (! $link){
	echo '<font color="#FF0000">Connection with SQL database failed! (Hoy no hay noticias)</font>';
	exit;
	}
	
	$count = $_GET["count"];
	
	$news = mysql_query("SELECT * FROM news", $link);
	if(mysql_result($news, $count, "text") != ""){
	echo '<b>' . mysql_result($news, $count, "date") . '</b><br /><br />';
	echo mysql_result($news, $count, "text");
	}
	?>
</body>
</html>
