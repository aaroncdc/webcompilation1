<?php
require_once('jbbcode/Parser.php');
$parser = new JBBCode\Parser();
$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());

	$file = fopen("testfile", "r");
	$content = "";
	if($file)
	{
		while(($line = fgets($file)) != false)
		{
			$content .= $line;
		}
		fclose($file);
		$parser->parse($content);
		echo $parser->getAsHtml();
	}else{
		die("Whoops!");
	}
?>
