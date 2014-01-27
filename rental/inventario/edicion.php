<?php
	session_start();
	include ('../../Connections/cnn.php');
	include ('../../funciones.php');
if(isset($_SESSION['usuario'])){
	$codigo=$_POST['codigo'];
	$categoria=$_POST['scateg'];
	$nombre=strtoupper($_POST['nequ']);
	$marca=strtoupper($_POST['nmarca']);
	$modelo=strtoupper($_POST['nmodel']);
	$serie=strtoupper($_POST['nserie']);
	$fechac=$_POST['fechac'];
	$valorc=aNumero($_POST['vcomer']);
	$valora=aNumero($_POST['valianz']);
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sql="UPDATE inventario SET IdCategoria='".$categoria."', Articulo='".$nombre."', Marca='".$marca."', Modelo='".$modelo."', Serie='".$serie."', Compra='".$fechac."', PrecioComercial='".$valorc."', PrecioAlianza='".$valora."' WHERE inventario.Codigo='".$codigo."'";
	$cltact=mysql_query($sql,$cnn) or die(mysql_error());
	header("Location: ../rental.php?location=confirmaact");
	mysql_close($cnn);
}
?>