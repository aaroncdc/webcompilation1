<?php
    require_once("db/session.php");

    if(checkSession())
    {
        die("Ya estás logeado");
    }

    require_once("db/connect.php");
    require_once("db/qlib.php");

    if(!isset($_POST["vCorreo"]))
        die("Error");
    if(!isset($_POST["vPassword"]))
        die("Error");

    $mail = $_POST["vCorreo"];
    $password = $_POST["vPassword"];

    $md1 = md5($password);
    $md2 = md5($HASH);
    $password = md5($md2 . $md1);

    if($res = $qlib->login_data($mail, $password))
    {
        setUserCookie($res);
        //echo $res;
    }
    //$qlib->closeall();
    mysqli_close($con);
    die("Has iniciado sesión con éxito.<a href=\"index.php\">Volver al índice</a>
    <script>
    setTimeout(function(){
        window.location.replace(\"index.php\");
    },5000);</script>");
?>