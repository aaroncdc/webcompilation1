<?php
    require_once("db/session.php");
    if(isset($_POST["vCode"]))
    {
        if($_POST["vCode"] == $promo_code)
        {
            setcookie($demo_cookie, $promo_code, time()+2592000);
            $pass = "OK";
        }
            
    }
    $is_logged_in = checkSession();
    $current_user = null;
    if($is_logged_in)
    {
        require_once("db/qlib.php");
        $current_user = $qlib->getUserFromSession($current_session);
        $user_privacy = $qlib->getUserPrivacyOptions($current_user["id"]);
    }
?>
<!DOCTYPE html>
<html>
<?php
    if(isset($_COOKIE[$demo_cookie]) || isset($pass))
    {
        if($current_user["banned"]<1)
        {
            require_once("headerdata.php");
            echo '<script src="js/is.js"></script>';
            require_once("commonbody.php");
        }else{
            echo "<h1>Has sido baneado del servicio.</h1>";
            echo "<p><strong>Razón:</strong>".$current_user["reason"]."</p>";
            echo "<p><strong>Hasta:</strong>".$current_user["expire"]."</p>";
        }

    }else{
?>
    <h1>Ingrese su código para la demo</h1>
    <p>Se requiere de un código privado para tener acceder a la demo de PIDGER.</p>
    <form method="POST" action="index.php">
    <input type="text" placeholder="demo" name="vCode"><input type="submit" value="Acceder">
    <p>Al ingresar su código, acepta las <a href="legal/cookies.html" target="_blank">políticas de cookies</a> del sitio. Es necesario tener las cookies activadas.</p>
    </form>
<?php } ?>
</html>