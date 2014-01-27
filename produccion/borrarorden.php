<?php
session_start();
if(isset($_SESSION['usuario'])){
	$norden=$_GET['seguimiento'];
	$proveedor=$_GET['proveedor'];
	include ('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	$sqlorden="select IdOrden from orden_compra where IdOrden='".$norden."' AND IdProveedor='".$proveedor."'";
	$cltorden=mysql_query($sqlorden,$cnn) or die(mysql_error());
	$rsorden=mysql_fetch_assoc($cltorden);
	
	
	$borra1 = "UPDATE orden_compra SET IdEstadoOrden=4 WHERE IdOrden='".$norden."' AND IdProveedor='".$proveedor."'";
	//$borra2 = "Delete from detalle_compra where IdOrden='".$rsorden['IdOrden']."'";
	$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
	//$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
	echo '
	<div class="cuerpo">
		<h3>Anulaci&oacute;n de <span>Orden de Compra</span></h3>
		<p>La Orden de Compra Seleccionada ha sido <b>ANULADA</b> de Forma exitosa</p>
		<p class="p0">A partir del momento, los datos de esta orden de compra no son v&aacute; para uso. Si lo Desea puede crear una nueva Orden de Compra</p>
</div>';
	mysql_close($cnn);
}
?>