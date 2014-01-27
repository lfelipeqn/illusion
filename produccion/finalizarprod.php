<?php
session_start();
include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$idprod=$_GET['seguimiento'];
	$connect=mysql_select_db($database_cnn,$cnn);
	$sql="SELECT produccion.IdProduccion, produccion.IdCliente, produccion.IdProyecto, produccion.IdPresupuesto, produccion.TotalTerceros, produccion.TotalESL, produccion.GranTotal, produccion.IdUnidad FROM produccion where produccion.IdProduccion='".$idprod."'";
	
	$resultado=mysql_query($sql,$cnn) or die(mysql_error());
	$rsprod=mysql_fetch_assoc($resultado);
	$total=mysql_num_rows($resultado);
	
	$sqldat="SELECT presupuestos.IdPresupuesto, presupuestos.Total, presupuestos.Aprobabo from presupuestos where ((presupuestos.Aprobabo=1) AND (presupuestos.IdPresupuesto='".$rsprod['IdPresupuesto']."'))";
		
	$resdat=mysql_query($sqldat,$cnn) or die(mysql_error());
	$presup=mysql_num_rows($resdat);
	if($presup<1){
		echo '
			<div class="cuerpo">
					<h3>Finalizaci&oacute;n de Hoja de <span>Producci&oacute;n</span></h3>
						<p>La Hoja de Producci&oacute;n Seleccionada <b>NO HA SIDO FINALIZADA</b> El presupuesto Seleccionado no Existe o ha cambiado. Por favor Verifique</p>
			</div>';
	}else{
		/*$rspresup=mysql_fetch_assoc($resdat);
		$totalpres=$rspresup['Total'];
		$totalprod=$rsprod['GranTotal'];
		//$totalesl=$rsprod['TotalESL'];
		//$totalter=$rsprod['TotalTerceros'];
		//$rentESL=(($totalpres-$totalesl)/$totalpres);
		//$rentTER=(($totalpres-$totalter)/$totalpres);
		$rent=(($totalpres-$totalprod)/$totalpres);
			
		$sqlrent="UPDATE produccion SET Rentabilidad=".$rent." WHERE IdProduccion='".$idprod."'";
		$cltrent=mysql_query($sqlrent,$cnn) or die(mysql_error());*/
		
		$actualiza="UPDATE produccion SET Finalizada='1', UsuarioFinaliza='".$_SESSION['usuario']."', FechaFinaliza='".date('Y-m-d')."' where IdProduccion='".$idprod."'";
		$ejecutar=mysql_query($actualiza,$cnn) or die(mysql_error());
			
		if($rent>=0.45){
			$apruebap="UPDATE produccion SET Aprobada=1, UsuarioAprueba='".$_SESSION['usuario']."', FechaAprobada='".date('Y-m-d')."' WHERE IdProduccion='".$idprod."'";
			$cltaprueba=mysql_query($apruebap,$cnn) or die(mysql_error());	
			$cadcliente="select clientes.IdCliente, clientes.NombreCliente from clientes where IdCliente='".$rsprod['IdCliente']."'";
			$cadproyecto="select proyectos.IdProyecto, proyectos.NombreProyecto from proyectos where IdProyecto='".$rsprod['IdProyecto']."'";
		
			$cltcliente=mysql_query($cadcliente,$cnn) or die(mysql_error());
			$cltproyecto=mysql_query($cadproyecto,$cnn) or die(mysql_error());
			$rscliente=mysql_fetch_assoc($cltcliente);
			$rsproyecto=mysql_fetch_assoc($cltproyecto);
			$nombrecliente=strtoupper($rscliente['NombreCliente']);
			$nombreproyecto=strtoupper($rsproyecto['NombreProyecto']);
					
			
			$mensaje="La Hoja de Producción No.".$idprod." del proyecto ".$nombreproyecto." correspondiente al cliente ".$nombrecliente." Ha Sido Aprobada";	
			
			Alerta('ConfirmaProduccion','Nueva Hoja de Producci&oacute;n Finalizada', $mensaje, $_SESSION['unidad']);			
			
			echo '
			<div class="cuerpo">
				<h3>Finalizaci&oacute;n de Hoja de <span>Producci&oacute;n</span></h3>
				<p>La Hoja de Producci&oacute;n Seleccionada Ha Sido Finalizada y Aprobada Satisfactoriamente. Ahora Puede Proceder con la Generaci&oacute;n de las &Oacute;rdenes de Compra</p>
			</div>';
		}else{
			$apruebap="UPDATE produccion SET Aprobada=0 WHERE IdProduccion='".$idprod."'";
			$cltaprueba=mysql_query($apruebap,$cnn) or die(mysql_error());	
			$cadcliente="select clientes.IdCliente, clientes.NombreCliente from clientes where IdCliente='".$rsprod['IdCliente']."'";
			$cadproyecto="select proyectos.IdProyecto, proyectos.NombreProyecto from proyectos where IdProyecto='".$rsprod['IdProyecto']."'";
	
			$cltcliente=mysql_query($cadcliente,$cnn) or die(mysql_error());
			$cltproyecto=mysql_query($cadproyecto,$cnn) or die(mysql_error());
			$rscliente=mysql_fetch_assoc($cltcliente);
			$rsproyecto=mysql_fetch_assoc($cltproyecto);
			$nombrecliente=strtoupper($rscliente['NombreCliente']);
			$nombreproyecto=strtoupper($rsproyecto['NombreProyecto']);
				
				
				
			$mensaje="La Hoja de Producción No. ".$rsprod['IdProduccion']." del proyecto ".$nombreproyecto." correspondiente al cliente ".$nombrecliente.". Fue finalizada con Una Rentabilidad del ".($rent*100)."%, y No Ha sido Aprobada. Es Necesario Realizar la Aprobación para que la Hoja de Producción quede disponible. Se ha enviado una Notificación a los Administradores";
			
			Alerta('ApruebaProduccion','Hoja de Producción con Baja Rentabilidad', $mensaje, $_SESSION['unidad']);			
			
			echo '
			<div class="cuerpo">
						<h3>Finalizaci&oacute;n de Hoja de <span>Producci&oacute;n</span></h3>
						<p>La Hoja de Producci&oacute;n Seleccionada Ha Sido Finalizada</p>
						<p>La Hoja de Producci&oacute;n '.$rsprod['IdProduccion'].' <b>NO FUE APROBADA</b> debido a una <b>BAJA RENTABILIDAD</b>. Para Continuar, la Hoja de Producci&oacute;n debe Ser Aprobada por un Administrador.</p>
			</div>';
		}
	}
	mysql_close($cnn);
}
?>