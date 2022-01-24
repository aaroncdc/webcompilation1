<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Resultado del registro</title>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Open+Sans');
		body {
			font-family: 'Open Sans', sans-serif;
		}
		table {
			margin: 0 auto;
			text-align: center;
			border-collapse: collapse;
		}
		td, tr, th {
			border: 1px solid black;
		}

		th{
			background-color: #7ea3dd;
		}
	</style>
</head>
<body>
<table>
	<tr>
		<th>Campo</th>
		<th>Valor</th>
	</tr>
<?php 


    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }


?>
</table>
</body>
</html>