<?php
	function PrintBanner($board_id)
	{
		$banners = array();
		if($handle = opendir(getcwd() . '/static/banners/'.$board_id.'')) {
			while(false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != ".."
				&& (strtolower(substr($file, strrpos($file, '.') + 1)) == 'jpg'
				|| strtolower(substr($file, strrpos($file, '.') + 1)) == 'png'
				|| strtolower(substr($file, strrpos($file, '.') + 1)) == 'gif'
				|| strtolower(substr($file, strrpos($file, '.') + 1)) == 'webp'))
				{
					array_push($banners, $file);
				}
			}
		}else{
			echo 'Error opening ' . getcwd() . '/static/banners/' . $board_id . ' !! ';
			return;
		}
		
		$select = rand(0,count($banners)-1);
		echo '<center><img src="static/banners/'.$board_id.'/'.$banners[$select].'" class="banner"/></center>';
	}
?>