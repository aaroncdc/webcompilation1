<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
$root = "content";
$p = 0;
$ppp = 20;

if(function_exists("str_starts_with")===false)
{
	function str_starts_with( $haystack, $needle ) {
	     $length = strlen( $needle );
	     return substr( $haystack, 0, $length ) === $needle;
	}
}

if(function_exists("str_ends_with")===false)
{
	function str_ends_with( $haystack, $needle ) {
	    $length = strlen( $needle );
	    if( !$length ) {
	        return true;
	    }
	    return substr( $haystack, -$length ) === $needle;
	}
}

if(isset($_GET['p']))
{
	$p = intval($_GET['p']);
}

$d = scandir($root, SCANDIR_SORT_DESCENDING);
$dirs = count($d);

//echo "Dirs: " . $dirs . '<br>';

if(is_array($d))
{
	if($dirs > $p * $ppp)
	{
		$d = array_slice($d, $p * $ppp, $ppp);
	}	
}
//echo "Dirs: " . count($d) . '<br>';

if($d === false)
{
	die('There is no content.');
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>BLOG</title>
	<link rel="stylesheet" href="blog.css">
</head>
<body>
<?php
if(isset($_GET['e']))
{
	// Limit this parameter to a maximum of 255 characters
	$fullurl = (strlen($_GET['e']) > 255) ? substr($_GET['e'], 0, 255) : $_GET['e'];
	// Regex to avoid arbitrary code executions and accessing arbitrary files
	$prg = '/(\.)\1|^(\\\)\2|^\b\w+(?<!content)\b|(^\/)?|(^\\\)?|(\?)?|(\$)?|(~)?|\b\w+(?<!\.md)$/';
	// Sanitize the parameter
	$file = preg_replace($prg, "", str_replace("..", "", $fullurl));
	$f = fopen($file, "r");
	if($f === false)
	{
		if(str_starts_with($fullurl, "/") === true)
		{
			echo '<h1>420 - STONED</h1>';
			echo '<p>That\'s like, the very first thing I\'ve tried when pen-testing my server. Nice try though. But it won\'t work. The URL parameters are well handled. I already expected such weak attacks. Try harder, idiot.</p>';
		}else{
			echo '<h1>404 - NOT FOUND</h1>';
			echo '<small>Actually, this isn\'t an HTTP 404</small><hr>';
			echo '<p> If you clicked on something, my bad. Seems like whatever you clicked is either down, doesn\'t exist, or it\'s not working.</p>';
			echo '<p>If you are a fed or a "jest" trying to pwn me, stop trying. It\'s not worth your time.</p>';
		}
	}else{
		require('Parsedown.php');
		$Parsedown = new Parsedown();
		$Parsedown->setSafeMode(true);

		$content = fread($f, filesize($file));

		if($content === false)
		{
			echo 'Could not read the specified entry<br>';
		}else{
			echo '<br><br> <a href="./index.php">=- Back to the index -=</a><br><br>';
			echo $Parsedown->text($content);
		}
		fclose($f);

		echo '<br><br> <a href="./index.php">=- Back to the index -=</a><br><br>';
	}
}else{
?>

<h1>Enigmatico's Blog</h1>

<?php
$pages = ceil($dirs/$ppp);

echo '<a href="index.php?p=0">First</a> | ';

for($x = 0; $x < $pages; $x++)
{
	echo "<a href=\"index.php?p=$x\">$x</a> | ";
}

echo '<a href="index.php?p=' . ceil($dirs/$ppp) . '">Last</a>';
?>

<br><br><table class="entry-list">
	<tr>
		<th>Post title</th>
		<th>Post date</th>
	</tr>
<?php
foreach($d as $entry)
{
	//echo "Entry: " . $entry;
	if($entry !== ".." && $entry !== ".")
	{
		$posts = scandir($root . "/" . $entry);
		foreach($posts as $post)
		{
			//echo "Post: " . $post . '<br>';
			if(($post !== ".." && $post !== ".") && str_ends_with($post, ".md"))
			{
				echo "<tr>";
				echo "<td>";
				echo "<a href=\"index.php?e=" . $root . "/" . $entry . "/" . $post . "\">" . str_replace("_", " ", str_replace(".md", "", $post)) . "</a>";
				echo "</td>";
				echo "<td>";
				echo str_replace("-","/",$entry);
				echo "</td>";
				echo "</tr>";
			}
		}
	}
}
?>

</table><br><br>

<?php
}

$pages = ceil($dirs/$ppp);

echo '<a href="index.php?p=0">First</a> | ';

for($x = 0; $x < $pages; $x++)
{
	echo "<a href=\"index.php?p=$x\">$x</a> | ";
}

echo '<a href="index.php?p=' . ceil($dirs/$ppp) . '">Last</a>';

?>

<br><br><a href="/">=- Go back to the MAIN PAGE -=</a>

<br><br>
</body>
</html>