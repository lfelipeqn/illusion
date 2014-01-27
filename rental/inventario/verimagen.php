<?php
	include('../../Connections/cnn.php');
	$codigo=$_GET['codigo'];
//	$tabla=$_GET['tabla'];

	$conecta=mysql_select_db($rental_cnn,$cnn);
	$sql="SELECT inventario.Codigo, inventario.Imagen FROM inventario WHERE Codigo='".$codigo."'";	
	$cltimagen=mysql_query($sql,$cnn) or die(mysql_error());
	$rsimagen=mysql_fetch_assoc($cltimagen);
	$imagen=$rsimagen['Imagen'];
//		header("Content-Type: image/jpeg");
	echo $imagen;

?>