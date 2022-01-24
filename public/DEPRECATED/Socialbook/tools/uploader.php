<?php
	require_once('jbbinit.php');
	require_once('sbtools.php');
	$extensions = array('jpg','png','gif');
	$valid = false;
		if(!isset($_POST['usmail']) || !isset($_POST['ussid']))
			die(".!E Usuario o ID no especificados (".$_POST['usmail']." , ".$_POST['ussid'].")");
	
	if(!checkSession($_POST['usmail'], $_POST['ussid']))
		die(".!E Sesión erronea (".$_POST['usmail']." , ".$_POST['ussid'].")");
	
	$query = "SELECT IDNO FROM USUARIOS WHERE USMAIL='$_POST[usmail]' AND SESSIONID='$_POST[ussid]'";

	$mysqlman->sqlquery($query);
	$res = $mysqlman->sqlfetchassoc();
	
	$usid = $res['IDNO'];
	
	if(!file_exists('../perfiles/'.$usid))
		mkdir('../perfiles/'.$usid);
		
			$maindir = '../perfiles/'.$usid.'/'.$usid;
			$found = false;
			for($i = 0; $i < sizeof($extensions); $i++)
			{
				if(file_exists('../perfiles/'.$usid.'/'.$usid.'.'.$extensions[$i]))
				{
					unlink('../perfiles/'.$usid.'/'.$usid.'.'.$extensions[$i]);
					$found = true;
				}
			}
		
	$finfo = new SplFileInfo($_FILES['file-0']['name']);
	for($i = 0; $i < sizeof($extensions); $i++)
	{
		if($finfo->getExtension() == $extensions[$i])
			$valid = true;
	}
		
	if($valid)
	{
		copy($_FILES['file-0']['tmp_name'],$maindir.'.'.$finfo->getExtension());
		echo('perfiles/'.$usid.'/'.$usid.'.'.$finfo->getExtension());
	}else{
		echo('static/person.png');
	}
	
	$mysqlman->endconnection();
	//echo ($_FILES['file-0']['name']);
	//if(!file_exists('perfiles/'))
	//echo("<br/>".$_POST['usmail']);