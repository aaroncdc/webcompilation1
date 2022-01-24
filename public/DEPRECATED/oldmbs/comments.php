<?php
require("res/connect.php");
	
	$num = $_GET["entry"];
	$cit = $_GET["quote"];
	$result = mysql_query("SELECT nombre, mail, web, contenido FROM comentarios WHERE nent=" . $num, $link);
	if ($row = mysql_fetch_array($result)){

echo "<table border = '1'> \n";
echo "<tr> \n";
echo "<td><b>Nombre</b></td> \n";
echo "<td><b>E-Mail</b></td> \n";
echo "<td><b>Web</b></td> \n";
echo "<td><b>Comentario</b></td> \n";
echo "</tr> \n";
do {
echo "<tr> \n";
echo "<td>".$row["nombre"]."</td> \n";
echo "<td><a href=\"".$row["mail"]. "\">" . $row["mail"] . "</a></td>\n";
echo "<td><a href=\"".$row["web"]."\">" . $row["web"] . "</a></td>\n";
echo "<td>".$row["contenido"]."</td>\n";
echo "</tr> \n";

} while ($row = mysql_fetch_array($result));

} else {

echo "NO HAY COMENTARIOS DISPONIBLES. &#161;SE TU EL PRIMERO!";

}


	echo($name);
	echo('<form action="sendcomment.php" method="post">');
	echo('<input type="hidden" name="nent" value="' . $num . '">');
	echo('Nombre: <input type="text" name="nombre"><p></p>');
	echo('Mail: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="mail"><p></p><font size=1 color="#FF0000">NOTA: EL MAIL SERA VISIBLE, DEJALO EN BLANCO SI NO QUIERES PONERLO</font><p></p>');
	echo('Website: <input type="text" name="web"></input><p></p>');
	echo('Comentario:<p></p>');
if($cit != "" || $cit != null){
	echo('<textarea name="comentario" rows="10" cols="50"><quote>' . $cit . '</quote><br> Su comentario</textarea><p></p>');
}else{
echo('<textarea name="comentario" rows="10" cols="50">Inserte un comentario aqui</textarea><p></p>');
}
	echo('<button name="comentar" type="submit">Comentar</button><button type="reset">Reiniciar</button>');
	echo('</form>');
?>
