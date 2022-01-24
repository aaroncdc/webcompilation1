<?php
	require_once('data/nsa.php');
	$postrequest = isset($_POST['tid']);
	if(isset($_GET['t']))
		$threadid = ($postrequest)?$_POST['tid']:$_GET['t'];
	else
		$threadid = ($postrequest)?$_POST['tid']:-1;
	
	require_once('data/config/connect.php');
	require_once('data/config/hashgen.php');
	require_once('data/getchanconfig.php');
	require_once('data/getthread.php');
	require_once('data/getboards.php');
	require_once('data/getboardinfo.php');
	
	if(!is_numeric($threadid))
		die('<center><img src="static/imgs/thinking.jpg" width="10%"/></center>');
	if($threadid < 0 || $threadid == null)
		die('<center><img src="static/imgs/magicword.gif" width="75%"/></center>');
	if(!ThreadExists($mysqlman, $threadid))
		die('<center><img src="static/imgs/seized.jpg" width="100%"/></center>');
	
	$thread = GetThreadInfo($mysqlman, $threadid);
	$boardinfo = GetBoardInfo($mysqlman, $thread['BOARD']);
	
	if(isset($_GET['p']))
		$page = $_GET['p'];
	else
		$page = GetLastPage($mysqlman,$thread['ID']);
	
	if($page < 0 || !is_numeric($page))
		$page = 0;
	
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
			require_once('data/makereply.php');
			$tname = $mysqlman->real_escape_string(htmlentities($_POST['tname']));
			$tlink = $mysqlman->real_escape_string(htmlentities($_POST['tlink']));
			$tcontent = $mysqlman->real_escape_string(htmlentities($_POST['tcontent']));
			if(!NewReply($mysqlman, $threadid, $tname, $tlink, $tcontent))
				echo 'Reply creation error: ' . $mysqlman->sqlerror();
		}
	}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Safeme</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php echo '<link rel="stylesheet" href="static/css/' . $boardinfo['STYLE'] . '">'; ?>
    </head>
    <body>
        <nav class="navbar">
			<?php
				PrintBoardNav($mysqlman);
			?>
		</nav>
		<?php
			require_once('data/getbanners.php');
			PrintBanner($boardinfo['ID']);
		?>
        <content class="section_header">
            <?php
				echo '/'.$boardinfo['PREFIX'].'/ - '.$boardinfo['NAME'];
			?>
        </content>
        <content class="section_header">
		<?php
			echo '#' . $thread['UID'] . ' - ' . $thread['NAME'];
		?>
        </content>
        
		<?php PrintReplies($mysqlman, $threadid, $page*10) ?>
		
        <br/>
        <fieldset>
            <form class="user_input" method="POST" action="thread.php">
			<?php echo '<input type="hidden" name="tid" value="'.$threadid.'">' ?>
                <label>Name:</label> <input type="text" name="tname" placeholder="Anonymous"><br/>
                <label>Link:</label> <input type="text" name="tlink" placeholder="http://..."><br/>
                <label>Text (0/2048):</label><br/>
                <textarea cols="30" rows="10" name="tcontent"></textarea><br/>
                <input type="submit" value="Reply"><input type="reset">
            </form>
        </fieldset>
        <content class="section_pagination">
            <?php MakeThreadPagination($mysqlman, $threadid, $page); ?>
        </content>
        <center><a href="index.php">Back to main screen</a> |
		<?php
			echo '<a href="board.php?b='. $thread['BOARD'] . '">Back to Board</a>';
		?></center><br/>
    </body>
</html>