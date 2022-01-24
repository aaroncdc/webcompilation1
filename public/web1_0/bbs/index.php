<?php
// Load the BBS configuration
require('config.php');
// Load the list of boards
require('boards.php');
// Load the list of verified users
require('privileged.php');
// Load the markdown parser library
require('Parsedown.php');

/*
*
* BBS Operations (mode):
*
* LIST 		Lists available boards
* TOPICS 	List available topics on a board
* READ 		List all available posts on a topic
* POST 		Post a new message on the specified topic
*
* Default operation is LIST
*
*/
$mode = "LIST";

if(isset($_GET['mode']))
{
	$mode = $_GET['mode'];
}

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

function randomName()
{
	$chars = "01234ABCDEFGHIJKLMNOPQRSTUVWXYZ56789-_.:,;{}/[]?!=%$#@+-*/abcdefghijklmnopqrstuvwxyz";
	$name = "";
	for($x = 0; $x < 32; $x++)
	{
		 $name .= $chars[rand(0,strlen($chars)-1)];
	}

	return $name;
}

function postReply($topic = null)
{
	global $root;
	global $admin;
	global $_POST;
	global $_GET;
	global $folder_chmod;
	global $post_dateformat;
	global $minimum_message_characters;

	$board = $_POST['board'];
	$path = getPath($_POST['board']);
	$replying = ($topic !== null);

	echo "<b>New thread</b>";
	// New topic
	if(isset($_POST['name']) === false || (isset($_POST['board-topic']) === false && $replying === false) ||
		isset($_POST['message']) === false)
	{
		echo("<h1>Malformed POST request (postReply - check). Discarded.</h1><br>");
	}else{

		if($replying === false)
		{
			$topic = $_POST['board-topic'];
		}

		if(strlen($topic) == 0 ||
			strlen($_POST['message']) < (($minimum_message_characters>0)?$minimum_message_characters:1) )
		{
			echo("<h1>Malformed POST request (postReply - chkTopicAndMessage). Discarded.</h1>");
		}else{
			$name = cryptName(strlen($_POST['name']) == 0 ? randomName() : $_POST['name']);
			
			if($name === $admin)
			{
				$name = "<font color=\"#9132f0\"><b>!!$name</b></font>";
			}
			else if(in_array($name, $privileged) === true)
			{
				$name = "<font color=\"#2f64eb\"><b>!$name</b></font>";
			}

			if($replying === false)
			{
				$topic = filterTopic($topic);	
			}
			
			$message = filterContent($_POST['message']);
			$dpath = $path . "/" . $topic;

			$fpath = "";

			if($replying === false)
			{
				$fpath = $dpath . "/" . "main.md";
			}else{
				$fname = date('YmdHis') . ".md";
				$fpath = $dpath . "/" . $fname; 
			}

			if((is_dir($dpath) === false && is_file($dpath) === false) ||
				($replying === true && is_dir($dpath) === true))
			{
				if($replying === false)
				{
					mkdir($dpath);
					chmod($dpath, $folder_chmod);
				}
				$f = fopen($fpath, "w");
				if($f !== false)
				{
					$datetime = date($post_dateformat);
					$fullmsg = "<p><b>From: </b>$name</p>\n";
					$fullmsg .= "<p><b>To: </b>$board</p>\n";
					$fullmsg .= "<p><b>Topic:</b>$topic</p>\n";
					$fullmsg .= "<p><b>Date: </b>$datetime</p>\n";
					$fullmsg .= "<hr>\n";
					$fullmsg .= $message;


					if(fwrite($f, $fullmsg) === false)
					{
						fclose($f);
						echo "<h2>Error creating new thread: I/O error</h2>";
					}
					fclose($f);
					echo "<h2>Thread $fpath created on $dpath</h2><br><a href=\"index.php?mode=READ&board=$board&topic=$topic\">Go to the thread</a>";
				}else{
					echo "<h2>Error creating new thread: Error opening the topic</h2>";
				}
			}else{
				echo "<h2>Error creating new thread: Board $dpath does not exist</h2>";
			}						
		}
	}
}

