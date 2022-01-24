<?php
    require_once("db/connect.php");
    require_once("db/qlib.php");

    if(!isset($_POST["mesid"]) || !isset($_POST["sid"]))
        die("E1");

    $mesid = $_POST["mesid"];
    $sid = $_POST["sid"];

    $userdata = $qlib->getUserFromSession($sid);
    if($qlib->is_error)
    {
        header('Content-Type: application/json');
        die(json_encode($qlib->error));
    }

    $qlib->repost($userdata["id"], $mesid);

    echo "OK";

    $qlib->closeall();
    mysqli_close($con);
?>