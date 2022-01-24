<?php

require_once("connect.php");
require_once("cryptlib.php");

$password = "";
$inp = "";

$cryptl = new CryptLib();

if(isset($_GET["password"]))
{
	$inp = $_GET["password"];
	$password = $cryptl->hidepassword($inp, $HASH);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Password MD5 generator</title>
</head>
<body>
<textarea style="width: 300px; height: 100px;"><?php echo $password; ?></textarea><br>
<form method="GET" action="passgen.php">
<label>Password:</label>
<input type="text" name="password" value="<?php echo $inp; ?>"><input type="submit" value="Go">
</form>
<p><strong>Available cryptos: </strong></p>
<pre><?php print_r(hash_algos()); ?></pre>
</body>
</html>

<?php
	mysqli_close($con);
?>
