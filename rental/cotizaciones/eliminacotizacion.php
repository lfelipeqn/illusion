<?php
//session_start();
if(isset($_SESSION['usuario'])){	
	$cotiz=$_GET['seguimiento'];
	include ('../Connections/cnn.php');
	$connect=mysql_select_db($rental_cnn,$cnn);
	$borra1 = "Delete from cotizacion where IdCotizacion=$cotiz";
	$borra2 = "Delete from cotizacion_detalle where IdCotizacion=$cotiz";
    $borra3 = "Delete from cotizacion_proveedores where IdCotizacion=$cotiz";
    $borra4 = "Delete from cotizacion_conceptos where IdCotizacion=$cotiz";
	$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
	$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
    $eborra3=mysql_query($borra3,$cnn) or die(mysql_error());    
    $eborra4=mysql_query($borra4,$cnn) or die(mysql_error());
	echo '
	<div class="cuerpo">
		<h3><span>Eliminaci&oacute;n de </span>Cotizaci&oacute;n</h3>
		<p>La Informaci&oacute;n Asociada a la Cotizacion seleccionada ha sido eliminada en su totalidad</p>
		<p>A partir del momento, los datos de la cotizacion seleccionada no estar&aacute;n disponibles para uso dentro del sistema. Si Lo Desea Puede crear nuevamente la cotizacion</p>
</div>';
	mysql_close($cnn);
}

?>