<?php
require("res/connect.php");
mysql_query("DROP TABLE entradas", $link);
mysql_query("DROP TABLE comentarios", $link);
echo "vale";
?>
