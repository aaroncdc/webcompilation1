<?php
// Load the BBS configuration
require('config.php');
// Load the list of boards
require('boards.php');
// Load the list of verified users
require('privileged.php');
// Load the markdown parser library
require('Parsedown.php');

	function cryptName($name)
	{
		global $salt;
		global $cryptalgo;
		global $max_name_length;
		global $crypt_sha_rounds;

		$prg = '/[\\$\\.\'"]/i';
		$hashprg = '/\\$5\\$rounds=[0-9]+\\$[[:ascii:]]+\\$(.*)/i';
		$filtered = preg_replace($prg, "",(strlen($name) > $max_name_length) ? substr($name, 0, $max_name_length) : $name);
		$matches = [];

		preg_match($hashprg, trim(crypt($name, '$5$rounds=' . $crypt_sha_rounds . '$' . ($filtered . $salt) . '$'),  " \t\r\n"), $matches);
		$hash1 = $matches[1];
		preg_match($hashprg, trim(crypt(strrev($name), '$5$rounds='.$crypt_sha_rounds.'$' . ($filtered . $salt) . '$'),  " \t\r\n"), $matches);
		$hash2 = $matches[1];

		$final = "";

		for($x = 0; $x < strlen($hash1) && $x < strlen($hash2); $x++)
		{
			$final .= $hash1[$x] . $hash2[$x];
		}

		return preg_replace('/[^\w\d]/i','',$final);
	}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Namegen</title>
        <meta charset="utf-8">
    </head>
    <body>
    <?php
        if(isset($_GET['name']))
        {
            $name = cryptName(strlen($_GET['name']) == 0 ? randomName() : $_GET['name']);
            echo "<pre>" . $name . "</pre>";
        }
    ?>
    </body>
</html>
