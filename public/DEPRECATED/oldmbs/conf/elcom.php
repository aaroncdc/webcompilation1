<?php
echo '<h1>Haga click en un comentario para ELIMINARLO del blog</h1><hr>';
require("../res/connect.php");
$result = mysql_query('SELECT id, nent, nombre, contenido FROM comentarios ORDER BY nent ASC');
if ($row = mysql_fetch_array($result)){
do {
echo "<font size=2>" . $row['nent'] . " - " . $row['nombre'] . " - " . $row['contenido'] . " <a href=\"eldefcom.php?eid=" . $row['id'] . "\">Eliminar</a></font><br><hr>";
} while ($row = mysql_fetch_array($result));
}else{
echo '<h2>NO HAY COMENTARIOS EN ESTE BLOG.</h2>';
}
?>