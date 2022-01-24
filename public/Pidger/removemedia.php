<?php
        if(!isset($_POST["meid"]))
            die("Error 1");

        require_once("db/connect.php");
        require_once("db/qlib.php");

        $meid = $_POST["meid"];

        $media = $qlib->getMedia($meid);
        unlink($media["url"]);
        $qlib->removeMedia($meid);

        $qlib->closeall();
        mysqli_close($con);
?>