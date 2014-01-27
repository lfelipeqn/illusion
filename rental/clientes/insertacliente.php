<?php
	session_start();
	include('../../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($rental_cnn,$cnn);	
	$str="insert into clientes(Identificacion, NombreCliente, Digito, Telefono, Extension, Email, Direccion, Fax, ExtensionFax) values('".$_POST['nident']."','".strtoupper($_POST['ncliente'])."','".$_POST['ndigit']."','".$_POST['ntelcont']."','".$_POST['next']."','".strtolower($_POST['nmail'])."','".strtoupper($_POST['ndir'])."','".$_POST['nfax']."','".$_POST['nexfax']."')";
	$insert=mysql_query($str,$cnn) or die (mysql_error());
	header("Location: ../rental.php?location=confcliente");
	mysql_close($cnn);
}
?>