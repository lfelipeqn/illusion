<?php
	session_start();
	include('../../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($rental_cnn,$cnn);	
	$str="UPDATE clientes SET NombreCliente='".strtoupper($_POST['ncliente'])."', Digito='".$_POST['ndigit']."', Telefono='".$_POST['ntelcont']."', Extension='".$_POST['next']."', Email='".strtolower($_POST['nmail'])."', Direccion='".strtoupper($_POST['ndir'])."', Fax='".$_POST['nfax']."', ExtensionFax='".$_POST['nexfax']."' WHERE clientes.Identificacion='".$_POST['nident']."'";
	$insert=mysql_query($str,$cnn) or die (mysql_error());
	header("Location: ../rental.php?location=confactcliente");
	mysql_close($cnn);
}
?>