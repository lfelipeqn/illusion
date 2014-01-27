<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../Connections/cnn.php');
	//include('../funciones.php');
	$conect=mysql_select_db($rental_cnn,$cnn);
	$evento=$_GET['codigo'];
	$str="UPDATE eventos SET Finalizado='1' WHERE eventos.IdEvento='$evento'";
    echo $str;
	$update=mysql_query($str,$cnn) or die (mysql_error());
	mysql_close($cnn);
    if ($update){
        header("Location: rental.php?location=confinaliza");    
    }
}

?>