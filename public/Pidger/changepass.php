<?php
    if(!isset($_POST["cpass"]) ||
    !isset($_POST["npass1"]) ||
    !isset($_POST["npass2"]) ||
    !isset($_POST["usid"]))
        die("Error <script>
        setTimeout(function(){
            window.location.replace(\"usersettings.php\");
        },3000);</script>");

    if($_POST["npass1"] != $_POST["npass2"])
        die("Error: Las contraseñas no coinciden. <script>
        setTimeout(function(){
            window.location.replace(\"usersettings.php\");
        },3000);</script>");

    if(strlen($_POST["npass1"]) < 4)
        die("Contraseña invalida. Debe contener al menos 4 caracteres. <script>
        setTimeout(function(){
            window.location.replace(\"usersettings.php\");
        },3000);</script>");

    require_once("db/connect.php");
    require_once("db/qlib.php");

    $md1 = md5($_POST["npass1"]);
    $md2 = md5($HASH);
    $md3 = md5($_POST["cpass"]);
    $password = md5($md2 . $md1);
    $old = md5($md2. $md3);

    $id = $qlib->getUserFromSession($_POST["usid"]);

    if($id["password"] != $old)
        die("Contraseña invalida. Introduzca la contraseña actual correcta. <script>
        setTimeout(function(){
            window.location.replace(\"usersettings.php\");
        },3000);</script>");

    $res = $qlib->updatePassword($id["id"], $password);

    if($res)
        echo "Contraseña cambiada con éxito";
    else
        echo "No se ha cambiado la contraseña.";

    $qlib->closeall();
    mysqli_close($con);

    echo("<script>
    setTimeout(function(){
        window.location.replace(\"usersettings.php\");
    },3000);</script>");
?>