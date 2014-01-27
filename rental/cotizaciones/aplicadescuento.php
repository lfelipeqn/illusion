<?php
	session_start();
	include '../../Connections/cnn.php';
	include '../../funciones.php';

if(isset($_SESSION['usuario'])){
    $cotizacion=$_GET['seguimiento'];
    $descuento=$_GET['descuento'];
    $conect=mysql_select_db($rental_cnn,$cnn);
	
    $sqldesc="UPDATE cotizacion SET descuento=$descuento WHERE IdCotizacion=$cotizacion";
    $cltdesc=mysql_query($sqldesc,$cnn) or die(mysql_error());
	
    mysql_close($cnn);
    header("Location: ../rental.php?location=confdesc");
}
?>