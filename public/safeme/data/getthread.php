<?php
	function GetThreadInfo($mysqlman, $thread_id)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "threads WHERE ID = $thread_id");
		return $mysqlman->sqlfetchassoc();
	}
	
	function ThreadExists($mysqlman, $thread_id)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "threads WHERE ID = $thread_id");
		if($mysqlman->numrows() > 0)
			return true;
		return false;
	}
	
	function PrintReplies($mysqlman, $thread_id, $start)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "posts WHERE THREAD = $thread_id ORDER BY ID ASC LIMIT $start, 10");
		if($mysqlman->numrows() > 0)
		{
			$x = $start;
			while($res = $mysqlman->sqlfetchassoc())
			{
				echo '<content class="section_reply_header">';
				echo '#' . $x . ' ' . $res['OWNER'] . ' - ' . $res['DATE'];
				if($res['LINK'] != null && $res['LINK'] != '')
					echo ' <a href="' . $res['LINK'] . '">(LINK)</a>';
				echo '</content><content class="section_reply_content">';
				echo $res['CONTENT'] . '</content>';
				
				$x++;
			}
		}else{
			echo 'No data';
		}
	}
	
	function GetTotalReplies($mysqlman, $thread_id)
	{
		$mysqlman->sqlquery("SELECT COUNT(*) FROM " . constant('tab_prefix') . "posts WHERE THREAD = $thread_id");
		return $mysqlman->sqlfetchrow()[0];
	}
	
	function GetLastPage($mysqlman, $thread_id)
	{
		$total = GetTotalReplies($mysqlman, $thread_id);
		return floor($total/10);
	}
	
	function MakeThreadPagination($mysqlman, $thread_id, $page)
	{
		$total = GetTotalReplies($mysqlman, $thread_id);
		$totalpages = floor($total/10);
		$st = ($page - 3 < 0)?0:$page - 3;
		$lim = (($page + 3) * 10 > $total - 1)?floor(($total - 1)/10):$page + 3;
		for($x = $st; $x <= $lim; $x++)
		{
			if($x == $page)
				echo "($x) ";
			else
				echo '<a href="thread.php?t='.$thread_id.'&p='.$x.'">['.$x.']</a> ';
		}
	}
?>