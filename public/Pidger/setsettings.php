<?php
    if(!isset($_POST["table"]) ||
    !isset($_POST["field"]) ||
    !isset($_POST["value"]) ||
    !isset($_POST["usid"]))
        die("Error");

    require_once("db/connect.php");
    require_once("db/qlib.php");

    $table = htmlentities($_POST["table"]);
    $field = htmlentities($_POST["field"]);
    $value = htmlentities($_POST["value"]);
    $usid = htmlentities($_POST["usid"]);

    if($field=="active" || $field=="banned" || $field=="expire" || $field=="reason" || $field=="deleted" || $field=="type")
        die("No vuelvas a intentar hacer eso.");

    $qlib->setTabledataField($table, $field, $value, $usid);

    if($qlib->is_error)
        var_dump($qlib->error);

    $qlib->closeall();
    mysqli_close($con);
    die($value);
?>