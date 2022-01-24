<html>
<body>
<?php
require("res/connect.php");
	$num = $_GET["entry"];
	//Carga la ultima entrada de la base de datos
	if($num == null || $num == 0){
	$title = mysql_query("SELECT MAX(titulo) FROM entradas WHERE id=(SELECT MAX(id) FROM entradas)", $link);
	$date = mysql_query("SELECT MAX(fecha) FROM entradas WHERE id=(SELECT MAX(id) FROM entradas)", $link);
	$news = mysql_query("SELECT MAX(contenido) FROM entradas WHERE id=(SELECT MAX(id) FROM entradas)", $link);
	$tags = mysql_query("SELECT MAX(tags) FROM entradas WHERE id=(SELECT MAX(id) FROM entradas)", $link);
	echo '<b>' . mysql_result($title, "titulo") . '</b><br><font size=1>' . mysql_result($date, "fecha") . '</font><p>' . mysql_result($news, "contenido"). '</p></b><p></p>Tags: <a href="main.php?tags=' . mysql_result($tags, "tags") . '">' . mysql_result($tags, "tags") . '</a>';
	$result = mysql_query("SELECT * FROM comentarios WHERE nent=(SELECT MAX(id) FROM entradas)");
	$nume = mysql_num_rows($result);
	$las = mysql_query("SELECT MAX(id) FROM entradas;");
	$total = mysql_result($las, "id");
	$prev = $total - 1;
	if($prev <= 0) $prev = 1;
	$nxt = $num + 1;
	if($num == null) $nxt = 0;
	echo '<p><a href="blog.php?entry=' . $prev . '"><< Anterior | </a> <a href="archive.php"><< Archivo >> | </a> <a href="blog.php?entry=' . $nxt . '">Siguiente >></a></p>';
	echo '<a href="res/rss.php"><img src="images/rss.jpg" /></a>';
	echo '<p> <a href="comments.php?entry=' . $total . '">' . $nume . ' Comentarios (Comentar)</a><p><p></p></p>';
	$result = mysql_query("SELECT pid, nombre, mail, web, contenido, karma FROM comentarios WHERE nent=(SELECT MAX(id) FROM entradas)", $link);
	if ($row = mysql_fetch_array($result)){
do {
	echo "<hr/>";
if($row["web"] == "" || $row["web"] == null){
	echo "<b>" . $row["nombre"] . "</a></b><p>";
}else{
	echo "<a href=\"".$row["web"]."\">" . $row["nombre"] . "</a></b><p>";
}
echo $row["contenido"]."<br/>";
echo "Karma: " . $row["karma"] . "<a href=\"addk.php?pid=" . $row["pid"] . "&k=" . $row["karma"] . "\">[+]</a> <a href=\"suk.php?pid=" . $row["pid"] . "&k=" . $row["karma"] . "\">[-]</a>";
echo "<p><p></p></p>";
echo "<br/>";
} while ($row = mysql_fetch_array($result));
} else {
	echo 'NO HAY COMENTARIOS DISPONIBLES. <a href="comments.php?entry=' . $total . '">&#161;SE TU EL PRIMERO!</a>';
}
	echo($name);
	die(mysql_error());
	}else{
	//Carga la entrada deseada (si existe)
	$title = mysql_query("SELECT titulo FROM entradas WHERE id = " . $num);
	$date = mysql_query("SELECT fecha FROM entradas WHERE id = " . $num);
	$news = mysql_query("SELECT contenido FROM entradas WHERE id = " . $num);
	$tags = mysql_query("SELECT tags FROM entradas WHERE id = " . $num);
	echo '<b>' . mysql_result($title, "titulo") . '</b><br><font size=1>' . mysql_result($date, "fecha") . '</font><p></p>' . mysql_result($news, "contenido"). '</b><p></p>Tags: <a href="main.php?tags=' . mysql_result($tags, "tags") . '">' . mysql_result($tags, "tags") . '</a>';
	$result = mysql_query("SELECT * FROM comentarios WHERE nent=" . $num);
	$nume = mysql_num_rows($result);
	
	$las = mysql_query("SELECT MAX(id) FROM entradas;");
	$total = mysql_result($las, "id");	
	
	$prev = $num - 1;
	if($prev <= 0 && $num != 0) $prev = 1;
	$nxt = $num + 1;
	if($num == $total) $nxt = 0;
	echo '<p><a href="blog.php?entry=' . $prev . '"><< Anterior | </a> <a href="archive.php"><< Archivo >> | </a> <a href="blog.php?entry=' . $nxt . '">Siguiente >></a></p>';
	echo '<a href="res/rss.php"><img src="images/rss.jpg" /></a>';
	echo '<p> <a href="comments.php?entry=' . $num . '">' . $nume . ' Comentarios (Comentar)</a><p><p></p></p>';
	$result = mysql_query("SELECT pid, nombre, mail, web, contenido, karma FROM comentarios WHERE nent=" . $num, $link);
	if ($row = mysql_fetch_array($result)){
do {
	echo "<hr/>";
if($row["web"] == "" || $row["web"] == null){
	echo "<b>" . $row["nombre"] . "</a></b><p>";
}else{
	echo "<a href=\"".$row["web"]."\">" . $row["nombre"] . "</a></b><p>";
}
echo $row["contenido"]."<br/>";
echo "Karma: " . $row["karma"] . "<a href=\"addk.php?pid=" . $row["pid"] . "&k=" . $row["karma"] . "\">[+]</a> <a href=\"suk.php?pid=" . $row["pid"] . "&k=" . $row["karma"] . "\">[-]</a>";
echo "<p><p></p></p>";
echo "<br/>";
} while ($row = mysql_fetch_array($result));
} else {
echo 'NO HAY COMENTARIOS DISPONIBLES. <a href="comments.php?entry=' . $num . '">&#161;SE TU EL PRIMERO!</a>';
}
	echo($name);
	}
?>
</body>
</html>
