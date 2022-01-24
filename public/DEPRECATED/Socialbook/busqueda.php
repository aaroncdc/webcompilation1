<?php
	session_start();
	require_once('tools/jbbinit.php');
    require_once ('tools/sbtools.php');
	getAndCheck();
	$_SESSION['lastpost'] = null;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/socialbook.css" rel="stylesheet" type="text/css"/>
		<script src="js/jquery-1.12.0.js" type="text/javascript"></script>
		<title>Socialbook - Búsqueda</title>
		<script type="text/javascript">
		function loadProfile(id)
		{
			$(window)[0].location.href = "perfil.php?uid=" + id;
		}
		</script>
	</head>
	<body>
	<?php include('template/head.php'); ?>
	<br/><br/><br/><br/>
	<div id="entradas">
	<?php
		if(isset($_GET['searchstr']))
			$searchstr = $_GET['searchstr'];
		
		$searchterms = explode(" ",$searchstr);
		$l1 = $searchterms[0];
		
		$l = Array();
		
		foreach($searchterms as $term)
		{
			array_push($l, "OR NOM LIKE '%".$term."%'");
			array_push($l, "OR APE1 LIKE '%".$term."%'");
			array_push($l, "OR APE2 LIKE '%".$term."%'");
			array_push($l, "OR USMAIL LIKE '%".$term."%'");
		}
		
		$finalterm = "";
		
		foreach($l as $q)
		{
			$finalterm .= " " . $q;
		}
		
		$qres = $mysqlman->sqlquery("SELECT * FROM USUARIOS WHERE NOM LIKE '%$l1%'$finalterm");
		if($mysqlman->numrows() < 1)
		{
			echo("<article>");
			echo("<center><b><p>No se han encontrado resultados.</p></b></center>");
			echo("</article>");
		}else{
			while($fa = $mysqlman->sqlfetchassoc())
			{
				echo("<article><table>");
				echo("<tr><td rowspan=\"3\"><img src=\"perfiles/$fa[IDNO]/$fa[IDNO].jpg\" class=\"prof-article\"/></tr></tr>");
				echo("<tr><td></td><td><b>Nombre: </td><td>".$fa['NOM']."</td></tr>");
				echo("<tr><td></td><td valign=\"top\"><b>Apellidos: </td><td valign=\"top\">".$fa['APE1']." ".$fa['APE2']."</td></tr>");
				echo("</table>");
				echo("<center><input type=\"button\" class=\"button\" value=\"Ver perfíl\" onclick=\"loadProfile($fa[IDNO])\"/></center></article>");
			}
		}
	?>
	</div>
	</body>
</html>
<?php
	$mysqlman->endconnection();
?>