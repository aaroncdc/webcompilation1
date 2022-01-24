<?php
	$ipp = 25;
	$pagspp = 2;
	$mi = 0;
	
	if(isset($_GET['mi']))
		$mi = $_GET['mi'];
	
	$prev = $mi - 1;
	$next = $mi + 1;
	
	$dirlist = array_diff(scandir("static/dtest/thumb"), array('..', '.'));
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
	
	<title>Zulaijen New Account</title>
	<link rel="stylesheet" href="css/Zulaijen.css"/>
	<link rel="stylesheet" href="js/maginfic_popup/dist/magnific-popup.css" />
	
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	<script type="text/javascript" src="js/maginfic_popup/dist/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</head>

<body>
<?php include('template/header.php'); ?>
<article style="height: 100%">
<center>

<?php

if($islog)
	die("<h1>You already seem to have an account (๑˃̵ᴗ˂̵)و</h1>");
?>

<h1> ╭( ･ㅂ･)و New Zulaijen Account </h1>
<p>Please fill all the required fields in order to cumpliment your account registration. This registration process is NSA-proof.</p>
<p>Registration is required only for uploading content, and commening other's content. You can keep browsing our site without an account. </p>
<hr/>
<form method="POST" action="act_reg.php">
	<table border="0" class="regtable">
		<tr>
			<td><label>Your Username: </label></td>
			<td><input type="text" class="text" placeholder="Name" name="txtName"/></td>
		</tr>
	</table>
	<table border="0" class="regtable">
		<tr>
			<td><label>Your e-mail Address: </label></td>
			<td><input type="text" class="text" placeholder="name@server.com" name="txtMail"/></td>
		</tr>
	</table>
	<table border="0" class="regtable">
		<tr>
			<td><label>Password: </label></td>
			<td><input type="password" class="text" name="txtPassword"/></td>
		</tr>
	</table>
	<table border="0" class="regtable">
		<tr>
			<td><label>Password verification: </label></td>
			<td><input type="password" class="text" name="txtPassver"/></td>
		</tr>
	</table></center>
	<hr/>
	<p class="small">Yup, this is all the info we need from you! However, there is something <b>you must be aware of.</b></p>
	<p class="small">In order to use this site, <b>we use cookies to help us know who you are</b>. These cookies contain <b>your username/email address you use to log in,
	 and your session information (it's just a long and boring code to identify yourself).</b> Be also aware that we might also <b>record your IP address</b> into our database.
	  We won't give it to anyone else or use it for anything shady, we promise! But we need it for both your safety, and our system's.</p>
	<p class="small">While this may look like something irrelevant, people is getting more and more concerned about their privacy. It is our responsibility to inform you of
	 every bit of data we gather from you, and what do we do with it. In order for you to join our service, we require of your permission to use this information. <b>WE DO NOT OFFER
     ANY OF THIS DATA TO THIRD PARTY COMPANIES OR THREE LETTERS AGENCIES. </b> We only use it to offer you a better service (it's true). So tell us...</p>
	<center>
	<br/><hr/>
	<p class="small"><b>Do you agree on using our cookies, and letting us know who you are by using your IP address?</b></p>
	
	<input type="radio" name="privacy_agree" value="true">Yes! I have no problem with that.</input><br/>
	<input type="radio" name="privacy_agree" value="false" checked>No! I won't let you do that!</input><br/><br/>
<hr/></center>
	<p class="small">By joining our service, <mark><b>we also expect you to behave accordingly to a certain guidelines you should follow</b></mark>. These are simple rules you must follow in order
	 to make of this place a nice place. We don't want to make this any longer and boring, so we'll resume it for you in a few lines:</p>
	 <ol class="rules">
	 	<li>Do not upload inappropiated content that might violate any law or could be considered offensive or threatening to others.</li>
	 	<li>Do not spam content, like uploading the same image multiple times, repeating the same comment, etc.</li>
	 	<li>Do not post any comments that could be offensive or threatening to others, avertisements or that could be considered illegal anywhere.</li>
	 	<li>Do not abuse of our system in any way (exploits, hacks, etc).</li>
	 	<li>Just be nice and act reasonably.</li>
	 </ol>
	<p class="small"></p>
	<center>
	<hr/>
		<p class="small"><b>Do you agree on following these simple rules?</b></p>
		
		<input type="radio" name="rules_agree" value="true">Yes</input><br/>
		<input type="radio" name="rules_agree" value="false" checked>No</input><br/><br/>
	<hr/>
    </center>
	<p class="small"> Wen you are done with the registration form, click on the "Done!" button bellow to join our community.</p>
	<center><input type="submit" value="Done!" class="rbutton" /> <input type="reset" value="Reset" class="rbutton" /></center>
</form>

<?php include('template/footer.php'); ?>

</article>
	
		
		
</body>

</html>
