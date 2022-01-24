<?php
	require('Parsedown.php');
	$post_password = '<A very strong password goes here>';

	$post = false;
	$allowed = false;
	$mode = "";
	$root = "content";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$mode = $_POST['submit'];
		
		$post = true;
		$options = [
			'cost => 24',
		];

		if(password_verify($_POST['password'], $post_password))
		{
			$allowed = false;
		}else{
			$allowed = true;
		}
	}

	if($mode == "Post")
	{
		$date = getdate();
		$folder = str_replace("\..", "", $root . '/' . $date['year'] . '-' . $date['mon'] . '-' . $date['mday']);
		echo $folder . '<br>';
		$file = str_replace(" ", "_", trim(strip_tags($_POST['post-title']), "\n\r\t\v\0./")) . '.md';
		echo $file . '<br>';
		
		if(!is_dir($folder) && !file_exists($folder))
		{
			mkdir($folder);
			chmod($folder, 0770);
			chown($folder, "www-data:www-data");
		}

		if(!file_exists($folder . "/index.html"))
		{
			copy("indextemplate.html", $folder . "/index.html");
		}
		

		$f = fopen($folder . '/' . $file, "w");
		if($f)
		{
			if(fwrite($f, trim($_POST['post-content'], " \t")) === false)
			{
				die('Error writting on ' . $folder . '/' . $file);
			}else{
				die('Successfully posted ' . $folder . '/' . $file);
			}
			fclose($f);
		}else{
			die('Error opening ' . $folder . '/' . $file . ' for writting');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>BLOG COMPOSER</title>
	<link rel="stylesheet" href="blog.css">
</head>
<body>
	<table class="page-layout">
		<tr>
			<td class="composer-layout">
		<div class="composer-form">
			<form method="POST" action="composer.php">
				<table style="width:100%;">
					<tr>
						<td>Title: </td>
						<td>
							<?php
								if($allowed === true && $mode === "Preview")
								{
									?>
										<input type="text" name="post-title" value='<?php echo htmlspecialchars($_POST['post-title']); ?>'>
									<?php
								}else{
									?>
										<input type="text" name="post-title">
									<?php
								}
							?>
							
						</td>
					</tr>
					<tr>
						<td colspan="2">Content:</td>
					</tr>
					<tr>
						<td colspan="2">
						<?php
						if($allowed === true && $mode === "Preview")
						{
							?>
								<textarea name="post-content">
									<?php echo trim(htmlspecialchars($_POST['post-content']), " \t"); ?>
								</textarea>
							<?php
						}else{
							?>
								<textarea name="post-content"></textarea>
						<?php
						}
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" value="password"></td>
					</tr>
					<tr>
						<td><input type="submit" name="submit" value="Preview"></td>
						<td><input type="submit" name="submit" value="Post"></td>
					</tr>
				</table>
			</form>
		</div>	
			</td>
			<td>
				<div class="preview">
					<?php
						if($post === true)
						{
							if($allowed === true && $mode=="Preview")
							{
								$Parsedown = new Parsedown();
								$Parsedown->setSafeMode(true);
								echo $Parsedown->text($_POST['post-content']);
							}
						}else{
							$Parsedown = new Parsedown();
							$Parsedown->setSafeMode(true);
							echo $Parsedown->text("# Post Title\n## Post Subtitle\n\nWrite something and then press 'preview' to preview your changes.");
						}
					?>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>