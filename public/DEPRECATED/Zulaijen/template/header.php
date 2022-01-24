<?php
	if(file_exists('utils/common.php'))
		require_once('utils/common.php');
	else if(file_exists('../utils/common.php'))
		require_once('../utils/common.php');
	else
		require_once('common.php');
		
	/*$islog = false;
	if(isset($_COOKIE['Session']) || isset($_COOKIE['User']))
	{
		$islog = true;
		if(!checkSession($_COOKIE['Session'], $_COOKIE['User']))
		{
			unset($_COOKIE['Session']);
			unset($_COOKIE['User']);
			$islog = false;
		}
	}*/
?>

<header class="title"><h1>Zulaijen <small>Image Gallery</small></h1><hr/></header>
<nav id="mynav"><img src="static\glyphicons\png\glyphicons-517-menu-hamburger.png" id="tgmenu" /> | <img src="static\glyphicons\png\glyphicons-28-search.png" width="16px" height="16px"/><input type="text" class="st" placeholder="Search"/></nav>
<header class="hmenu" id="hmenu"> Testing menu</header>