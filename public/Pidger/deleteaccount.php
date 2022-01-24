<?php
    if(!isset($_POST["option-set-deletion"]) ||
    !isset($_POST["usid"]))
        die("Error");

    require_once("db/connect.php");
    require_once("db/qlib.php");

    $current_user = $qlib->getUserFromSession($_POST["usid"]);
    $res = $qlib->setUserDeletion($current_user["id"]);
    var_dump($res);

    $qlib->closeall();
    mysqli_close($con);
?>