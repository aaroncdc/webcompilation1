<?php
    require_once("db/connect.php");
    require_once("db/qlib.php");

    if(!isset($_POST["userinput"]) || !isset($_POST["sid"]))
        die("E1");

    if(isset($_POST["filelist"]))
    {
        $filelist = json_decode($_POST["filelist"], false);
        $stringfilelist = "";
        foreach($filelist as $fileid)
            $stringfilelist .= $fileid . ",";
        $stringfilelist = substr($stringfilelist, 0, strlen($stringfilelist)-1);
    }

    if(isset($_POST["replyto"]))
        $replyto = intval($_POST["replyto"]);
    
    $userinput = htmlentities($_POST["userinput"]);
    $sid = $_POST["sid"];

    /*var_dump($userinput);
    var_dump($sid);
    die("");*/

    $userdata = $qlib->getUserFromSession($sid);
    if($qlib->is_error)
    {
        header('Content-Type: application/json');
        die(json_encode($qlib->error));
    }
    if(!$userdata)
        die("Error");

    $mpost = $qlib->postMessage($sid, $userinput, (isset($stringfilelist))?$stringfilelist:null, (isset($replyto))?$replyto:null);

    //var_dump($userdata);
    preg_match_all('/#([^,.:=()\/&%$·#"@|ªº\\\'^`\[\]*+¨´{}Ç<>\s]{3,20})/', $userinput, $matches, PREG_OFFSET_CAPTURE);
    //var_dump($matches);
    $used = [];
    foreach($matches[1] as $match)
    {
        $isused = false;
        foreach($used as $wtag)
            if($wtag == $match[0])
            {
                $isused = true;
                break;
            }

        if(!$isused)
        {
            $qlib->registerTag($match[0], $mpost[1]);
            array_push($used, $match[0]);
        }
    }
    //die("");
    if($qlib->is_error)
    {
        die(json_encode($qlib->error));
    }
    //die("SAFS");
    $qlib->closeall();
    mysqli_close($con);
    die($mpost[0]);
?>