<?php
$group = "";
if(isset($_GET["group"]))
    $group = $_GET["group"];
if(!isset($_GET["id"]) && $group != "All")
    die("");
if(isset($_GET["id"]))
    $code = $_GET["id"];
$f = fopen("emojilist.json", "r");
$raw = fread($f, filesize("emojilist.json"));
fclose($f);

$data = json_decode($raw, true);
if($group != "")
{
    if($group == "All")
    {
        /*foreach($data as $gp)
            foreach($gp["data"] as $emoji)
                    echo $emoji["value"];*/
        header('Content-Type: application/json');
        die($raw);
    }else{
        foreach($data as $gp)
            if($gp["groupname"] == $group)
                foreach($gp["data"] as $emoji)
                    if($emoji["key"]==$code)
                        die($emoji["value"]);
    }
}else{
    foreach($data as $gp)
        foreach($gp["data"] as $emoji)
            if($emoji["key"]==$code)
                die($emoji["value"]);
}
?>