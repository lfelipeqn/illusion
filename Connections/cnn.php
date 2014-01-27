<?php

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_cnn = "localhost";
$database_cnn = "entreten_illusion";
$rental_cnn = "entreten_rental";
$username_cnn = "entreten";
$password_cnn = "x0tr.u21";
$cnn = mysql_connect($hostname_cnn, $username_cnn, $password_cnn) or trigger_error(mysql_error(),E_USER_ERROR);

?>