<?php
    require_once("db/session.php");
    deleteSession();

    echo "Sesión finalizada.<a href=\"index.php\">Volver atras</a>
    <script>window.history.back();</script>";

    mysqli_close($con);
?>