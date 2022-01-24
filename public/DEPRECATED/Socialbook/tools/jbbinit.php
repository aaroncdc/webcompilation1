<?php
	if(file_exists('tools/jbbcode/Parser.php'))
		require_once('tools/jbbcode/Parser.php');
	else
		require_once('jbbcode/Parser.php');
	$parser = new JBBCode\Parser();
	$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
	$builder = new JBBCode\CodeDefinitionBuilder('imgx', '<img class="article" src="{param}"/>');
	$parser->addCodeDefinition($builder->build());