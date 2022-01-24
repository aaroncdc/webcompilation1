<?php
	function GetNextUID($mysqlman, $board_id)
	{
		$mysqlman->sqlquery("SELECT COUNT(*) FROM " . constant('tab_prefix') . "threads WHERE BOARD = $board_id");
		return intval($mysqlman->sqlfetchrow()[0]) + 1;
	}

	function BumpThread($mysqlman, $thread_id)
	{
		$mysqlman->sqlquery("SELECT BOARD,UID FROM " . constant('tab_prefix') . "threads WHERE ID = $thread_id");
		$data = $mysqlman->sqlfetchrow();
		$board_id = $data[0];
		$old_uid = $data[1];
		
		$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "threads SET UID = 1 WHERE ID = $thread_id");
		$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "threads SET UID = UID + 1 WHERE BOARD = $board_id AND UID < $old_uid AND ID <> $thread_id");
	}
	
	function RemoveLastThread($mysqlman, $board_id)
	{
		$limit = 100;
		$tt = GetTotalThreads($mysqlman, $board_id);
		if($tt > $limit)
		{
			$qr = $mysqlman->sqlquery("SELECT * FROM " . constant('tab_prefix') . "threads WHERE BOARD = $board_id ORDER BY UID DESC");
			echo $mysqlman->sqlerror();
			if($mysqlman->numrows() < 1)
				return false;
			
			while($res = $mysqlman->sqlfetchassoc_ns($qr))
			{
				if($tt <= $limit)
					return true;
				
				$tid = $res['ID'];
				$tuid = $res['UID'];
				$mysqlman->sqlquery("DELETE FROM " . constant('tab_prefix') . "threads WHERE UID = $tuid");
				if($mysqlman->numaffected() > 0)
					$tt--;
				$mysqlman->sqlquery("DELETE FROM " . constant('tab_prefix') . "posts WHERE THREAD = $tid");
			}
			return true;
		}
	}
	
	function NewThread($mysqlman, $board_id, $name, $title, $link, $content)
	{
		if($name == null || $name == "")
			$name = "Anonymous";
		if($content == null || $content == "")
			return false;
		if($title == null || $title == "")
			return false;
		
		$tuid = GetNextUID($mysqlman, $board_id);
		$mysqlman->sqlquery("INSERT INTO " . constant('tab_prefix') . "threads(UID,BOARD,NAME,OWNER) VALUES ($tuid,$board_id,'$title','$name')");
		if($mysqlman->numaffected() < 1)
			return false;
		$tid = $mysqlman->sqlinsertid();
		$mysqlman->sqlquery("INSERT INTO " . constant('tab_prefix') . "posts(THREAD,OWNER,CONTENT,DATE,LINK) VALUES ($tid,'$name','$content',NOW(),'$link')");
		if($mysqlman->numaffected() < 1)
			return false;
		RegisterActivity($mysqlman, 30);
		BumpThread($mysqlman, $tid);
		RemoveLastThread($mysqlman, $board_id);
		return true;
	}
?>