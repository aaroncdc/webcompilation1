<?php
		$link = mysql_connect("localhost", "magnus98_magnussql", "002005008");
		mysql_select_db("magnus98_userlist", $link);

		if (! $link){
		echo '<font color="#FF0000">Connection with SQL database failed!</font>';
		exit;
		}
		
		$title=$_POST['name'];
		$text=$_POST['comment'];
		$textt=$_POST['comment'];
		if($textt != ""){
		$sql = "INSERT INTO shoutbox (name, date, text) ";
		$sql .= "VALUES ('$title', NOW(), '$text')";
		if(!$result = mysql_query($sql)){
		echo "¡Error al meter los datos!";
		}else{
		header("Location: index.php" ); 
		}
		}
		?>