function filterPath($path)
{
	do
	{
		if(substr($path, 0, 2) == "..")
		{
			$path = substr($path, 2, strlen($path)-1);
		}
		if($path[0] == '/')
		{
			$path = substr($path, 1, strlen($path)-1);
		}
	}while(substr($path, 0, 2) == ".." || $path[0] == '/');

	return $path;
}

function getPath($board)
{
	global $root;

	list($domain, $directory, $subdirectory) = explode('.', $board,3);

	if(is_null($subdirectory) === true)
	{
		return filterPath($root . $domain . "/" . $directory);
	}else{
		return filterPath($root . $domain . "/" . $directory . "/" . $subdirectory);
	}
}

function getTopics($path)
{
	$cnt = 0;
	$d = scandir($path, SCANDIR_SORT_ASCENDING);
	if($d === false)
	{
		return -1;
	}

	foreach($d as $topic)
	{
		$tpath = $path . "/" . $topic;
		if(is_dir($tpath) === true && $topic !== "." && $topic !== "..")
		{
			// Ignore folders with no main.md file (Not topics, probably sub-boards)
			if(is_file($tpath . "/main.md") === true)
			{
				$cnt++;
			}
		}
	}

	return $cnt;
}

	function getReplies($path)
	{
		$d = scandir($path, SCANDIR_SORT_ASCENDING);
		$replies = 0;

		if($d === false)
		{
			return -1;
		}

		foreach($d as $file)
		{
			if(is_file($path . "/" . $file) === true && $file !== "." && $file !== ".." && str_ends_with($file, ".md"))
			{
				$replies++;
			}
		}
		return $replies;
	}

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

function filterTopic($name)
{
	$prg = '/[^a-zA-Z0-9!?\\-_]/i';
	$filtered1 = htmlentities(preg_replace($prg, "_", str_replace("..", "", $name)));
	$filtered2 = (strlen($filtered1) > 252) ? substr($filtered1, 0, 252) : $filtered1;
	return trim($filtered2,  " \t\r\n");
}

