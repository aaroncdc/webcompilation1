<?php
	/* TRUSTED LOCATIONS ARRAY */
	//Add more IPs and domain names, separated by a comma.
	//Last address should not end with a comma.
	$trusted_locations = array(
		"127.0.0.1",
		"::1",
		"localhost",
		"192.168.1.180",
		"192.168.1.150"//,
		//"Anotherhost",
		//"192.168.1.30"
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