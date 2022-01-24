<?php
    $files = ["Activity", "Flags", "Food", "Nature", "Objects", "People", "Symbols", "Travel"];
    $classes = ["activities", "flags", "foods", "natures", "objects", "peoples", "symbols", "travels"];
    $fwc = array_combine($files, $classes);
    $result_data = [];
    foreach($files as $filename){
        echo "<h1>".$filename."</h1>";
        $f = fopen($filename . ".json", "r");
        $data = json_decode(fread($f, filesize($filename . ".json")), true);
        fclose($f);
        $groupname = "";
        if(substr(strtolower($filename), -1) === "s")
            $groupname = substr(strtolower($filename), 0, strlen($filename)-1);
        else
            $groupname = strtolower($filename);
        echo "<br><br><h3>" . $groupname . "</h3><br><br>";
        $transformed = ["groupname"=>$filename,"data"=>$data[$fwc[$filename]][$groupname]];
        array_push($result_data, $transformed);
        //$result_data = array_merge($result_data, $transformed);
    }
    $jsonlist = json_encode($result_data);
    $out = fopen("emojilist.json", "w");
    fwrite($out, $jsonlist);
    fclose($out);
    echo "<h1>OK</h1>";
?>