<?php
	$selected = $_GET['tag'];
	require("res/connect.php");
	echo '<h1>ENTRADAS ETIQUETADAS CON ' . $selected . '</h1><br><br>';
	$result = mysql_query('SELECT id, titulo, tags FROM entradas WHERE tags="' . $selected . '" ORDER BY id DESC');
	echo mysql_error();
	do{
			echo '<a href="blog.php?entry=' . $row['id'] . '">' . $row['titulo'] . '</a><hr>';
	} while ($row = mysql_fetch_array($result));
?>