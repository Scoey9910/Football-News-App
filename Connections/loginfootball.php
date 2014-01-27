<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_loginfootball = "localhost:8888";
$database_loginfootball = "loginfootball";
$username_loginfootball = "root";
$password_loginfootball = "root";
$loginfootball = mysql_pconnect($hostname_loginfootball, $username_loginfootball, $password_loginfootball) or trigger_error(mysql_error(),E_USER_ERROR); 
?>