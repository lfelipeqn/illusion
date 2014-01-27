<?php
session_start();
if(isset($_SESSION['usuario'])){
	$pres=$_GET['seguimiento'];
	include ('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	$sqlverifica="SELECT negocios.IdNegocio, negocios.IdPresupuesto FROM negocios WHERE negocios.IdPresupuesto = '".$pres."'";
	$cltverifica=mysql_query($sqlverifica,$cnn) or die(mysql_error());
	$negocios=mysql_num_rows($cltverifica);
	if($negocios>=1){
		echo '
		<div class="cuerpo">
			<h3>Eliminaci&oacute;n de <span>Presupuesto</span></h3>
			<p>El presupuesto seleccionado <b>NO HA SIDO ELIMINADO</b> debido a que tiene 1 o m&aacute;s Hojas de Negocio Creadas. Para realizar la Eliminaci&oacute;n, por favor Elimine Primero la Hoja de Negocio Asociada</p>
			<p class="p0">Una Vez Eliminado Presupuesto todos los datos asociados al proyecto, tambi&eacute;n ser&aacute;n eliminados del sistema..</p>
	</div>';
	}else{
		$borra1 = "Delete from presupuestos where IdPresupuesto='".$pres."'";
		$borra2 = "Delete from pres_espectaculos where IdPresupuesto='".$pres."'";
		$borra3 = "Delete from pres_eventoscorporativos where IdPresupuesto='".$pres."'";
		$borra4 = "Delete from pres_nuevastecnologias where IdPresupuesto='".$pres."'";
		$borra5 = "Delete from pres_prodejecutivaycampo where IdPresupuesto='".$pres."'";
		$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
		$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
		$eborra3=mysql_query($borra3,$cnn) or die(mysql_error());
		$eborra4=mysql_query($borra4,$cnn) or die(mysql_error());
		$eborra5=mysql_query($borra5,$cnn) or die(mysql_error());
		echo '
	<div class="cuerpo">
		<h3>Eliminaci&oacute;n de <span>Presupuesto</span></h3>
		<p>La Informaci&oacute;n Asociada al Presupuesto seleccionado ha sido eliminada en su totalidad</p>
		<p class="p0">A partir del momento, los datos del presupuesto no estar&aacute;n disponibles para uso dentro del sistema. Si lo Desea Puede crear nuevamente el el presupuesto o crear una nueva versi&oacute;n. Recuerde que requiere de un presupuesto aprobado para continuar con el flujo de trabajo.</p>
	</div>';	
	}
	mysql_close($cnn);
}
?>