<?php
session_start();
if(isset($_SESSION['usuario'])){	
	$prov=$_GET['seguimiento'];
	include ('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	$borra1 = "Delete from proveedores where Identificacion=$prov";
	$borra2 = "Delete from tributariaproveedores where IdProveedor=$prov";
	$borra3 = "Delete from vinculoproveedor where IdProveedor=$prov";
	$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
	$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
	$eborra3=mysql_query($borra3,$cnn) or die(mysql_error());
	echo '
	<div class="cuerpo">
		<h3>Eliminaci&oacute;n de <span>Proveedor</span></h3>
		<p>La Informaci&oacute;n Asociada al Proveedor seleccionado ha sido eliminada en su totalidad</p>
		<p class="p0">A partir del momento, los datos del proveedor no estar&aacute;n disponibles para uso dentro del sistema. Si Lo Desea Puede crear nuevamente el proveedor</p>
</div>';
	mysql_close($cnn);
}
?>