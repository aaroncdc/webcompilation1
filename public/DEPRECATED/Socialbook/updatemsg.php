<?php
	session_start();
	require_once('tools/jbbinit.php');
	require_once ('tools/sbtools.php');
	if(!isset($_POST['usermail']) || !isset($_POST['usersid']))
		die(".!E Usuario o ID no especificados (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	if(!checkSession($_POST['usermail'], $_POST['usersid']))
		die(".!E Sesión erronea (".$_POST['usermail']." , ".$_POST['usersid'].")");
	
	$uid = getUsId($_POST['usermail'], $_POST['usersid']);
	$ussid = $_POST['usersid'];
	
	if(isset($_SESSION['lastpost']))
		$lastid = $_SESSION['lastpost'];
	else
		$lastid = -1;
	
	if($lastid == -1)
		$order = "DESC";
	else
		$order = "ASC";
	
	$query = $mysqlman->sqlquery("SELECT * FROM MENSAJES WHERE DEST=$uid OR (IDNO=$uid AND CONT <> '<!>') ORDER BY MID $order LIMIT 5");
	
	$cnt = 0;
	while($rs = $mysqlman->sqlfetchassoc())
	{
		if($cnt >= $lastid)
		{
			$query = $mysqlman->sqlquery_ns("SELECT * FROM USUARIOS WHERE IDNO=$rs[IDNO]");
			$ru = $mysqlman->sqlfetchassoc_ns($query);
			$query = $mysqlman->sqlquery_ns("SELECT * FROM USUARIOS WHERE IDNO=$rs[DEST]");
			$rd = $mysqlman->sqlfetchassoc_ns($query);
			echo("<article><table borer=\"0\"><tr><td>");
			echo('<a href="perfil.php?uid='.$rs['IDNO'].'"><img src="perfiles/'.$rs['IDNO'].'/'.$rs['IDNO'].'.jpg" class="prof-article"/></a></td>');
			echo("<td valign=\"center\"><b>De: </b>" . $ru['NOM'] . " " . $ru['APE1'] . " " . $ru['APE2'] . "</td></tr>"
			.	"<tr><td valign=\"center\" colspan=\"2\"><b> A: </b>" . $rd['NOM'] . " " . $rd['APE1'] . " " . $rd['APE2'] . "</td></tr>");
			echo("<tr><td valign=\"center\" colspan=\"2\"><b> Fecha: </b> " . $rs['FECHA'] . "</td></tr></table><hr/>");
			
			if($rs['CONT'] != "<!>")
			{ 
				$parser->parse($rs['CONT']);
				echo('<p class="article">'.$parser->getAsHtml().'</p>');
				echo('<div align="right"><input type="button" class="button" value="borrar" onclick="delmsg('.$rs['MID'].')"/></div>');
			}else{
				echo('<form action="amistad.php?aid='.$ru['IDNO'].'&bid='.$uid.'" method="post">');
				echo('<fieldset>');
				echo('<center><b><p class="article">'.$ru['NOM'].' te ha mandado una solicitúd de amistad.</p></b>');
				echo('<input type="submit" class="button" value="Aceptar"/>');
				echo(' <input type="button" class="button" value="Rechazar" onclick="friendDeny('.$ru['IDNO'].','.$uid.')"/></center>');
				echo('</fieldset>');
				echo('</form>');
			}
			echo("</article>");
		}
		$cnt++;
	}
	
	$_SESSION['lastpost'] = $cnt;