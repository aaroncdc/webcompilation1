<?php
    if(!isset($_POST["usid"]) ||
    !isset($_POST["target"]) ||
    !isset($_POST["action"]))
        die("Error 0");

    $usid = $_POST["usid"];
    $target = intval($_POST["target"]);
    $action = intval($_POST["action"]);
    if(isset($_POST["data"]))
        $data = json_decode($_POST["data"], true);
    /*var_dump($data);
    die("");*/

    require_once("db/connect.php");
    require_once("db/qlib.php");
    $userid = $qlib->getUserDataFromSession($usid, true);
    if(!$userid)
        die("Error 1");
    if($userid["type"] < 1)
        die("Error 2");

    switch($action)
    {
        case 0:
            if(!isset($data))
                die("Error 3");
            $res = $qlib->banhammer($target, $data["expire"], $data["reason"]);
        break;
        case 1:
            $res = $qlib->unban($target);
        break;
        case 2:
            $res = $qlib->ignoreReport($target);
        break;
        case 3:
            $res = $qlib->deleteReportedMessage($target);
        break;
    }
    if(!isset($res))
    {
        echo "Error ";
    }else{
        echo "Result: " . $res;
    }
    $qlib->closeall();
    mysqli_close($con);
?>