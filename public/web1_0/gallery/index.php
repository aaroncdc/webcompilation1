<?php

/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

if (!extension_loaded('imagick')){
    die('<h2>imagick not installed</h2><br>');
}
	$gallery = "";
	$page = 0;
	$files_per_page = 35;
	$files_per_row = 7;

	$thumbnail_width = 128;
	$thumbnail_height = 128;

	$gallery_dir_root = "galleries";
	$thumb_dir_root = "thumbs";

	$allowed_files = [
		"jpg",
		"jpeg",
		"png",
		"gif",
		"webp",
		"webm",
		"mp4",
	];

	$can_go_back = false;

	$prg = '/[^a-zA-Z0-9!?\\/\\-_%@#\(\)\[\]\{\}\'`´\s]/i';

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

	if(isset($_GET["p"]) === true)
	{
		$page = intval($_GET["p"]);
	}

	if(isset($_GET["gallery"]) === true)
	{
		$gallery = preg_replace($prg, "_", $_GET["gallery"]);

		if(str_starts_with($gallery, "..") === true ||str_starts_with($gallery, "/") === true)
		{
			while(str_starts_with($gallery, "..") === true)
			{
				$gallery = substr($gallery, 2, strlen($gallery)-2);
			}
			while(str_starts_with($gallery, "/") === true)
			{
				$gallery = substr($gallery, 1, strlen($gallery)-1);
			}
		}

		if(str_starts_with($gallery, $gallery_dir_root) === false)
		{
			$gallery = $gallery_dir_root . "/" . $gallery;
		}
	}else{
		$gallery = $gallery_dir_root;
	}

	$d = scandir($gallery, SCANDIR_SORT_ASCENDING);

	$files = [];
	$subgalleries = [];
	$cnt = 0;

	if($d === false)
	{
		echo "Could not open directory " . $gallery;
	}else{
		//echo $gallery . "<br>";
		//echo "Skips " . $files_per_page . " * " . $page . " + 3 = " . (($files_per_page * $page) + 3) . "<br>";
		foreach($d as $gal)
		{
			if($cnt < ($files_per_page * $page) + 3)
			{
				//echo "cnt: " . $cnt . "  - skip -<br>";
				$cnt++;
				continue;
			}


			$fdir = $gallery . "/" . $gal;
			
			if($gal !== "." && $gal !== "..")
			{
				if(is_dir($fdir) === true && is_file($fdir) === false)
				{
					//echo $fdir . " is a directory<br>";
					array_push($subgalleries, str_replace($gallery_dir_root . "/", "", $fdir));
					//echo "- DIRECTORY -<br>";
				}
				else if(is_file($fdir) === true && count($files) < $files_per_page)
				{
					//echo $fdir . " is a file <br>";
					$bits = explode(".", $fdir);
					if(in_array(strtolower($bits[count($bits)-1]), $allowed_files) === true)
					{
						//echo "Detected " . $bits[count($bits)-1] . ": " . $fdir . "<br>";
						array_push($files, $fdir);
						//echo "<font color=\"red\">";
					}
				}
			}
			//echo "cnt: " . $cnt . " " . $fdir . "</font><br>";
			$cnt++;
		}	
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="blog.css">
	<!-- Try to prevent the browser from caching the page -->
	<meta http-equiv="cache-control" content="max-age=0">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 11:00:00 GMT">
	<meta http-equiv="pragma" content="no-cache">

</head>
<body>
	<h1>Gallery</h1>
	<h4><?php echo "/" . $gallery ?> (Page <?php echo $page; ?>)</h4>
	<p><?php
		$bits2 = explode("/", $gallery);
		$parents = [];
		if(count($bits2) > 1)
		{
			for($x = 0; $x < count($bits2) - 1; $x++)
			{
				$parent = "";
				for($y = 0; $y <= $x; $y++)
				{
					if($y > 0)
					{
						$parent .= "/";
					}
					$parent .= $bits2[$y];
				}
				array_push($parents, $parent);
			}
		}

		if(count($parents) > 0)
		{
			$iparent = $parents[count($parents)-1];
			echo "| <a href=\"index.php?gallery=$iparent\">[ GO UP ]</a> - ";
		}

		$pages = floor($cnt / $files_per_page);

		echo("- <a href=\"index.php?gallery=$gallery&p=0\"> [ First ] </a> - ");
		echo("- <a href=\"index.php?gallery=$gallery&p=$pages\"> [ Last ] </a> - ");
		if($page + 1 <= $pages)
		{
			$n = $page + 1;
			echo("- <a href=\"index.php?gallery=$gallery&p=$n\"> [ Next ] </a> - ");
		}
		if($page - 1 >= 0)
		{
			$n = $page - 1;
			echo("- <a href=\"index.php?gallery=$gallery&p=$n\"> [ Previous ] </a> - ");
		}
	?>
		<form method="GET" action="index.php">
		Gallery: 
		<select name="gallery">
			<?php
				echo "<option value=\"$gallery\" selected>(CURRENT) $gallery</option>";
				foreach($parents as $parent)
				{
					echo "<option value=\"$parent\">(UP) $parent</option>";
				}
				foreach($subgalleries as $sub)
				{
					echo "<option value=\"$sub\">(SUB) $sub</option>";
				}
			?>
		</select><input type="submit" value="Go">
			Page: 
		<select name="p">
			<?php
				for($x = 0; $x <= $pages; $x++)
				{
					echo "<option value=\"$x\"";
					if($x == $page)
					{
						echo " selected";
					}
					echo ">$x</option>";
				}
			?>
		</select><input type="submit" value="Go"> <a href="index.php">[BACK TO INDEX]</a> - <a href="../mdblog/index.php?e=content/2021-5-30/How_to_use_the_gallery.md">[HELP]</a>
	</form></p>
	<hr>
	<table border="0" width="100%" style="width:100%;font-size:8pt;">
		<?php
			$cnt = 0;
			$thumb_gallery = str_replace($gallery_dir_root, $thumb_dir_root, $gallery);
					
			if(is_dir($thumb_gallery) === false)
			{
				if(is_file($thumb_gallery) === true)
				{
					delete($thumb_gallery);
				}

				mkdir($thumb_gallery);
				chmod($thumb_gallery, 0770);

				$f = @fopen($thumb_gallery . "/index.html", "w");
				if($f !== false)
				{
					ftruncate($f, 0);
					fclose($f);
				}
			}
			foreach($files as $file)
			{
				//echo $file . "<br>";
				if(file_exists($file) && is_dir($file) === false)
				{
					$thumb_dir = str_replace($gallery_dir_root, $thumb_dir_root, $file);

					if(file_exists($thumb_dir) === false)
					{
						$imagick = new \Imagick($file);

						$imagick->resizeImage($thumbnail_width,$thumbnail_height,imagick::FILTER_LANCZOS,0.9,true);
						$imagick->cropImage($thumbnail_width,$thumbnail_height,0,0);

						$imagick->writeImage($thumb_dir);
					}

					if($cnt == 0)
					{
						echo "<tr>";
					}
					echo "<td width=\"$thumbnail_width\" style=\"max-width:" . $thumbnail_width . "px;height:auto;text-overflow:ellipsis;\">";
					echo "<a href=\"" . $file . "\">";
					echo "<img src=\"" . $thumb_dir . "\"/>";
					echo "</a>";
					$fnameb = explode("/", $file);
					$fname = $fnameb[count($fnameb)-1];
					echo "<p><font size=\"1\">$fname</font></p>";
					echo "</td>";
					$cnt++;
					if($cnt >= $files_per_row)
					{
						echo "</tr>";
						$cnt = 0;
					}
				}
			}
		?>
	</table>
</body>
</html>