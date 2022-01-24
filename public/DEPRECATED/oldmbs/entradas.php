<script language="javascript">
function insertimg(){
var imgurl;
imgurl = prompt("Introduzca la URL de la imagen", "http://");
editor.contenido.value+="<img src=\"" + imgurl + "\" align=\"left\" />";
}

function inserturl(){
var url;
var title;
url = prompt("Introduzca la URL destino", "http://");
title= prompt("Introduzca el texto del enlace (Opcional)", "");
if (url == "" || url == null){
alert("¡Es necesario especificar una URL de destino!");
exit;
}
if (title != ""){
	editor.contenido.value+="<a href=\"" + url + "\">" + title + "</a>";
	}else{
	editor.contenido.value+="<a href=\"" + url + "\">" + url + "</a>";
	}
}

function insertb(){
editor.contenido.value+="<b></b>"
}

function inserti(){
editor.contenido.value+="<i></i>"
}

function insertu(){
editor.contenido.value+="<u></u>"
}

function insertbr(){
editor.contenido.value+="<br>"
}

function insertbquote(){
editor.contenido.value+="<bquote></bquote>"
}
</script>

<?php
require("res/connect.php");
$entry = $_GET['eid'];
echo "<h1>EDITOR DE ENTRADAS</h1><br><font size=1>Magnus Blog Software</font><br>";
if($entry != "" || $entry != null || $entry != 0){
echo("<font size=1 color=\"red\">ESTAS <u>EDITANDO</u> LA ENTRADA:</font>");
}else{
echo("<font size=1 color=\"blue\">ESTAS CREANDO LA ENTRADA:</font>");
}

if($entry == "" || $entry == null || $entry == 0){
echo('<form name="editor" action="insert.php" method="post">');
}else{
echo('<form name="editor" action="modify.php?eid=' . $entry . '" method="post">');
}

if($entry == "" || $entry == null || $entry == 0){
echo('Titulo <input type="text" name="titulo" value="Titulo"><br>');
}else{
$result = mysql_query("SELECT titulo FROM entradas WHERE id=" . $entry);
$row = mysql_fetch_array($result);
echo('Titulo <input type="text" name="titulo" value="' . $row['titulo'] . '"><br>');
}
echo('Contenido (Acepta HTML)<br>');
echo('<div style="background-color:cyan"><button name="img_" type="button" onclick="insertimg()">IMG</button><button name="url_" type="button" onclick="inserturl()">URL</button><button name="url_" type="button" onclick="insertb()"><b>B</b></b></button><button name="url_" type="button" onclick="inserti()"><i>I</i></button><button name="url_" type="button" onclick="insertu()"><u>U</u></button><button name="url_" type="button" onclick="insertbr()">br</button><br><button name="bquote_" type="button" onclick="insertbquote()"><img src="img/quote.png" /></button><br></div>');
if($entry == "" || $entry == null || $entry == 0){
echo('<textarea name="contenido" rows="20" cols="50"></textarea><br>');
}else{
$result = mysql_query("SELECT contenido FROM entradas WHERE id=" . $entry);
$row = mysql_fetch_array($result);
echo('<textarea name="contenido" rows="20" cols="50">' . $row['contenido'] . '</textarea><br>');
}

if($entry == "" || $entry == null || $entry == 0){
echo('Tags <input type="text" name="tags"><br>');
}else{
$result = mysql_query("SELECT tags FROM entradas WHERE id=" . $entry);
$row = mysql_fetch_array($result);
echo('Tags <input type="text" name="tags" value="' . $row['tags'] . '"><br>');
}
echo('Contrasena <input type="password" name="password"><br>');

if($entry == "" || $entry == null || $entry == 0){
echo('<button name="insertar" type="submit">Publicar</button><button name="reset" type="reset">Resetear</button><br>');
}else{
echo('<button name="insertar" type="submit">Modificar</button><button name="reset" type="reset">Resetear</button><br>');
}
echo('</form>');
?>