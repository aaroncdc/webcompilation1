<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    require_once 'config/connect.php';
    require_once 'tools/hashgen.php';
        
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $bdate = $_POST['selAnyo'] . "-" . $_POST['selMes'] . "-" . $_POST['selDia'];
		echo $bdate;
        $USHASH = genhash();
        $uspsswd = md5($_POST['psswd_'], constant('md5hash'));
            if($mysqlman->sqlquery("INSERT INTO usuarios VALUES ('SELECT MAX(usuarios)', '".$_POST['nombre_']."', '".$_POST['ape1_']."', '".$_POST['ape2_']."', '".$_POST['correo_']."', NOW(), '".$bdate."', '".$_POST['direccion_']."', '".$_POST['pais_']."', '".$_POST['telefono_']."', '".$_POST['movil_']."', '".$_POST['descripcion']."', '".$uspsswd."', '".$USHASH."')"))
                echo("<h1>Registro completado</h1>");
            else
                echo("<h1>Registro no completado</h1> " . $mysqlman->sqlerror());
        ?>
    </body>
</html>
<?php endconnection(); ?>
