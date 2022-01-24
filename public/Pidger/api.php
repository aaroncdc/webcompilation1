<?php
    if(isset($_GET["mode"]))
        $mode=$_GET["mode"];

    require("db/connect.php");
    require("db/qlib.php");

    if(isset($mode))
    {
        $start = (isset($_GET["start"]))?$_GET["start"]:0;
        $count = (isset($_GET["count"]))?$_GET["count"]:0;
        $is_logged_in = (isset($_GET["sid"]))?$_GET["sid"]:null;
        switch($mode){
            case 0:
                echo $qlib->getUserTimeline($start, $count, $is_logged_in, true, null, true);
            break;
            case 1:
                echo $qlib->getUserTimeline($start, $count, $is_logged_in);
            break;
            case 2:
                echo $qlib->genericTimeline($start, $count, $is_logged_in);
            break;
            case 3:
                echo $qlib->genericTimeline($start, $count);
            break;
        }
    }

    $qlib->closeall();
    mysqli_close($con);
?>