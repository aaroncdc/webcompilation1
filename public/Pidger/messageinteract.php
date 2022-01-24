<?php
    require_once("db/connect.php");
    require_once("db/qlib.php");
    if(!isset($_POST["mesid"]) || !isset($_POST["mode"]) || !isset($_POST["data"]))
        die("E1");
    
    $mesid = $_POST["mesid"];
    $mode = $_POST["mode"];
    $data = $_POST["data"];

    //die($data);

    switch($mode)
    {
        case 0:
            $jsondata = json_decode($data, true);
            if(!$qlib->likeMessage($jsondata["sesid"], $mesid))
                if($qlib->is_error)
                    die($qlib->error["description"]);
            die("OK");
        break;
        case 10:
            $jsondata = json_decode($data, true);
            $userdata = $qlib->getUserDataFromSession($jsondata["sid"], true);
            if(!$qlib->report($mesid, $userdata["id"], $mesid))
                if($qlib->is_error)
                    die($qlib->error["description"]);
        die("OK");
        break;
        default:
            die("E2");
    }

?>