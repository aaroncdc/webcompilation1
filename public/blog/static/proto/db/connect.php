<?php

    $ERR = false;
    $ERRDESC = "";

    require_once(".parametros.php");
    function raiseError($desc)
    {
        global $ERR;
        global $ERRDESC;
        $ERR = true;
        $ERRDESC = $desc;
    }

    function lowerError()
    {
        global $ERR;
        global $ERRDESC;
        $ERR = false;
        $ERRDESC = "";
    }

    function checkError($msg)
    {
        global $ERR;
        global $ERRDESC;
        if($ERR)
            echo $msg . " " . $ERRDESC;
    }
    
    $con = mysqli_connect(host,user,password,db);
    
    if(!$con)
        raiseError("No se pudo establecer la conexión con la base de datos: " . mysqli_connect_error());
    
    $con->query("SET NAMES utf8mb4;");

?>