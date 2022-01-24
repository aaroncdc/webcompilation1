<?php
	$namefiles = array("jpfemale.txt","jpmale.txt");
	$suffixfiles = array("goth.txt","robot.txt","witch.txt");
	$firsts = array();
	$seconds = array();
	$list = fopen("lists/" . $namefiles[rand(0,count($namefiles)-1)], "r");
	while(($line = fgets($list)))
	{
		array_push($firsts, $line);
	}
	fclose($list);
	$list = fopen("lists/" . $suffixfiles[rand(0,count($suffixfiles)-1)], "r");
	while(($line = fgets($list)))
	{
		array_push($seconds, $line);
	}
	fclose($list);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Codename generator</title>
<style>
body{
	background: #76B3E8;
	font-family: "Arial", sans-serif;
	padding: 20px;
}
</style>
</head>
<body>
<?php
	for($x = 0; $x < 10; $x++)
		echo "<h2>" . $firsts[rand(0,count($firsts)-1)] . " " . $seconds[rand(0,count($seconds)-1)] . "</h2>";
?>
</body>
</html>
<?php
	
?>
