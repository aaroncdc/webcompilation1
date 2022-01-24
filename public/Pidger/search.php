<?php
    if(!isset($_POST["usid"]) ||
    !isset($_POST["search"]))
        die("Error");

    $usid = $_POST["usid"];
    $search = htmlentities($_POST["search"]);

    require_once("db/connect.php");
    require_once("db/qlib.php");
    $userid = $qlib->getUserDataFromSession($usid, true);
    if(!$userid)
    {
        //echo "Sesión no valida";
    }else{
        $result = $qlib->searchUser($search);
        foreach($result as $user)
            echo $user;
        //echo $result;
    }


    $qlib->closeall();
    mysqli_close($con);
?>