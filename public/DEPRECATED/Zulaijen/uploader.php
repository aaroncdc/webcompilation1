<?php
	if(!isset($_COOKIE['Session']) && !isset($_COOKIE['User']))
		die('<h1>Log in first in order to access this page!</h1>');
	$session = $_COOKIE['Session'];
	$user = $_COOKIE['User'];
?>

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
	
	<title>Zulaijen Uploader</title>
	<link rel="stylesheet" href="css/Zulaijen.css"/>
	<link rel="stylesheet" href="js/maginfic_popup/dist/magnific-popup.css" />
	
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	<script type="text/javascript" src="js/maginfic_popup/dist/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</head>

<body>
<?php include('template/header.php'); ?>

<?php
		echo("User: " . $user . " , Session: " . $session . "<br/>");
		if(!checkSession($session, $user))
		{
			die("Invalid session.");
		}
		echo("OK");
?>

<?php include('template/footer.php'); ?>
</body>
</html>