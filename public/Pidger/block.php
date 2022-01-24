<?php

    if(!isset($_POST["sid"]) || !isset($_POST["usid"]))
        die("Error");

    $sid = $_POST["sid"];
    $usid = $_POST["usid"];

    require("db/connect.php");
    require("db/qlib.php");

    $userid = $qlib->getUserDataFromSession($sid, true)["id"];
    if($qlib->block($userid, $usid))
        die("OK");
    else
        die($qlib->error["description"]);

    $qlib->closeall();
    mysqli_close($con);
?>