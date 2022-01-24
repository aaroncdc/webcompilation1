<?php
	require_once('tools/jbbinit.php');
	$input = $_POST['txtentrada'];
 
	//htmlentities();
 
	$parser->parse($input);
 
	echo($parser->getAsHtml());
	echo("<hr/>" . $parser->getAsBBCode());
	//echo $input;