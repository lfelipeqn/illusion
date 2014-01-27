<?php
	session_start();
	include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	$filtro=$_POST['quien'];
	if (!empty($_POST['nident'])){
		$str="Update clientes set Identificacion='".$_POST['nident']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual1=mysql_query($str,$cnn) or die (mysql_error());
	}
	if (!empty($_POST['ndigit'])){
		$str="Update clientes set DV='".$_POST['ndigit']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual2=mysql_query($str,$cnn) or die (mysql_error());
	}
	if (!empty($_POST['ntelcont'])){
		$str="Update clientes set TelefonoContacto='".$_POST['ntelcont']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual4=mysql_query($str,$cnn) or die (mysql_error());
	}
	if (!empty($_POST['ntempresa'])){
		$str="Update clientes set TipoEmpresa='".$_POST['ntempresa']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual6=mysql_query($str,$cnn) or die (mysql_error());
	}
	if (!empty($_POST['nmail'])){
		$str="Update clientes set email='".$_POST['nmail']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual7=mysql_query($str,$cnn) or die (mysql_error());
	}
	if (!empty($_POST['ndir'])){
		$str="Update clientes set Direccion='".$_POST['ndir']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual8=mysql_query($str,$cnn) or die (mysql_error());
	}
	if (!empty($_POST['nfax'])){
		$str="Update clientes set Fax='".$_POST['nfax']."' where (NombreCliente='".$_POST['quien']."')";	
		$actual9=mysql_query($str,$cnn) or die (mysql_error());
	}	
	mysql_close($cnn);
	header("Location: ../inicio.php?location=confirmaactualiza");
}
?>