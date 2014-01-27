<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../Connections/cnn.php');
	include('../funciones.php');
	$conect=mysql_select_db($database_cnn,$cnn);
	$fecha=aMySQL($_POST['nfechae']);
	$fecham=aMySQL($_POST['nfecham']);
	$fechad=aMySQL($_POST['nfechad']);
	$str="insert into proyectos(IdCliente, NombreProyecto, Ciudades, TelefonoContacto, NombreContacto, EmailContacto, FechaEvento, LugarEvento, FechaMontaje, FechaDesmontaje, Observaciones, IdUnidad) values('".$_POST['scliente']."','".strtoupper($_POST['nproy'])."','".strtoupper($_POST['ncity'])."','".$_POST['ntelcontac']."','".strtoupper($_POST['ncontac'])."','".strtolower($_POST['nmail'])."','$fecha','".strtoupper($_POST['nlugar'])."','$fecham','$fechad','".strtoupper($_POST['nobs'])."','".$_SESSION['unidad']."')";
	$insert=mysql_query($str,$cnn) or die (mysql_error());
	mysql_close($cnn);
	header("Location: ../inicio.php?location=confirmaproy");
}
?>