<?php
echo '<h1>Haga click en una entrada para modificarla</h1><hr>';
require("../res/connect.php");
$result = mysql_query('SELECT id, titulo, fecha FROM entradas');
$count=0;
if ($row = mysql_fetch_array($result)){
do {
$count++;
echo "<font size=2>". $count . " - " . $row['fecha'] . " <a href=\"../entradas.php?eid=" . $row['id'] . "\">" . $row['titulo'] . "</a></font><br><hr>";
} while ($row = mysql_fetch_array($result));
}else{
echo '<h2>NO HAY ENTRADAS EN ESTE BLOG.</h2>';
}
?>