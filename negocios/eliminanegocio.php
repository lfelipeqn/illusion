<?php
if(isset($_SESSION['usuario'])){
	$nego=$_GET['negocio'];
	include ('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	$sqlverifica="SELECT negocios.IdNegocio, negocios.IdProyecto FROM negocios WHERE negocios.IdNegocio = '".$nego."'";
	$cltverifica=mysql_query($sqlverifica,$cnn) or die(mysql_error());
	$rsnegocios=mysql_fetch_assoc($cltverifica);
	$sqlproducciones="SELECT produccion.IdProduccion, produccion.IdCliente, produccion.IdProyecto FROM produccion WHERE produccion.IdProyecto ='".$rsnegocios['IdProyecto']."'";
	$cltproduccion=mysql_query($sqlproducciones,$cnn) or die(mysql_error());
	$totalproducciones=mysql_num_rows($cltproduccion);
	if($totalproducciones>=1){
		echo '
		<div class="cuerpo">
			<h3>Eliminaci&oacute;n de <span>Negocio</span></h3>
			<p>El negocio seleccionado <b>NO HA SIDO ELIMINADO</b> debido a que tiene 1 Hoja de producci&oacute;n creada. Para realizar la Eliminaci&oacute;n, por favor Elimine Primero la Hoja de Producci&oacute;n Asociada</p>
			<p class="p0">Una Vez Eliminada la Hoja de Negocio todos los datos asociados a este y la Hoja de Producci&oacute;n relacionada, tambi&eacute;n ser&aacute;n eliminados del sistema..</p>
	</div>';
	}else{
		$borra1 = "Delete from negocios where IdNegocio='".$nego."'";
		$borra2 = "Delete from negocios_plazo where IdNegocio='".$nego."'";
		$borra3 = "Delete from negocios_tipo where IdNegocio='".$nego."'";
		$eborra1=mysql_query($borra1,$cnn) or die(mysql_error());
		$eborra2=mysql_query($borra2,$cnn) or die(mysql_error());
		$eborra3=mysql_query($borra3,$cnn) or die(mysql_error());
		echo '
	<div class="cuerpo">
		<h3>Eliminaci&oacute;n de <span>Negocio</span></h3>
		<p>La Informaci&oacute;n Asociada al Negocio seleccionado ha sido eliminada en su totalidad</p>
		<p class="p0">A partir del momento, los datos del negocio no estar&aacute;n disponibles para uso dentro del sistema. Si lo Desea Puede crear o aprobar nuevamente el presupuesto y posteriormente crear de nuevo la Hoja de Negocio. Recuerde que requiere de un presupuesto aprobado para continuar con el flujo de trabajo.</p>
	</div>';	
	}
	mysql_close($cnn);
}
?>