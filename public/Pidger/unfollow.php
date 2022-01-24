<?php

    if(!isset($_POST["sid"]) || !isset($_POST["usid"]))
        die("Error");

    $sid = $_POST["sid"];
    $usid = $_POST["usid"];

    require("db/connect.php");
    require("db/qlib.php");

    $userid = $qlib->getUserDataFromSession($sid, true)["id"];
    if($qlib->unfollow($userid, $usid))
        die("OK");
    else
        die("ERROR1");

    $qlib->closeall();
    mysqli_close($con);
?>