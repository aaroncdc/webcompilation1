		<div class="elist">
	
		<?php
			$cnt = 0;
			$pags = ceil(sizeof($dirlist) / $ipp);
			
			for($n = 0; $n < $ipp && $n < sizeof($dirlist); $n++) {
				$imgind = ($ipp*$mi) + $n;
				
				if(!isset($dirlist[$imgind]))
					continue;
					
				if(!file_exists("static/dtest/" . $dirlist[$imgind]) && !file_exists("static/dtest/thumb/" . $dirlist[$imgind]) ||
					is_dir("static/dtest/" . $dirlist[$imgind]) || is_dir("static/dtest/thumb/" . $dirlist[$imgind]))
					continue;
				
				echo ("<div class=\"entry\"><a href=\"view.php?id=$imgind\"><img class=\"entry\" src=\"static/dtest/thumb/$dirlist[$imgind]\" width=\"128px\" height=\"128px\"/></a><a href=\"static/dtest/$dirlist[$imgind]\" class=\"zoomin\"><img class=\"zoomin\" src=\"static/button/zoomin.png\"/></a></div>");
			}
			
			/*foreach($dirlist as $img) {
				echo ("<div class=\"entry\"><a href=\"static/dtest/$img\"><img class=\"entry\" src=\"static/dtest/thumb/$img\" width=\"128px\" height=\"128px\"/></a></div>");
				$cnt++;
				if($cnt >= $ipp)
					break;
			}*/
			if($prev >= 0)
				echo("<br/><center><div class=\"pager\"><div class=\"button\" onclick=\"nav($prev)\"> << </div>");
			else
				echo("<br/><center><div class=\"pager\"><div class=\"button_invalid\"> << </div>");			
			for($i = ($mi - $pagspp < 0)?0:$mi-$pagspp; $i < ($mi + $pagspp + 1) && $i <= $pags; $i++)
			{
				$cap = $i+1;
				if($i != $mi)
					echo("<div class=\"button\" onclick=\"nav($i)\">$cap</div>");
				else
					echo("<div class=\"button_invalid\"><b>[$cap]</b></div>");
			}
			if($next <= $pags)
				echo("<div class=\"button\" onclick=\"nav($next)\"> >> </div></center></div>");
			else
				echo("<div class=\"button_invalid\" onclick=\"nav($next)\"> >> </div></center></div>");
			?>
		</div>
