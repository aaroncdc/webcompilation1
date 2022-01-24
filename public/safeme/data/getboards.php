<?php
	
	function PrintBoardNav($mysqlman)
	{
		$mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "boards ORDER BY CATEGORY ASC");
		$boardlist = null;
		if($mysqlman->numrows() > 0)
		{
			while($res = $mysqlman->sqlfetchassoc())
			{
				echo '<a href="board.php?b='. $res['ID'] .'">/' . $res['PREFIX']
				. '/ </a> ';
			}
		}
	}
	
	function PrintBoardSections($mysqlman)
	{
		$cats = $mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "board_category ORDER BY ID ASC");
		if($mysqlman->numrows() > 0)
		{
			while($res1 = $mysqlman->sqlfetchassoc_ns($cats))
			{
				$rid = $res1['ID'];
				$catboards = $mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "boards WHERE CATEGORY = $rid");
				if($mysqlman->numrows() > 0)
				{
					echo '<content class="board_list_section"><table><tr><th>'.$res1['NAME'].'</th></tr>';
					while($res2 = $mysqlman->sqlfetchassoc_ns($catboards))
					{
						echo '<tr><td><a href="board.php?b='. $res2['ID'] .'">/'.$res2['PREFIX'].'/ - '.$res2['NAME']
						.'</a></td></tr>';
					}
					echo '</table></content>';
				}
			}
		}
	}
	
?>