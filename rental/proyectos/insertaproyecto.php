<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../../Connections/cnn.php');
	include('../../funciones.php');
	$conect=mysql_select_db($rental_cnn,$cnn);
	$str="insert into proyectos(IdCliente, NombreProyecto, Ciudades, TelefonoContacto, NombreContacto, EmailContacto, FechaEvento, LugarEvento, FechaMontaje, FechaDesmontaje, Observaciones) values('".$_POST['scliente']."','".strtoupper($_POST['nproy'])."','".strtoupper($_POST['ncity'])."','".$_POST['ntelcontac']."','".strtoupper($_POST['ncontac'])."','".strtolower($_POST['nmail'])."','".$_POST['nfechae']."','".strtoupper($_POST['nlugar'])."','".$_POST['nfecham']."','".$_POST['nfechad']."','".strtoupper($_POST['nobs'])."')";
	$insert=mysql_query($str,$cnn) or die (mysql_error());
	mysql_close($cnn);
	header("Location: ../rental.php?location=confirmaproy");
}
?>