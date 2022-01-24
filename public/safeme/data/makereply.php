<?php
	function BumpThread($mysqlman, $thread_id)
	{
		$mysqlman->sqlquery("SELECT BOARD,UID FROM " . constant('tab_prefix') . "threads WHERE ID = $thread_id");
		$data = $mysqlman->sqlfetchrow();
		$board_id = $data[0];
		$old_uid = $data[1];
		
		$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "threads SET UID = 1 WHERE ID = $thread_id");
		$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "threads SET UID = UID + 1 WHERE BOARD = $board_id AND UID < $old_uid AND ID <> $thread_id");
	}
	
	function NewReply($mysqlman, $thread_id, $name, $link, $content)
	{
		if($name == null || $name == "")
			$name = "Anonymous";
		if($content == null || $content == "")
			return false;
		
		$mysqlman->sqlquery("INSERT INTO " . constant('tab_prefix') . "posts(THREAD,OWNER,CONTENT,DATE,LINK) VALUES ($thread_id,'$name','$content',NOW(),'$link')");
		if($mysqlman->numaffected() < 1)
			return false;
		$mysqlman->sqlquery("UPDATE " . constant('tab_prefix') . "threads SET REPLIES = REPLIES + 1 WHERE ID = $thread_id");
		if($mysqlman->numaffected() < 0)
			return false;
		RegisterActivity($mysqlman, 30);
		
		BumpThread($mysqlman, $thread_id);
		return true;
	}
?>