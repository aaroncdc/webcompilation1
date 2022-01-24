<?php
    $supported_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
    $fname = $_FILES['file']['name'];
    $fname_exp = explode(".", $fname);
    $ext = strtolower(end($fname_exp));

    if(!(in_array($_FILES['file']['type'], $supported_types)))
        die("Error: tipo de archivo no soportado: " . in_array($_FILES['file']['type']));

    if(!isset($_POST["usid"]))
        die("Error");

    $usid = $_POST["usid"];
    $name = 'users/avatars/'.rand(9999,999999999).rand(9999,999999999).rand(99,999).".".$ext;
    move_uploaded_file($_FILES['file']['tmp_name'], $name);


    if($ext == "jpg" || $ext == "jpeg")
        $src = imagecreatefromjpeg($name);
    elseif($ext == "png")
        $src = imagecreatefrompng($name);
    elseif($ext == "gif")
    $src = imagecreatefromgif($name);


    $dest = imagecreatetruecolor(256,256);
    //imagecopy($dest,$src,0,0,0,0,256,256);
    $dest = imagescale($src, 256, 256);


    if($ext == "jpg" || $ext == "jpeg")
        imagejpeg($dest, $name);
    elseif($ext == "png")
        imagepng($dest, $name);
    elseif($ext == "gif")
        imagegif($dest, $name);


    imagedestroy($dest);
    imagedestroy($src);
    require_once("db/connect.php");
    require_once("db/qlib.php");

    $old = $qlib->getAvatar($usid);
    $qlib->setUserAvatar($name, $usid);

    if($old != null)
    {
        //die($old);
        unlink($old);
    }
        

    echo $name;

    $qlib->closeall();
    mysqli_close($con);
    
?>