function filterContent($content)
{
global $char_limit;
/*

This huge regex here detects any HTML link tag containing an URL not redirecting to a .onion site. It
captures 3 groups:

Group 0: Full tag (i.e: "<a href="https://www.duckdugkgo.com">One clearnet link</a>")
Group 1: The value of the href attribute (i.e: "https://www.duckdugkgo.com")
Group 2: The text of the tag (i.e: "One clearnet link")

<a\s.*href=["'](?!(?:[http|https|file|gopher|mailto|torrent|magnet|tel|whatsapp|discord|irc|xmpp]+:[\\\\|\/\/]+)?(?:[w\.]+)?(?:[\w\d\-_@]+)?\.(?:onion[\w\d"\/&\?]+?))((?:[http|https|file|gopher|mailto|torrent|magnet|tel|whatsapp|discord|irc|xmpp]+:[\\\\|\/\/]+)?(?:[w\.]+)?(?:[\w\d\-_@]+)?\.[\w\d&\?\-_\\\/=\[\]\{\}\(\)]+)"(?:[\w\d\s\r\n\t="\-_\(\)\[\]\{\}$%&\!\?\.,;'<>]+)?>([\w\d\s\r\n\t="\-_\(\)\[\]\{\}$%&\!\?\.,;'<>]+)<\/a>

This is NOT parsing HTML. This is searching for any link tag in the post, disregarding their hierachy. Besides, adding another library would be to add yet another weak point.

*/

$preg = '/<a\\s.*href=["\'](?!(?:[http|https|file|gopher|mailto|torrent|magnet|tel|whatsapp|discord|irc|xmpp]+:[\\\\\\\\|\\/\\/]+)?(?:[w\\d\\.\\-]+)?(?:[\\w\\d\\-_@]+)?\.(?:onion[\\w\\d"\\/&\\?\\.]+?))((?:[http|https|file|gopher|mailto|torrent|magnet|tel|whatsapp|discord|irc|xmpp]+:[\\\\\\\\|\\/\\/]+)?(?:[w\\d\\.\\-]+)?(?:[\\w\\d\\-_@]+)?\\.[\\w\\d&\\?\\-_\\\\\\/=\\[\\]\\{\\}\\(\\)\\.]+)"(?:[\\w\\d\\s\\r\\n\\t="\\-_\\(\\)\\[\\]\\{\\}$%&\\!\\?\\.,;\'<>]+)?>([\\w\\d\\s\\r\\n\\t="\\-_\\(\\)\\[\\]\\{\\}$%&\\!\\?\\.,;\'<>]+)<\/a>/i';

	$content = (strlen($content) > $char_limit) ? substr($content, 0, $char_limit) : $content;
	$Parsedown = new Parsedown();
	$Parsedown->setSafeMode(true);
	// This also calls to htmlentities
	$mdtext = nl2br($Parsedown->text($content));

	$matches = [];
	
	preg_match_all($preg, $mdtext, $matches);

	$matchcount = count($matches[0]);

	for($x = 0; $x < $matchcount; $x++)
	{
		$link_rep = str_replace($matches[2][$x], "<sup>(CLEARNET)</sup> " . $matches[2][$x], $matches[0][$x]);
		$mdtext = str_replace($matches[0][$x], $link_rep, $mdtext);
	}

	return trim(preg_replace($preg, "", $mdtext),  " \t\r\n");
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $bbs_title; ?></title>
	<link rel="stylesheet" href=<?php echo "\"$bbs_css\""; ?>>
</head>
<body>
<h1><?php echo $bbs_title; ?></h1><br>
<a href="index.php">[Main Index]</a>
<?php

if($enable_motd === true)
{
	$f = fopen($motd_file, "r");
	if($f !== false)
	{
		$motd = fread($f, filesize($motd_file));
		fclose($f);
		$Parsedown = new Parsedown();
		$Parsedown->setSafeMode(true);

		// This also calls to htmlentities
		echo nl2br($Parsedown->text($motd));
	}else{
		echo "Unable to open $motd_file. Please create $motd_file or set \$enable_motd to false in your config file.<br>";
	}
}

?>

</p>
<hr>
<?php
switch($mode)
{
	case "LIST":
	default:
	?>
		<table class="entry-list">
			<tr>
				<th>Board</th>
				<th>Description</th>
				<th>Topics</th>
			</tr>
		
	<?php
		foreach($boards as $board => $description)
		{
			$path = getPath($board);
			$ntopics = getTopics($path);

			echo "<tr>";
			echo "<td>";
			if($ntopics > -1)
			{
				echo "<a href=\"index.php?mode=TOPICS&board=$board\">$board</a>";
			}else{
				echo "<font color=\"#ff0000\">$board</font>";
			}
			echo "</td><td>";
			echo $description;
			echo "</td>";
			echo "<td>";
			echo ($ntopics>-1)?$ntopics:"Directory must be created";
			echo "</td>";
		}
	?>
	</table>
	<?php
		break;
	case "TOPICS":
		if(isset($_GET['board']) == false)
		{
			echo "<b>Please specify a board to browse</b>";
		}else{
			$board = $_GET["board"];

			echo "<h1>$board</h1>";

			$path = getPath($board);
			if(is_dir($path) === false)
			{
				echo "<b>The board '$board' does not exist in this BBS</b>";
				break;
			}


			?>
					<center>
						<h2>Start a new topic</h2>
			<table style="width:500px">
				<form method="POST" action="index.php?mode=POST">
				<tr>
					<td>
						Name (Optional, will be hashed with Crypt()):
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="name" placeholder="Anonymous" style="width:100%">
					</td>
				</tr>
								<tr>
					<td>
						Topic (required):
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="board-topic" style="width:100%">
					</td>
				</tr>
				<tr>
					<td>
						Message (Will be limited to <?php echo $char_limit; ?> characters):
					</td>
				</tr>
				<tr>
					<td>
						<textarea name="message" style="width:100%;height:150px;"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="board" value="<?php echo $board; ?>">
						<input type="submit" value="Post">
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
			</form>
			</table>
		</center>

				<table class="entry-list">
					<h2>TOPICS</h2>
					<tr>
						<th>Topic</th>
						<th>Replies</th>
					</tr>
			<?php
			$d = scandir($path);
			foreach($d as $topic)
			{
				if(is_dir($path) === true && $topic !== "." && $topic !== "..")
				{
					$tpath = $path . "/" . $topic;
					$replies = getReplies($tpath);
					$topicname = str_replace(".md", "", $topic);
					$topicdisplayname = str_replace("_", " ", $topicname);

					// Ignore folders with no main.md file (Not topics, probably sub-boards)
					if(is_file($tpath . "/main.md") === true)
					{
						echo "<tr>";
						echo "<td><a href=\"index.php?mode=READ&board=$board&topic=$topicname\">$topicdisplayname</a></td>";
						echo "<td>$replies</td>";
						echo "</tr>";
					}
				}
			}
			echo "</table>";
		}
		break;
	case "READ":
		$board = $_GET["board"];
		$topic = $_GET['topic'];
		?>
		<h2>Topic: <?php echo str_replace('_', ' ', $topic); ?></h2><br>
		<a href=<?php echo "\"index.php?mode=TOPICS&board=$board\""; ?>>[Back to <?php echo $board; ?>]</a><br><br>
		<center>
			<table style="width:500px">
				<form method="POST" action="index.php?mode=POST">
				<tr>
					<td>
						Name (Optional, will be hashed with Crypt()):
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="name" placeholder="Anonymous" style="width:100%">
					</td>
				</tr>
				<tr>
					<td>
						Message (Will be limited to <?php echo $char_limit; ?> characters):
					</td>
				</tr>
				<tr>
					<td>
						<textarea name="message" style="width:100%;height:150px;"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<input type="hidden" name="board" value="<?php echo $board; ?>">
						<input type="hidden" name="topic" value="<?php echo $topic; ?>">
						<input type="submit" value="Post">
					</td>
				</tr>
				<tr>
					<td>
						
					</td>
				</tr>
			</form>
			</table>
		</center>
		<?php

		if(isset($_GET['board']) == false)
		{
			echo "<b>Please specify a board to browse</b>";
		}else{
			//$board = $_GET['board'];
			$path = getPath($_GET['board']);
			//$topic = $_GET['topic'];

			if($topic == "")
			{
				echo "<b>NO</b>";
			}else{
				if(is_dir($path) === false)
				{
					echo "<b>The board '$board' does not exist in this BBS</b>";
				}else{
					$fpath = $path . "/" . filterTopic(filterPath($topic));
					if(is_dir($fpath) === false)
					{
						echo "<b>Topic '$topic' does not exist in '$board'</b>";
					}
					else if(is_file($fpath . "/main.md") === false)
					{
						echo "<b>Topic '$topic' does not contain an entry post</b>";	
					}
					else{
						$posts = scandir($fpath);
						sort($posts);
						if(count($posts) < 3)
						{
							echo "<b>Topic '$topic' is empty</b>";
						}else{
							$f = fopen($fpath . "/main.md", "r");
							if($f !== false)
							{
								$content = fread($f, filesize($fpath . "/main.md"));
								fclose($f);
								echo $content . "<br><br> -- EOF -- <hr><br>";
							}else{
								echo "<b>Error opening main entry post</b>";
							}

							for($x = 0; $x < count($posts); $x++)
							{
								if($posts[$x] !== "." && $posts[$x] !== ".." && $posts[$x] !== "main.md")
								{
									$f = fopen($fpath . "/" . $posts[$x], "r");
									if($f !== false)
									{
										$content = fread($f, filesize($fpath . "/" . $posts[$x]));
										fclose($f);
										echo $content . "<br><br> -- EOF -- <hr><br>";
									}else{
										echo "$f omitted because it could not be open<hr><br>";
									}
								}
							}
						}
					}
				}				
			}



		}
		break;
	case "POST":
		if(isset($_POST['board']) === true)
		{
			if(isset($_POST['topic']) === true)
			{
				postReply($_POST['topic']);
			}else{
				postReply();
			}
		}else{
			echo("<h1>Malformed POST request (POST). Discarded.</h1>");
		}
		break;
}
?>

</body>
</html>