<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#999966" />
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#999966" />
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#999966" />
	
	<title>Zulaijen New Account</title>
	<link rel="stylesheet" href="css/Zulaijen.css"/>
	<link rel="stylesheet" href="js/maginfic_popup/dist/magnific-popup.css" />
	
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	<script type="text/javascript" src="js/maginfic_popup/dist/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</head>

<body>
<?php include('template/header.php'); ?>

<?php 


	$ip = "0.0.0.0";
	$proxy = "0.0.0.0";
	
	if(isset($_SERVER['REMOTE_ADDR']))
		$ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];

if(!(isset($_POST['txtName']) && isset($_POST['txtMail']) && isset($_POST['txtPassword']) && isset($_POST['txtPassver']) && 
	isset($_POST['privacy_agree']) && isset($_POST['rules_agree'])))
	die ("<h1>(๑´╹‸╹`๑) Bad Request </h1><hr/><p>Were you trying to access this page directly from your browser? Nice try.</p>");

$usname = $_POST['txtName'];
$usmail = $_POST['txtMail'];
$uspass = md5($_POST['txtPassword'], false);
unset($_POST['txtPassword']);

$mysqlman->sqlquery("SELECT * FROM "  . constant('tab_prefix') . "users WHERE NAME = '$usname' OR MAIL = '$usmail'");
if($mysqlman->numrows() > 0)
	die ("<h1>(๑´╹‸╹`๑) Already registered! </h1><hr/><p>That user seems to be in our database.</p>");

$mysqlman->sqlquery("INSERT INTO " . constant('tab_prefix') . "users (NAME,PASSWORD,MAIL,DATE,LAST,SESSION,CSS,SAFE,UPLOADS,BAN,BANCOUNT,ISADMIN,ISMOD,IP,PROXY) VALUES ('$usname','$uspass','$usmail', NOW(), NOW(), '0', 'Zulaijen', 2, 0, 0, 0, 0, 0, '$ip', '$proxy')");

if($mysqlman->numaffected()>0)
	die ("<h1>(ﾉ^ヮ^)ﾉ*:・ﾟ✧ Welcome! </h1><hr/><p>You are now part of our community.</p>");
else{
	echo ("<h1>(๑´╹‸╹`๑) Registration failed! </h1><hr/><p>We failed to register you into our database.</p>");
	die($mysqlman->sqlerror());
}

?>
</body>

<?php include('template/footer.php'); ?>
</html>
