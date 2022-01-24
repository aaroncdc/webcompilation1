<?php
	require_once('data/config/connect.php');
	require_once('data/config/hashgen.php');
	require_once('data/getchanconfig.php');
	require_once('data/getboards.php');
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Safeme</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
		<?php echo '<link rel="stylesheet" href="static/css/' . $chandefstyle . '">'; ?>
		
    </head>
    <body>
        <nav class="navbar">
			<?php
				PrintBoardNav($mysqlman);
			?>
		</nav>
        <center><img src="static/banners/cover/1.jpg" class="banner"/></center>
        <content class="section_title">
            <?php
				echo $channame;
			?>
        </content>
        <content class="section_subtitle">
			<?php
				echo $chandescription;
			?>
        </content>
        
        <content class="section_title">
            News
        </content>
        
        <content class="news">
			<?php
				echo $channews;
			?>
        </content>
        
        <content class="board_list_title">
            Board List
        </content>
        
        <content class="board_list">
		
		<?php
			PrintBoardSections($mysqlman);
		?>
        </content>
        
        <footer>
            <a href="#">About</a> | <a href="#">Legal Notices</a> | <a href="#">Rules</a> | <a href="#">Core</a>
        </footer>
        
    </body>
</html>