<?php
$id = $_GET['eid'];
echo('<form name="editor" action="elentry.php?id=' . $id . '" method="post">');
echo 'Escriba su contraseña y acepte para BORRAR la ENTRADA de la base de datos de su servidor.<br><br>';
echo('Contrasena <input type="password" name="password"><button name="aceptar" type="submit">Aceptar</button>');
echo('</form>');
?>