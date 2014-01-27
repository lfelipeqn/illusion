<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../../Connections/cnn.php');
	include('../../funciones.php');
	$conect=mysql_select_db($rental_cnn,$cnn);
	$str="UPDATE proyectos SET IdCliente='".$_POST['scliente']."', NombreProyecto='".strtoupper($_POST['nproy'])."', Ciudades='".strtoupper($_POST['ncity'])."', TelefonoContacto='".$_POST['ntelcontac']."', NombreContacto='".strtoupper($_POST['ncontac'])."', 
    EmailContacto='".strtolower($_POST['nmail'])."', FechaEvento='".$_POST['nfechae']."', LugarEvento='".strtoupper($_POST['nlugar'])."', FechaMontaje='".$_POST['nfecham']."', FechaDesmontaje='".$_POST['nfechad']."', 
    Observaciones='".strtoupper($_POST['nobs'])."' WHERE proyectos.IdProyecto=".$_POST['idproy'];
	$update=mysql_query($str,$cnn) or die (mysql_error());
	mysql_close($cnn);
	header("Location: ../rental.php?location=confirmact");
}
?>