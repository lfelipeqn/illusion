<?php
session_start();
if(isset($_SESSION['usuario'])){
	$prod=$_GET['seguimiento'];
	include ('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	$borra0 = "Delete from produccion where IdProduccion='".$prod."'";
	$borra1 = "Delete from produccion_ec where IdProduccion='".$prod."'";
	$borra2 = "Delete from produccion_esl where IdProduccion='".$prod."'";
	$borra3 = "Delete from produccion_gp where IdProduccion='".$prod."'";
	$borra4 = "Delete from produccion_im where IdProduccion='".$prod."'";
	$borra5 = "Delete from produccion_nt where IdProduccion='".$prod."'";
	$borra6 = "Delete from produccion_pr where IdProduccion='".$prod."'";
	$eborra0=mysql_query($borra0,$cnn) or die(mysql_error());
	$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
	$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
	$eborra3=mysql_query($borra3,$cnn) or die(mysql_error());
	$eborra4=mysql_query($borra4,$cnn) or die(mysql_error());
	$eborra5=mysql_query($borra5,$cnn) or die(mysql_error());
	$eborra6=mysql_query($borra6,$cnn) or die(mysql_error());
	echo '
	<div class="cuerpo">
		<h3>Eliminaci&oacute;n de Hoja<span>de Producci&oacute;n</span></h3>
		<p>La Informaci&oacute;n Asociada a la Hoja de Producci&oacute;n seleccionada ha sido completamente eliminada de la base de Datos</p>
		<p>A partir del momento, los datos de esta hoja de Producci&oacute;n no estar&aacute;n disponibles para uso dentro del sistema. Si lo Desea Puede crear nuevamente el la hoja de producci&oacute;n.</p>
</div>';
	mysql_close($cnn);
}
?>