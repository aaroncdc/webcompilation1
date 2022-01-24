<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Socialbook = "localhost";
$database_Socialbook = "socialbook";
$username_Socialbook = "root";
$password_Socialbook = "";
$Socialbook = mysql_pconnect($hostname_Socialbook, $username_Socialbook, $password_Socialbook) or trigger_error(mysql_error(),E_USER_ERROR); 
?>