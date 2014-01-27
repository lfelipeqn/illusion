<?php
	include ('Connections/cnn.php');
	include('class.ezpdf.php');
	include ('classes/libchart.php');

if(isset($_SESSION['usuario'])){
	$idproyecto=$_GET['negocio'];
	$connect=mysql_select_db($database_cnn,$cnn);
    
	$sql="SELECT negocios.FechaCreacion, clientes.NombreCliente, negocios.IdProyecto, negocios.IdUnidad, clientes.DV, proyectos.NombreContacto, proyectos.NombreProyecto, proyectos.LugarEvento, presupuestos.Total, proyectos.EmailContacto, negocios.Anticipo, negocios.PorcAnticipo, usuarios.Nombre AS Comercial, negocios.Observaciones, negocios.Productor, negocios.PorAD, negocios.ValAD, negocios.PorDG, negocios.ValDG, negocios.PorBM, negocios.ValBM, negocios.PorPR, negocios.ValPR, produccion.GranTotal, clientes.Identificacion FROM negocios LEFT JOIN clientes ON negocios.IdCliente = clientes.IdCliente LEFT JOIN proyectos ON negocios.IdProyecto = proyectos.IdProyecto LEFT JOIN presupuestos ON negocios.IdProyecto = presupuestos.IdProyecto LEFT JOIN usuarios ON presupuestos.Presentadopor = usuarios.Usuario LEFT JOIN produccion ON negocios.IdProyecto = produccion.IdProyecto WHERE presupuestos.Aprobabo = 1 AND negocios.IdProyecto ='".$idproyecto."'";
    $consulta=mysql_query($sql,$cnn) or die(mysql_error());

	$cadplazo="SELECT negocios_plazo.IdNegocio, plazopago.Plazo FROM negocios_plazo Inner Join plazopago ON negocios_plazo.plazopago = plazopago.IdPlazo WHERE negocios_plazo.IdProyecto = '$idproyecto'";
	$cltplazo=mysql_query($cadplazo,$cnn) or die(mysql_error());
	$plazodepago='';

	while($rsplazop=mysql_fetch_assoc($cltplazo)){
		$plazodepago=$plazodepago.$rsplazop['Plazo'].', ';
	}

	$plazodepago=substr($plazodepago,0,strlen($plazodepago)-2);

	$pdf =& new Cezpdf('letter');
	$pdf -> selectFont('../fonts/courier.afm');
	$pdf -> ezSetCmMargins(1,1,2,1);
	$rs=mysql_fetch_assoc($consulta);

	//while ($rs=mysql_fetch_assoc($consulta)){
		$fecha=ConvFecha($rs['FechaCreacion']);
		$obs[] = array(
						'1'=>strtoupper($rs['Observaciones'])
						);

		$rent=($rs['Total']-($rs['ValAD']+$rs['ValPR']+$rs['ValDG']+$rs['ValBM']+$rs['GranTotal']))/$rs['Total'];

		$resultados[] = array('1'=>'Rentabilidad',
							'2'=>str_replace("$ ","",aMoneda($rent*100)).' %');
		$datos = array(
					   array(
							 '1'=>'CONSECUTIVO NEGOCIO:',
							 '2'=>$rs['IdProyecto'],
							 '3'=>'FECHA DE CREACION',
							 '4'=>$fecha
							),
					   array(
							 '1'=>'CLIENTE:',
							 '2'=>strtoupper($rs['NombreCliente']),
							 '3'=>'NIT:',
							 '4'=>$rs['Identificacion'].'-'.$rs['DV']
							),
					   array(
							 '1'=>'CONTACTO EVENTO:',
							 '2'=>strtoupper($rs['NombreContacto']),
							 '3'=>'E-MAIL:',
							 '4'=>$rs['EmailContacto']
							),
					   array(
							 '1'=>'PROYECTO:',
							 '2'=>strtoupper($rs['NombreProyecto']),
							 '3'=>'LUGAR DEL EVENTO:',
							 '4'=>strtoupper($rs['LugarEvento'])
							),
					   array(
							 '1'=>'PLAZO DE PAGO:',
							 '2'=>strtoupper($plazodepago),
							 '3'=>'VR. ANTICIPO / % ANTICIPO:',
							 '4'=>aMoneda($rs['Anticipo']).' / '.$rs['PorcAnticipo'].'%'
							),
					  array(
							 '1'=>'COMERCIAL:',
							 '2'=>strtoupper($rs['Comercial']),
							 '3'=>'PRODUCTOR:',
							 '4'=>strtoupper($rs['Productor'])
							)
					   );
		
			$totales= array(
							array(
							 '1'=>'Valor Presupuesto',
							 '2'=>aMoneda($rs['Total']),
							 '3'=>'Valor Producción',
							 '4'=>aMoneda($rs['GranTotal'])
							 ),
							array(
							 '1'=>'% Costos Administración:',
							 '2'=>$rs['PorAD'].' %',
							 '3'=>'Costo Administracion:',
							 '4'=>aMoneda($rs['ValAD'])
							 ),
							array(
							 '1'=>'% Director General:',
							 '2'=>$rs['PorDG'].' %',
							 '3'=>'Comisión Director General:',
							 '4'=>aMoneda($rs['ValDG'])
							 ),
							array(
							 '1'=>'% Comercial',
							 '2'=>$rs['PorBM'].' %',
							 '3'=>'Comisión Comercial',
							 '4'=>aMoneda($rs['ValBM'])
							 ),
							array(
							 '1'=>'% Productor',
							 '2'=>$rs['PorPR'].' %',
							 '3'=>'Comisión Productor',
							 '4'=>aMoneda($rs['ValPR'])
							 )
							);
	$unidad=$rs['IdUnidad'];
	//};
	$chart = new PieChart(500, 250);
	$dataSet = new XYDataSet();
	$dataSet->addPoint(new Point("Administracion", ($rs['ValAD']/$rs['Total'])));
	$dataSet->addPoint(new Point("Productor", ($rs['ValPR']/$rs['Total'])));
	$dataSet->addPoint(new Point("Director", ($rs['ValDG']/$rs['Total'])));
	$dataSet->addPoint(new Point("Comercial", ($rs['ValBM']/$rs['Total'])));
	$dataSet->addPoint(new Point("Producion", ($rs['GranTotal']/$rs['Total'])));
	$dataSet->addPoint(new Point("Margen", (($rs['Total']-($rs['GranTotal']+$rs['ValBM']+$rs['ValDG']+$rs['ValPR']+$rs['ValAD']))/$rs['Total'])));
	$chart->setDataSet($dataSet);
	$chart->setTitle("Distribucion de Costos del Proyecto");
	$chart->render("negocios/costos.png");

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
	$opval = array(
					'shaded'=>0,
					'showHeadings'=>0,
                	'xOrientation'=>'center',
                	'width'=>uPDF(18),
					'fontSize'=> 10,
					'cols'=>array(
								  '2'=>array('justification'=>'right'),
								  '4'=>array('justification'=>'right')
								  )
					);
	$oprent = array(
					'shaded'=>0,
					'showHeadings'=>0,
                	'xOrientation'=>'center',
                	'width'=>uPDF(18),
					'fontSize'=> 13,
					'cols'=>array(
								  '2'=>array('justification'=>'right'),
								  '4'=>array('justification'=>'right')
								  )
					);

	$opnota= array(
				   'aleft'=>70,
				   'justification'=>'left'
				   );

    $pdf->addJpegFromFile(Unidad($unidad),uPDF(2),uPDF(24.5),100,80);
	$pdf->addText(uPDF(14.5),uPDF(25),8,"ENTRETENIMIENTO SIN LIMITES LTDA");
	$pdf->addText(uPDF(17.5),uPDF(24.5),8,"NIT 900080794-6");
	$pdf->ezText("\n\n\n\n\n\n\n");
	$pdf->filledRectangle(uPDF(2.11),uPDF(23.65),uPDF(18),uPDF(0.5));
	$pdf->setColor(255,255,255);
	$pdf->addText(uPDF(9),uPDF(23.75),10,"HOJA DE NEGOCIOS");
	$pdf->setColor(0,0,0);
	$pdf->ezTable($datos,'','',$opciones);
	mysql_close($cnn);

	$pdf->ezText("\n");
	$pdf->ezTable($totales,'','',$opval);
	$pdf->ezText("\n");
	$pdf->addPngFromFile('negocios/costos.png',uPDF(5),uPDF(8),400,200);
	$pdf->ezTable($resultados,'','',$oprent);
    
	if(strlen($rs['Observaciones'])>=1){
		$pdf->ezTable($obs,'','OBSERVACIONES',$opciones);
	}

	//$pdf->ezText("\nNOTA: \nLa Información presentada en este formulario está sujeta al contrato o los acuerdos establecidos entre el proveedor y la Compañía.",7,$opnota);

	$documento_pdf = $pdf->ezOutput();
	$archivo = 'hojanegocio.pdf';
	$fichero = fopen($archivo,'wb');
	fwrite ($fichero, $documento_pdf);
	fclose ($fichero);

echo '
<div class="cuerpo">
	<h3>Consulta Hoja de <span>Negocio</span></h3>
	<p class="p0">A Continuaci&oacute;n se presenta la Hoja de Negocio seleccionada</p>
	<br />
	<object type="application/pdf" data="'.$archivo.'" width="80%" height="650" ></object>
</div>';
}
?>