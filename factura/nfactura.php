<?php
	session_start();
	include('../Connections/cnn.php');
	include ('../funciones.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	
	$nfactura=$_POST['nfact'];
	$femis=aMySQL($_POST['femi']);
	$fvenc=aMySQL($_POST['fven']);
	$idcliente=$_POST['ncliente'];
	$idproyecto=$_POST['pproy'];
	$subt=aNumero($_POST['subt']);
	$iva=aNumero($_POST['iva']);
	$total=aNumero($_POST['tot']);
	
	
	$str="insert into facturas(Factura, IdProyecto, IdCliente, FechaEmision, FechaVencimiento, Subtotal, Iva, Total) values ('".$nfactura."','".$idproyecto."','".$idcliente."','".$femis."','".$fvenc."','".$subt."','".$iva."','".$total."')";
	$insert=mysql_query($str,$cnn) or die (mysql_error());
	mysql_close($cnn);
	header("Location: ../inicio.php?location=confact");
}
?>