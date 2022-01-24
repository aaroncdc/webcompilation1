<?php
	function BoardExists($mysqlman, $board_id)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "boards WHERE ID = $board_id");
		if($mysqlman->numrows() > 0)
		{
			return true;
		}
		return false;
	}
	
	function GetBoardInfo($mysqlman, $board_id)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "boards WHERE ID = $board_id");
		return $mysqlman->sqlfetchassoc();
	}
	
	function GetTotalThreads($mysqlman, $board_id)
	{
		$mysqlman->sqlquery("SELECT COUNT(*) FROM " . constant('tab_prefix') . "threads WHERE BOARD = $board_id");
		return $mysqlman->sqlfetchrow()[0];
	}
	
	function MakeBoardPagination($mysqlman, $board_id, $page)
	{
		$total = GetTotalThreads($mysqlman, $board_id);
		$totalpages = floor($total/10);
		$st = ($page - 3 < 0)?0:$page - 3;
		$lim = (($page + 3) * 10 > $total - 1)?floor(($total - 1)/10):$page + 3;
		for($x = $st; $x <= $lim; $x++)
		{
			if($x == $page)
				echo "($x) ";
			else
				echo '<a href="board.php?b='.$board_id.'&p='.$x.'">['.$x.']</a> ';
		}
	}
	
	function PrintThreads($mysqlman, $board_id, $start)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "threads WHERE BOARD = $board_id ORDER BY UID ASC LIMIT $start, 10");
		if($mysqlman->numrows() > 0)
		{
			while($res = $mysqlman->sqlfetchassoc())
			{
				echo '<li><a href="thread.php?t='.$res['ID'].'">'.$res['NAME'].'</a>('.$res['REPLIES'].' replies)</li>';
			}
		}else{
			echo 'No data available.';
		}
		
	}
	
?>