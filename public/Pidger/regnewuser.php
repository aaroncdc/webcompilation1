<?php
    require_once("db/session.php");

    if(checkSession())
    {
        die("Ya estás logeado");
    }

    require_once("db/connect.php");
    require_once("db/qlib.php");

    if(!isset($_POST["vUsuario"]))
        die("Error 1");
    if(!isset($_POST["vPassword"]))
        die("Error 2");
    if(!isset($_POST["vRPassword"]))
        die("Error 3");
    if(!isset($_POST["vNombre"]))
        die("Error 4");
    if(!isset($_POST["vNacimiento"]))
        die("Error 5");
    if(!isset($_POST["vSexo"]))
        die("Error 6");
    if(!isset($_POST["vNacionalidad"]))
        die("Error 7");
    if(!isset($_POST["vCorreo"]))
        die("Error 8");

    $datos = ["nick" => htmlentities($_POST["vUsuario"]),
    "password" => htmlentities($_POST["vPassword"]),
    "rpassword" => htmlentities($_POST["vRPassword"]),
    "name" => htmlentities($_POST["vNombre"]),
    "surname" => (isset($_POST["vApellidos"]))?htmlentities($_POST["vApellidos"]):null,
    "birthdate" => htmlentities($_POST["vNacimiento"]),
    "gender" => htmlentities($_POST["vSexo"]),
    "address" => (isset($_POST["vDireccion"]))?htmlentities($_POST["vDireccion"]):null,
    "nationality" => htmlentities($_POST["vNacionalidad"]),
    "mail" => htmlentities($_POST["vCorreo"]),
    "phone" => (isset($_POST["vTelefono"]))?htmlentities($_POST["vTelefono"]):null,
    "eula" => isset($_POST["vCondiciones"]),
    "cookies" => isset($_POST["vCookies"]),
    "privacy" => isset($_POST["vPrivacidad"]),
    "news" => isset($_POST["vNews"])
    ];
    
    if($datos["password"] != $datos["rpassword"])
        die("Error 9");

    //var_dump($datos);
    echo $qlib->register_new_user($datos);
    if($qlib->is_error)
        echo $qlib->error;
    else
        echo "Se ha registrado con éxito.<a href=\"index.php\">Volver al índice</a>
        <script>
        setTimeout(function(){
            window.location.replace(\"index.php\");
        },5000);</script>";
    //var_dump($qlib->error);
    
?>

<?php
    $qlib->closeall();
    mysqli_close($con);
?>