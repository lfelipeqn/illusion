<?php
	include ('Connections/cnn.php');
	include('class.ezpdf.php');
if(isset($_SESSION['usuario'])){
	$idproduccion=$_GET['seguimiento'];
	$connect=mysql_select_db($database_cnn,$cnn);
	$sql="SELECT clientes.NombreCliente, proyectos.NombreProyecto, clientes.Identificacion, clientes.DV, tipoempresa.TipoEmpresa, proyectos.NombreContacto, proyectos.IdProyecto, proyectos.LugarEvento, presupuestos.Total, usuarios.IdUsuario, usuarios.Nombre AS ProductorEjecutivo, produccion.IdProduccion, proyectos.FechaEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, clientes.PersonaContacto, clientes.email, produccion.TerGEspectaculos, produccion.TerGEventoCorporativo, produccion.TerGNuevasTec, produccion.TerGProduccion, produccion.TerGImprevistos, produccion.TerGTransporte, produccion.TerGPersonal, produccion.TotalTerceros, produccion.ESLGEspectaculos, produccion.ESLGEventoCorporativo, produccion.ESLGNuevasTec, produccion.ESLGProduccion, produccion.ESLGImprevistos, produccion.ESLGTransporte, produccion.ESLGPersonal, produccion.TotalESL, produccion.GranTotal, produccion.IdUnidad FROM produccion INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto INNER JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto LEFT JOIN usuarios ON produccion.ProductorEjecutivo = usuarios.IdUsuario INNER JOIN usuarios_unidades ON produccion.IdUnidad = usuarios_unidades.IdUnidad where produccion.IdProduccion = '$idproduccion' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";	

	if($_SESSION['unidad']!=0){
		$sql.=" AND usuarios_unidades.IdUnidad='".$_SESSION['unidad']."'";
	}

	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$unidad=$_SESSION['unidad'];
	
	$pdf = new Cezpdf('letter');
	$pdf -> selectFont('../fonts/courier.afm');
	$pdf -> ezSetCmMargins(1,1,2,1);

	$rs=mysql_fetch_assoc($consulta);

	$datos = array(
				   array(
						 '1'=>'CLIENTE:',
						 '2'=>$rs['NombreCliente'],
						 '3'=>'EVENTO No.:',
						 '4'=>$rs['IdProyecto']
						),
				   array(
						 '1'=>'NIT:',
						 '2'=>$rs['Identificacion'].' DV '.$rs['DV'],
						 '3'=>'TIPO EMPRESA:',
						 '4'=>$rs['TipoEmpresa']
						),

				   array(
						 '1'=>'CONTACTO CLIENTE:',
						 '2'=>$rs['PersonaContacto'],
						 '3'=>'EVENTO:',
						 '4'=>$rs['NombreProyecto']
						),
				   array(
						 '1'=>'LUGAR DEL EVENTO:',
						 '2'=>$rs['LugarEvento'],
                         '3'=>'TOTAL PRESUPUESTO:',
						 '4'=>aMoneda($rs['Total'])
						),
				   array(
						 '1'=>'PRODUCTOR EJECUTIVO:',
						 '2'=>$rs['ProductorEjecutivo'],
						 '3'=>'E-MAIL:',
						 '4'=>$rs['email']
						)
				   );

	$subesl = array(
					array(
						 '1'=>'Gastos Equipos ESL:',
						 '2'=>aMoneda($rs['ESLGEspectaculos']),
						 '3'=>'Gastos Eventos Corp:',
						 '4'=>aMoneda($rs['ESLGEventoCorporativo']),
						 '5'=>'Gastos Nvas. Tecnologias:',
						 '6'=>aMoneda($rs['ESLGNuevasTec'])
						),
				   	array(
						 '1'=>'Gastos Produccion:',
						 '2'=>aMoneda($rs['ESLGTransporte']+$rs['ESLGProduccion']),
						 '3'=>'Gastos Imprevistos:',
						 '4'=>aMoneda($rs['ESLGImprevistos']),
						 '5'=>'Gastos Personal:',
						 '6'=>aMoneda($rs['ESLGPersonal'])
						)
					 );

	$totgen[] = array(
					  	'1'=>'TOTAL HOJA DE PRODUCCION:',
						'2'=>aMoneda($rs['GranTotal'])
					  );
	
	$cadprodc="SELECT usuarios.Nombre FROM produccion Inner Join usuarios ON produccion.ProductorCampo = usuarios.IdUsuario WHERE produccion.IdProduccion=$idproduccion";
	$cltprodc=mysql_query($cadprodc,$cnn);
	$rsprodc=mysql_fetch_assoc($cltprodc);

	$infec="SELECT * FROM produccion_ec WHERE IdProduccion=$idproduccion";
	$cltec=mysql_query($infec,$cnn) or die(mysql_error());
	$totec=mysql_num_rows($cltec);

	while($rsec=mysql_fetch_assoc($cltec)){
		$contenidoec[]= array(
							'Detalle'=>$rsec['Detalle'],
							'Cantidad'=>number_format($rsec['Cantidad'],0),
							'Dias'=>number_format($rsec['Dias'],0),
							'Valor Unitario'=>aMoneda($rsec['VrUnitario']),
							'Valor Total'=>aMoneda($rsec['VrTotal'])
							);
	}

	$infnt="SELECT * FROM produccion_nt WHERE IdProduccion=$idproduccion";
	$cltnt=mysql_query($infnt,$cnn) or die(mysql_error());
	$totnt=mysql_num_rows($cltnt);

	while($rsnt=mysql_fetch_assoc($cltnt)){
		$contenidont[]= array(
							'Detalle'=>$rsnt['Detalle'],
							'Cantidad'=>number_format($rsnt['Cantidad'],0),
							'Dias'=>number_format($rsnt['Dias'],0),
							'Valor Unitario'=>aMoneda($rsnt['VrUnitario']),
							'Valor Total'=>aMoneda($rsnt['VrTotal'])
							);
	}

	$infesl="SELECT * FROM produccion_esl WHERE IdProduccion=$idproduccion";
	$cltesl=mysql_query($infesl,$cnn) or die(mysql_error());
	$totesl=mysql_num_rows($cltesl);

	while($rsesl=mysql_fetch_assoc($cltesl)){
		$contenidoesl[]= array(
							'Detalle'=>$rsesl['Detalle'],
							'Cantidad'=>number_format($rsesl['Cantidad'],0),
							'Dias'=>number_format($rsesl['Dias'],0),
							'Valor Unitario'=>aMoneda($rsesl['VrUnitario']),
							'Valor Total'=>aMoneda($rsesl['VrTotal'])
							);
	}

	$infgp="SELECT * FROM produccion_gp WHERE IdProduccion=$idproduccion";
	$cltgp=mysql_query($infgp,$cnn) or die(mysql_error());
	$totgp=mysql_num_rows($cltgp);

	while($rsgp=mysql_fetch_assoc($cltgp)){
		$contenidogp[]= array(
							'Detalle'=>$rsgp['Detalle'],
							'Cantidad'=>number_format($rsgp['Cantidad'],0),
							'Dias'=>number_format($rsgp['Dias'],0),
							'Valor Unitario'=>aMoneda($rsgp['VrUnitario']),
							'Valor Total'=>aMoneda($rsgp['VrTotal'])
							);
	}

	$infim="SELECT * FROM produccion_im WHERE IdProduccion=$idproduccion";
	$cltim=mysql_query($infim,$cnn) or die(mysql_error());
	$totim=mysql_num_rows($cltim);

	while($rsim=mysql_fetch_assoc($cltim)){
		$contenidoim[]= array(
							'Detalle'=>$rsim['Detalle'],
							'Cantidad'=>number_format($rsim['Cantidad'],0),
							'Dias'=>number_format($rsim['Dias'],0),
							'Valor Unitario'=>aMoneda($rsim['VrUnitario']),
							'Valor Total'=>aMoneda($rsim['VrTotal'])
							);
	}

	$ejecutiva = array(
				   array(
						 '1'=>'PRODUCTOR DE CAMPO:',
						 '2'=>$rsprodc['Nombre'],
						 '3'=>'CONSECUTIVO P.G.:',
						 '4'=>''
						),
				   array(
						 '1'=>'DIRECCION DE MONTAJE:',
						 '2'=>$rs['LugarEvento'],
						 '3'=>'CONTACTO:',
						 '4'=>$rs['NombreContacto']
						)
				   );
	$evento[] = array(
					'1'=>'FECHA EVENTO:',
					'2'=>ConvFecha($rs['FechaEvento']),
					'3'=>'FECHA MONTAJE:',
					'4'=>ConvFecha($rs['FechaMontaje']),
					'5'=>'FECHA DESMONTAJE:',
					'6'=>ConvFecha($rs['FechaDesmontaje'])
					);

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
                    
	$opcsub = array(
					'shaded'=>0,
					'showHeadings'=>0,
					'shadeCol'=>array(0.9,0.9,0.9),
					'xOrientation'=>'center',
                	'width'=>uPDF(18),
					'fontSize'=> 8,
					'cols'=>array(
								  '2'=>array('justification'=>'right'),
								  '4'=>array('justification'=>'right'),
								  '6'=>array('justification'=>'right')
								  )
					);

	$optablas = array(
					  	'shaded'=>0,
						'showHeadings'=>1,
						'shadeCol'=>array(0.9,0.9,0.9),
						'xOrientation'=>'center',
						'width'=>uPDF(18),
						'fontSize'=> 8,
						'cols'=>array(
								  'Cantidad'=>array('justification'=>'right'),
								  'Dias'=>array('justification'=>'right'),
								  'Valor Unitario'=>array('justification'=>'right'),
								  'Valor Total'=>array('justification'=>'right')
								  )
					);

	$opnota= array(
				   'aleft'=>70,
				   'justification'=>'left'
				   );
	
	$sqlper="SELECT produccion_pr.IdRegistro, produccion_pr.IdProduccion, usuarios.Nombre, produccion_pr.Cantidad, produccion_pr.Dias, produccion_pr.VrUnitario, produccion_pr.VrTotal, produccion_pr.Detalle FROM produccion_pr INNER JOIN usuarios ON produccion_pr.IdPersona = usuarios.Usuario WHERE (produccion_pr.IdProduccion=$idproduccion)";
	$cltper=mysql_query($sqlper,$cnn) or die(mysql_error());
	$totper=mysql_num_rows($cltper);

	while($rsper=mysql_fetch_assoc($cltper)){
		$arrpers[]= array(
							'Profesional'=>$rsper['Nombre'].': '.$rsper['Detalle'],
							'Cantidad'=>number_format($rsper['Cantidad'],0),
							'Dias'=>number_format($rsper['Dias'],0),
							'Valor Unitario'=>aMoneda($rsper['VrUnitario']),
							'Valor Total'=>aMoneda($rsper['VrTotal'])
							);
	}

    $pdf->addJpegFromFile(Unidad($unidad),uPDF(2),uPDF(24.5),100,80);
	$pdf->addText(uPDF(14.5),uPDF(25),8,"ENTRETENIMIENTO SIN LIMITES LTDA");
	$pdf->addText(uPDF(17.5),uPDF(24.5),8,"NIT 900080794-6");
	$pdf->ezText("\n\n\n\n\n\n\n");
	$pdf->filledRectangle(uPDF(2.11),uPDF(23.65),uPDF(18),uPDF(0.5));
	$pdf->setColor(255,255,255);
	$pdf->addText(uPDF(9),uPDF(23.75),10,"HOJA DE PRODUCCION");
	$pdf->setColor(0,0,0);
	$pdf->ezTable($datos,'','',$opciones);
	$pdf->ezText("\n");
	$pdf->ezTable($ejecutiva,'','INFORMACION EJECUTIVA',$opciones);
	$pdf->ezText("\n");
	$pdf->ezTable($evento,'','FECHAS DEL EVENTO',$opciones);
	$pdf->ezText("\n");
	
	if($totec>=1){
		$pdf->ezTable($contenidoec,'','EVENTOS CORPORATIVOS',$optablas);
		$pdf->ezText("\n");
	}

	if($totnt>=1){
		$pdf->ezTable($contenidont,'','NUEVAS TECNOLOGIAS',$optablas);
		$pdf->ezText("\n");
	}

	if($totesl>=1){
		$pdf->ezTable($contenidoesl,'','EQUIPOS ESL',$optablas);
		$pdf->ezText("\n");
	}

	if($totgp>=1){
		$pdf->ezTable($contenidogp,'','GASTOS PRODUCCION',$optablas);
		$pdf->ezText("\n");
	}

	if($totim>=1){
		$pdf->ezTable($contenidoim,'','IMPREVISTOS',$optablas);
		$pdf->ezText("\n");
	}

	if($totper>=1){
		$pdf->ezTable($arrpers,'','GASTOS PERSONAL',$optablas);
		$pdf->ezText("\n");
	}

	$pdf->ezText("\n");
	$pdf->ezTable($subesl,'','',$opcsub);
	$pdf->ezText("\n");
	$pdf->ezTable($totgen,'','',$opciones);
	$pdf->ezText("\n");

	mysql_close($cnn);

	/*$pdf->ezText("\n");
	$pdf->ezText("NOTA: La Informaci&oacute;n presentada en este formulario est&aacute; sujeta al contrato o lo acuerdos establecidos entre el PROVEEDOR y la COMPA&Ntilde;&Iacute;A",7,$opnota);*/

	$documento_pdf = $pdf->ezOutput();
	$archivo = 'produccion.pdf';
	$fichero = fopen($archivo,'wb');
	fwrite ($fichero, $documento_pdf);
	fclose ($fichero);

echo '
<div class="cuerpo">
		<h3>Consulta de Hoja <span>de Producci&oacute;n</span></h3>
		<p class="p0">A Continuaci&oacute;n se presenta la informaci&oacute;n de la Hoja de Producci&oacute;n Seleccionada</p>
		<br />
		<object type="application/pdf" data="'.$archivo.'" width="80%" height="650" ></object>
</div>';
}
?>