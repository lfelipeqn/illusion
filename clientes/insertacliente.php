<?php
	session_start();
	include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	$unidad=$_SESSION['unidad'];
	
	$sql="SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion FROM clientes WHERE ((clientes.Identificacion =".$_POST['nident'].") OR (clientes.NombreCliente='".$_POST['ncliente']."')) ORDER BY clientes.IdCliente ASC";
	$cltcliente=mysql_query($sql,$cnn) or die(mysql_error());
	$totfilas=mysql_num_rows($cltcliente);
	if($totfilas>=1){
		$rscliente=mysql_fetch_assoc($cltcliente);
		$clienteid=$rscliente['IdCliente'];
		$sqlunidades="SELECT clientes_unidades.IdRegistro, clientes_unidades.IdCliente, clientes_unidades.IdUnidad FROM clientes_unidades WHERE clientes_unidades.IdCliente = ".$clienteid." AND clientes_unidades.IdUnidad = ".$unidad;
		$cltverif=mysql_query($sqlunidades,$cnn) or die(mysql_error());
		$totaluni=mysql_num_rows($cltverif);
		if($totaluni<1){
			$struni="INSERT INTO clientes_unidades(IdCliente, IdUnidad) VALUES (".$clienteid.",".$unidad.")";
			$insertuni=mysql_query($struni,$cnn) or die(mysql_error());
		}
	}else{
		$str="insert into clientes(NombreCliente, Identificacion, DV, TelefonoContacto, TipoEmpresa, email, Direccion, Fax) values('".strtoupper($_POST['ncliente'])."','".$_POST['nident']."','".$_POST['ndigit']."','".$_POST['ntelcont']."','".$_POST['ntempresa']."','".$_POST['nmail']."','".strtoupper($_POST['ndir'])."','".$_POST['nfax']."')";
		$insert=mysql_query($str,$cnn) or die (mysql_error());
		$idcliente=mysql_insert_id();
		$struni="INSERT INTO clientes_unidades(IdCliente, IdUnidad) VALUES (".$idcliente.",".$unidad.")";
		$insertuni=mysql_query($struni,$cnn) or die(mysql_error());
	}
	header("Location: ../inicio.php?location=confirma");
	mysql_close($cnn);
}
?>