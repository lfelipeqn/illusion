<?php
	//session_start();
	include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$idpresupuesto=$_GET['seguimiento'];
	$connect=mysql_select_db($database_cnn,$cnn);
	$sql="SELECT presupuestos.IdPresupuesto, presupuestos.Presupuesto, presupuestos.`Version`, presupuestos.IdCliente, presupuestos.IdProyecto, presupuestos.FechaPresentacion, presupuestos.Presentadopor, presupuestos.TipoCliente, presupuestos.FormaPago, presupuestos.SubEspectaculos, presupuestos.SubEventosCorp, presupuestos.SubNuevasTec, presupuestos.SubProduccion, presupuestos.Subtotal, presupuestos.Descuento, presupuestos.Total, presupuestos.KnowHow, presupuestos.Aprobabo, presupuestos.FechaAprobacion, presupuestos.IdUnidad from presupuestos where presupuestos.IdPresupuesto='".$idpresupuesto."'";
	$resultado=mysql_query($sql,$cnn) or die(mysql_error());
	$rspresupuesto=mysql_fetch_assoc($resultado);
	$idproyecto=$rspresupuesto['IdProyecto'];
	$idcliente=$rspresupuesto['IdCliente'];
	$verif="SELECT negocios.IdNegocio, negocios.IdProyecto FROM negocios WHERE negocios.IdProyecto =".$idproyecto;
	$sqlver=mysql_query($verif,$cnn) or die(mysql_error());
	$tneg=mysql_num_rows($sqlver);
	if($tneg>=1){
		echo '<div class="cuerpo">
				<h3>Presupuesto <span>NO APROBADO</span></h3>
					<p>La Aprobaci&oacute;n de Presupuesto solicitado no ha sido realizada debido a que existe un negocio creado con un presupuesto anterior para el mismo proyecto. Para continuar, Elimine la Informaci&oacute;n del Negocio Existente e Intente de nuevo.</p>
			</div>';
	}else{
		$noaprueba="UPDATE presupuestos SET Aprobabo=0 WHERE IdProyecto='".$idproyecto."'";
		$sqlno=mysql_query($noaprueba,$cnn) or die(mysql_error());
		$actualiza="UPDATE presupuestos SET Aprobabo=1, FechaAprobacion='".date('Y-m-d')."' WHERE IdPresupuesto='".$idpresupuesto."'";
		$ejecutar=mysql_query($actualiza,$cnn) or die(mysql_error());
		if ($ejecutar){	
			$cadcliente="select clientes.IdCliente, clientes.NombreCliente from clientes where IdCliente='".$idcliente."'";
			$cadproyecto="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, unidades.IdUnidad, unidades.Unidad FROM proyectos INNER JOIN unidades ON proyectos.IdUnidad = unidades.IdUnidad where IdProyecto='".$idproyecto."'";
			$cltcliente=mysql_query($cadcliente,$cnn) or die(mysql_error());
			$cltproyecto=mysql_query($cadproyecto,$cnn) or die(mysql_error());
			$rscliente=mysql_fetch_assoc($cltcliente);
			$rsproyecto=mysql_fetch_assoc($cltproyecto);
			$nombrecliente=strtoupper($rscliente['NombreCliente']);
			$nombreproyecto=strtoupper($rsproyecto['NombreProyecto']);
				
			$mensaje=strtoupper($rsproyecto['Unidad']).": Ha realizado la aprobaci&oacute;n del presupuesto ".strtoupper($idpresupuesto)." para el proyecto ".$nombreproyecto." de ".$nombrecliente;
         
            Alerta('ConfirmaPresupuesto','Nuevo Presupuesto Aprobado',$mensaje,$rspresupuesto['IdUnidad']);

			//mysql_close($cnn);

			echo '<div class="cuerpo">
					<h3>Aprobaci&oacute;n de <span>Presupuestos</span></h3>
						<p>Se ha Aprobado el Presupuesto Seleccionado, Otros presupuestos no pueden ser utilizados en procedimientos futuros</p>
				</div>';	
		}
	}
}
?>