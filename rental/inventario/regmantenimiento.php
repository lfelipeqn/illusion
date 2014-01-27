<?php
include ('../Connections/cnn.php');
session_start();
if(isset($_SESSION['usuario'])){
	$codigo=$_GET['seguimiento'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sqlman="UPDATE inventario SET inventario.IdEstado=4 WHERE inventario.codigo=".$codigo;
	$cltmant=mysql_query($sqlman,$cnn) or die(mysql_error());
	
	$fecha=date("Y-m-d H:i:s");
	$sqlhist="INSERT INTO historial (Codigo, IdTipo, Fecha) VALUES ('".$codigo."','3','".$fecha."')";
	$clthist=mysql_query($sqlhist,$cnn) or die(mysql_error());
	header("Location: ../rental/rental.php?location=confmant");
}
?>