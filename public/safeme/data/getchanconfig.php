<?php
	$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "config");
	$config_array = $mysqlman->sqlfetchassoc();
	$channame = $config_array['name'];
	$chandescription = $config_array['description'];
	$channews = $config_array['news'];
	$chandefstyle = $config_array['default_style'];
?>