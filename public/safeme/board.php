<?php
	require_once('data/nsa.php');
	$postrequest = isset($_POST['tid']);
	if(isset($_GET['b']))
		$boardid = ($postrequest)?$_POST['tid']:$_GET['b'];
	else
		$boardid = ($postrequest)?$_POST['tid']:-1;
	
	if(isset($_GET['p']))
		$page = $_GET['p'];
	else
		$page = 0;
	
	if($page < 0 || !is_numeric($page))
		$page = 0;
	
	if(!is_numeric($boardid))
		die('<center><img src="static/imgs/thinking.jpg" width="10%"/></center>');
	if($boardid < 0 || $boardid == null)
		die('<center><img src="static/imgs/magicword.gif" width="75%"/></center>');

	require_once('data/config/connect.php');
	require_once('data/config/hashgen.php');
	require_once('data/getchanconfig.php');
	require_once('data/getboards.php');
	require_once('data/getboardinfo.php');
	if(!BoardExists($mysqlman, $boardid))
		die('<center><img src="static/imgs/seized.jpg" width="100%"/></center>');
	
	$boardinfo = GetBoardInfo($mysqlman, $boardid);
	
	if($postrequest)
	{
		if(IsBanned($mysqlman))
			die ('You are banned.');
		if(IsOnCoolDown($mysqlman))
		{
			$cd = GetCoolDown($mysqlman)->getTimestamp();
			$now = getDatetimeNow();
			$diff = $cd - strtotime($now);
			echo '<br/> <h3>YOU CAN NOT POST YET. PLEASE WAIT ' . $diff . ' SECONDS...</h3>';
		}else{
			require_once('data/makethread.php');
			$tname = $mysqlman->real_escape_string(htmlentities($_POST['tname']));
			$ttitle = $mysqlman->real_escape_string(htmlentities($_POST['ttitle']));
			$tlink = $mysqlman->real_escape_string(htmlentities($_POST['tlink']));
			$tcontent = $mysqlman->real_escape_string(htmlentities($_POST['tcontent']));
			
			if(!NewThread($mysqlman, $boardid, $tname, $ttitle, $tlink, $tcontent))
				echo 'Thread creation error: ' . $mysqlman->sqlerror();
		}
	}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Safeme</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php
			echo '<link rel="stylesheet" href="static/css/' . $boardinfo['STYLE'] . '">';
		?>
    </head>
    <body>
        <nav class="navbar">
			<?php
				PrintBoardNav($mysqlman);
			?>
		</nav>
        
		<?php
			require_once('data/getbanners.php');
			PrintBanner($boardid);
		?>
		
        <content class="section_header">
            <?php
				echo '/'.$boardinfo['PREFIX'].'/ - '.$boardinfo['NAME'];
			?>
        </content>
        <fieldset>
            <form class="user_input" method="POST" action="board.php">
			<?php echo '<input type="hidden" name="tid" value="'.$boardid.'">' ?>
                <label>Name:</label> <input type="text" placeholder="Anonymous" name="tname"><br/>
				<label>Title:</label> <input type="text" placeholder="Thread title" name="ttitle"><br/>
                <label>Link:</label> <input type="text" placeholder="http://..." name="tlink"><br/>
                <label>Text (0/2048):</label><br/>
                <textarea cols="30" rows="10" name="tcontent"></textarea><br/>
                <input type="submit" value="New thread"><input type="reset">
            </form>
        </fieldset>
        <content class="section_header">
			<?php
				echo GetTotalThreads($mysqlman, $boardid);
			?>
			 threads
        </content>
        <content class="section_list">
            <ol>
                <?php PrintThreads($mysqlman, $boardid, $page*10); ?>
            </ol>
        </content>
        <content class="section_pagination">
		<?php MakeBoardPagination($mysqlman, $boardid, $page); ?>
        </content>
        <center>
		<a href="index.php">Back to main screen</a><br/></center>
    </body>
</html>