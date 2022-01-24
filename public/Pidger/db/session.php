<?php
require_once("connect.php");
require_once("qlib.php");

$sstatus = function_exists("session_status");
$sstarted = false;
$current_session = null;

if($sstatus)
    if (session_status() == PHP_SESSION_NONE)
        session_start();
else
    if(session_id() == '')
        session_start();

function setUserCookie($data)
{
    global $con;
    global $user;
    if(!setcookie(cookiename, $data, time()+2592000))
        return false;

    return true;
}

function checkSession()
{
    global $con;
    global $user;
    global $current_session;
    

    if(!isset($_SESSION[cookiename]) && !isset($_COOKIE[cookiename]))
        return false;

    if(isset($_COOKIE[cookiename]))
        $ssid = $_COOKIE[cookiename];
    else
        $ssid = $_SESSION[cookiename];

    $ssid = substr($ssid, 0, 50);
    $sql = "SELECT * FROM sessions WHERE session_key = '$ssid';";
    $res = mysqli_query($con, $sql);
    $rows = mysqli_num_rows($res);
    if($rows < 1)
        return false;
    else
    {
        $current_session = $ssid;
        $user = mysqli_fetch_assoc($res);
        return $ssid;
    }
        
}

function deleteSession()
{
    global $qlib;
    //echo $_COOKIE[cookiename] . "<br>";
    if(isset($_COOKIE[cookiename]))
    {
        $qlib->endsession($_COOKIE[cookiename]);
        unset($_COOKIE[cookiename]);
        setcookie(cookiename, null, -1);
    }
    if(isset($_SESSION[cookiename]))
    {
        $qlib->endsession($_SESSION[cookiename]);
        unset($_SESSION[cookiename]);
        session_unset();
        session_destroy();
    }
}
?>