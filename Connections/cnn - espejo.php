<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnn = "entretenimiento.cuznbgafgkfl.us-east-1.rds.amazonaws.com";
$database_cnn = "entretenimiento";
$username_cnn = "entreten";
$password_cnn = "x0tr.u21";
$cnn = mysql_connect($hostname_cnn, $username_cnn, $password_cnn) or trigger_error(mysql_error(),E_USER_ERROR);
?>