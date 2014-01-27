<?php
	include ('Connections/cnn.php');
	session_start();
if(isset($_SESSION['usuario'])){
	$idprod=$_GET['seguimiento'];

	$connect=mysql_select_db($database_cnn,$cnn);
	$sql="SELECT produccion.IdProduccion, produccion.IdCliente, produccion.IdProyecto, produccion.IdPresupuesto, produccion.GranTotal, produccion.IdUnidad FROM produccion where IdProduccion='".$idprod."'";

	$resultado=mysql_query($sql,$cnn) or die(mysql_error());
	$rsprod=mysql_fetch_assoc($resultado);

	$actualiza="UPDATE produccion SET Aprobada='1', UsuarioAprueba='".$_SESSION['usuario']."', FechaAprobada='".date('Y-m-d')."' WHERE IdProduccion='".$idprod."'";
	$ejecutar=mysql_query($actualiza,$cnn) or die(mysql_error());
    
    $estadooc="UPDATE orden_compra SET IdEstadoOrden=1 WHERE IdProduccion=".$idprod;
    $clestadooc=mysql_query($estadooc,$cnn) or die(mysql_error());

	if ($ejecutar){	
			$cadcliente="select clientes.IdCliente, clientes.NombreCliente from clientes where IdCliente='".$rsprod['IdCliente']."'";
			$cadproyecto="select proyectos.IdProyecto, proyectos.NombreProyecto from proyectos where IdProyecto='".$rsprod['IdProyecto']."'";

			$cltcliente=mysql_query($cadcliente,$cnn) or die(mysql_error());
			$cltproyecto=mysql_query($cadproyecto,$cnn) or die(mysql_error());
			$rscliente=mysql_fetch_assoc($cltcliente);
			$rsproyecto=mysql_fetch_assoc($cltproyecto);
			$nombrecliente=strtoupper($rscliente['NombreCliente']);
			$nombreproyecto=strtoupper($rsproyecto['NombreProyecto']);

			
			$mensaje="La Hoja de Producci&oacute;n No.".$idprod." del proyecto ".$nombreproyecto." correspondiente al cliente ".$nombrecliente." Ha Sido Aprobada de Forma Exitosa";
			
         Alerta('ApruebaProduccion','Nueva Hoja de Producción Finalizada',$mensaje,$rsprod['IdUnidad']);

			echo '
			<div class="cuerpo">
				<h3>Finalizaci&oacute;n de Hoja de <span>Producci&oacute;n</span></h3>
					<p>La Hoja de Producci&oacute;n Seleccionada Ha Sido Finalizada y Aprobada Satisfactoriamente. Ahora Puede Proceder con la Generaci&oacute;n de las &Oacute;rdenes de Compra</p>
			</div>';			
	}
	mysql_close($cnn);
}

?>