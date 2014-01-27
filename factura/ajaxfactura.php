<?php
	session_start();
	include('../Connections/cnn.php');
	include ('../funciones.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	
	$presup=$_POST['proyecto'];
	$sqlpres="SELECT presupuestos.Total, presupuestos.IdProyecto FROM presupuestos WHERE presupuestos.IdProyecto='".$presup."'";
	
	$cltpres=mysql_query($sqlpres,$cnn) or die (mysql_error());
	$rspres=mysql_fetch_assoc($cltpres);
    $resultado = $rspres['Total'];
    mysql_close($cnn);
	echo $resultado;
}
?>