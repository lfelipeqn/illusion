<?php

if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	include('class.ezpdf.php');

	$idproyecto=$_GET['proyecto'];
	$connect=mysql_select_db($database_cnn,$cnn);

	$opciones = array(
					'shaded'=>0,
					'showHeadings'=>0,
                	'xOrientation'=>'center',
                	'width'=>uPDF(18),
					'fontSize'=> 8,
					'cols'=>array(
								  '2'=>array('justification'=>'right'),
								  '4'=>array('justification'=>'right')
								  )
					);

	$optablas = array(
					  	'showHeadings'=>1,
					  	'shaded'=>0,
						'shadeCol'=>array(0.9,0.9,0.9),
						'xOrientation'=>'center',
						'width'=>uPDF(18),
						'fontSize'=> 8,
						'cols'=>array(
								  'Cantidad'=>array('justification'=>'right'),
								  'Días'=>array('justification'=>'right'),
								  'Valor Unitario'=>array('justification'=>'right'),
								  'Valor Total'=>array('justification'=>'right')
								  )
					);

	$opsubt = array (
					 	'showHeadings'=>0,
						'xOrientation'=>'center',
						'xPos'=>uPDF(18.2),
						'fontSize'=> 8,
						'cols'=>array(
								  '1'=>array('justification'=>'left'),
								  '2'=>array('justification'=>'right'),
								  )
					);

	$optotal = array (
					  	'shaded'=>0,
					 	'showHeadings'=>0,
						'xOrientation'=>'center',
						'xPos'=>uPDF(17.2),
						'fontSize'=> 8,
						'cols'=>array(
								  '1'=>array(
											 'justification'=>'left',
											 ),
								  '2'=>array('justification'=>'right'),
								  )
					);

	$opnota= array(
				   'aleft'=>70,
				   'justification'=>'left'
				   );

	$sql="SELECT clientes.NombreCliente AS NombreCliente, proyectos.IdProyecto AS IdProyecto, proyectos.IdCliente AS IdCliente, proyectos.NombreProyecto AS NombreProyecto, proyectos.Ciudades AS Ciudades, proyectos.TelefonoContacto AS TelefonoContacto, proyectos.NombreContacto AS NombreContacto, proyectos.FechaEvento AS FechaEvento, proyectos.LugarEvento AS LugarEvento, proyectos.FechaMontaje AS FechaMontaje, proyectos.FechaDesmontaje AS FechaDesmontaje, proyectos.Observaciones AS Observaciones, presupuestos.IdPresupuesto AS IdPresupuesto, presupuestos.Presupuesto AS Presupuesto, presupuestos.Version AS Version, presupuestos.Subtotal AS Subtotal, presupuestos.Descuento AS Descuento, presupuestos.KnowHow AS KnowHow, presupuestos.Total AS Total, presupuestos.Aprobabo AS Aprobado, presupuestos.FechaAprobacion AS FechaAprobacion, tipoempresa.TipoEmpresa AS TipoEmpresa, usuarios.Nombre AS Presentadopor, proyectos.IdUnidad 
    FROM clientes 
    INNER JOIN proyectos ON clientes.IdCliente = proyectos.IdCliente
    INNER JOIN presupuestos ON proyectos.IdProyecto = presupuestos.IdProyecto
    INNER JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo
    INNER JOIN usuarios ON presupuestos.Presentadopor = usuarios.usuario
    INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad 
    WHERE proyectos.IdProyecto= '".$idproyecto."' AND presupuestos.Aprobabo='1' 
    GROUP BY clientes.NombreCliente, proyectos.IdProyecto, proyectos.IdCliente, proyectos.NombreProyecto, proyectos.Ciudades, proyectos.TelefonoContacto, proyectos.NombreContacto, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones, presupuestos.IdPresupuesto, presupuestos.Presupuesto, presupuestos.Version, presupuestos.Subtotal, presupuestos.Descuento, presupuestos.KnowHow, presupuestos.Total, presupuestos.Aprobabo, presupuestos.FechaAprobacion, tipoempresa.TipoEmpresa, usuarios.Nombre";

	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$total=mysql_num_rows($consulta);

	if ($total<1){
		echo '<div id="content">
				<div class="indent1">
					<h3>Brief de <span>Proyectos</span></h3>
					<p class="p0">El Proyecto no tiene un presupuesto aprobados y no es posible ejecutar el Brief. Para Ejecutar el Brief El Proyecto debe Tener un Presupuesto Aprobado. Solicite la Aprobaci&oacute;n del presupuesto e intente nuevamente</p>
					<br />
				</div>
			</div>';
	}else{
		$pdf =& new Cezpdf('letter');
		$pdf -> selectFont('../fonts/courier.afm');
		$pdf -> ezSetCmMargins(1,1,2,1);
		while ($rs=mysql_fetch_assoc($consulta)){
			if ($rs['FechaEvento']==0){
				$fechaevt='';
			}else{
				$fechaevt=ConvFecha($rs['FechaEvento']);
			}

			if ($rs['FechaAprobacion']==0){
				$fechaapr='';
			}else{
				$fechaapr=ConvFecha($rs['FechaAprobacion']);
			}
            
			if ($rs['FechaMontaje']==0){
				$fecham='';
			}else{
				$fecham=ConvFecha($rs['FechaMontaje']);
			}

			if ($rs['FechaDesmontaje']==0){
				$fechad='';
			}else{
				$fechad=ConvFecha($rs['FechaDesmontaje']);
			}

		$datos = array(
				   array(
						 '1'=>'PRESUPUESTO No.:',
						 '2'=>$rs['Presupuesto'],
						 '3'=>'VERSION No.:',
						 '4'=>$rs['Version']
						),
				   array(
						 '1'=>'CLIENTE:',
						 '2'=>$rs['NombreCliente'],
						 '3'=>'CIUDADES:',
						 '4'=>$rs['Ciudades']
						),

				   array(
						 '1'=>'CONTACTO:',
						 '2'=>$rs['NombreContacto'],
						 '3'=>'PRESENTADO POR:',
						 '4'=>$rs['Presentadopor']
						),

				   array(
						 '1'=>'TELEFONO DE CONTACTO:',
						 '2'=>$rs['TelefonoContacto'],
						 '3'=>'FECHA EVENTO:',
						 '4'=>$fechaevt
						),

				   array(
						 '1'=>'TIPO DE CLIENTE:',
						 '2'=>$rs['TipoEmpresa'],
						 '3'=>'LUGAR DEL EVENTO:',
						 '4'=>$rs['LugarEvento']
						),

				   array(
						 '1'=>'PROYECTO:',
						 '2'=>$rs['NombreProyecto'],
						 '3'=>'FECHA DE MONTAJE:',
						 '4'=>$fecham
						),

				   array(
						 '1'=>'FECHA DE APROBACIÓN:',
						 '2'=>$fechaapr,
						 '3'=>'FECHA DE DESMONTAJE:',
						 '4'=>$fechad
						)
				 );

		$totales= array(
						array(
						 '1'=>'SUBTOTAL PROYECTO:',
						 '2'=>"$ ".number_format($rs['Subtotal'],2)),
						array(
						 '1'=>'DESCUENTO ESPECIAL:',
						 '2'=>"$ ".number_format($rs['Descuento'],2)),
						array(
						 '1'=>'KNOW HOW:',
						 '2'=>"$ ".number_format($rs['KnowHow'],2)),
						array(
						 '1'=>'SUBTOTAL CON DCTO:',
						 '2'=>"$ ".number_format($rs['Total'],2))
						);

		$obs[] = array(
					'1'=>strtoupper($rs['Observaciones'])
					);

		$idpresupuesto=$rs['IdPresupuesto'];
		$unidad=$rs['IdUnidad'];
    }

	switch($unidad){
		case '1':
			$pdf->addJpegFromFile('images/corporativo.jpg',uPDF(2),uPDF(24.5),100,80);
			break;
		case '2':
			$pdf->addJpegFromFile('images/digital.jpg',uPDF(2),uPDF(24.5),100,80);
			break;
		case '3':
			$pdf->addJpegFromFile('images/agora.jpg',uPDF(2),uPDF(24.5),100,80);
			break;
		case '4':
			$pdf->addJpegFromFile('images/saxo.jpg',uPDF(2),uPDF(24.5),100,80);
			break;
		case '5':
			$pdf->addJpegFromFile('images/envivo.jpg',uPDF(2),uPDF(24.5),100,80);
			break;
	}

	$pdf->addText(uPDF(14.9),uPDF(24.8),8,"ENTRETENIMIENTO SIN LIMITES LTDA");
	$pdf->addText(uPDF(17.9),uPDF(24.5),8,"NIT 900080794-6");
	$pdf->ezText("\n\n\n\n\n\n\n\n\n");

	$pdf->filledRectangle(uPDF(2.11),uPDF(22.8),uPDF(18),uPDF(1.4));
	$pdf->setColor(255,255,255);
	$pdf->addText(uPDF(9.3),uPDF(23.55),20,"  B  R  I  E  F");
	$pdf->addText(uPDF(9.75),uPDF(23.1),10,"DATOS GENERALES");
	$pdf->setColor(0,0,0);
	$pdf->ezTable($datos,'','',$opciones);
	$pdf->ezText("\n");
	$pdf->ezTable($obs,'','OBSERVACIONES',$opciones);

	$pdf->ezText("\n");
	$sql1="SELECT * FROM procesos ORDER BY IdProceso ASC";				
	$resultado=mysql_query($sql1,$cnn) or die(mysql_error());
	$subt=0;

	while($rs1=mysql_fetch_assoc($resultado)){
			$sql3="SELECT * FROM ".$rs1['NombreTabla']." WHERE (IdPresupuesto='".$idpresupuesto."')";
			$detalle=mysql_query($sql3,$cnn) or die(mysql_error());
			$parcial=0;

			if (mysql_num_rows($detalle)>=1){
			while ($rs3=mysql_fetch_assoc($detalle)){
				$contenido[]= array(
									'Descripción'=>$rs3['Descripcion'],
									'Cantidad'=>number_format($rs3['Cantidad'],0),
									'Días'=>number_format($rs3['Dias'],0)/*,
									'Valor Unitario'=>"$ ".number_format($rs3['VrUnitario'],2),
									'Valor Total'=>"$ ".number_format($rs3['VrTotal'],2)*/
									);

				$parcial+=$rs3['VrTotal'];
			}

			$pdf->ezTable($contenido,'','REQUERIMIENTOS',$optablas);
			unset($contenido);
			}
			$subt+=$parcial;
	}

	/*if($subt>0){
		$pdf->ezText("");
		$subtotal[]= array('1'=>'SUBTOTAL','2'=>"$ ".number_format($subt,2));
		$pdf->ezTable($subtotal,'','',$opsubt);
	}*/

	mysql_close($cnn);
	$pdf->ezText("\n");
	//$pdf->ezTable($totales,'','',$optotal);
	$pdf->ezText("ENTRETENIMIENTO SIN LIMITES LTDA NIT. 900080794-6 | PBX: (571) 2360032 - 8053100 - 8053138",7,$opnota);
	$documento_pdf = $pdf->ezOutput();
	$archivo = 'brief.pdf';
	$fichero = fopen($archivo,'wb');
	fwrite ($fichero, $documento_pdf);
	fclose ($fichero);

echo '
<div class="cuerpo">
		<h3>Brief de <span>Proyectos</span></h3>
		<p class="p0">A Continuaci&oacute;n se presenta el presupuesto seleccionado</p>
		<br />
		<object type="application/pdf" data="'.$archivo.'" width="80%" height="650" ></object>
</div>';
}
}
?>