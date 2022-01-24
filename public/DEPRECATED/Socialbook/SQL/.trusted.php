<?php
	$trusted_locations = array(
		"127.0.0.1",
		"::1",
		"localhost"
	);
	
	function check_guest($guest)
	{
		global $trusted_locations;
		for($i = 0; $i < sizeof($trusted_locations); $i++)
		{
			if($trusted_locations[$i] == $guest)
				return true;
		}
		return false;
	}
	
	?>