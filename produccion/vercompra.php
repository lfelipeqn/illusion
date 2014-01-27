<?php
	//session_start();
    error_reporting(0);
    
	include ('Connections/cnn.php');
	include('class.ezpdf.php');
if(isset($_SESSION['usuario'])){
	$produccion=$_GET['seguimiento'];
	$privilegio=$_SESSION['perfil'];
	$proveedor=$_GET['proveedor'];

	$connect=mysql_select_db($database_cnn,$cnn);
	$sqlcompra="SELECT orden_compra.IdOrden, orden_compra.IdProduccion, orden_compra.IdProveedor, orden_compra.IdEstadoOrden  FROM orden_compra WHERE orden_compra.IdProveedor='".$proveedor."' AND orden_compra.IdOrden='".$produccion."'";
	$cltcompra=mysql_query($sqlcompra,$cnn) or die(mysql_error());
	$rscompra=mysql_fetch_assoc($cltcompra);
	$idcompra=$rscompra['IdOrden'];

	$sqlproveedor="SELECT proveedores.NombreProveedor, tipoidentificacion.TipoIdentificacion, proveedores.Identificacion, proveedores.DV, proveedores.Actividad, proveedores.Representante, proveedores.Correo, proveedores.Direccion FROM proveedores Inner Join tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo WHERE proveedores.Identificacion='".$proveedor."'";
    $cltproveedor=mysql_query($sqlproveedor,$cnn) or die(mysql_error());
    
	$sqlorden="SELECT orden_compra.IdOrden, orden_compra.IdProduccion, orden_compra.IdProveedor, orden_compra.VrCompra, orden_compra.VrIva, orden_compra.VrRetencion, orden_compra.VrNeto, orden_compra.VrReteIva, orden_compra.VrReteIca, orden_compra.VrReteFte, orden_compra.Observacion, plazopago.Plazo FROM orden_compra LEFT JOIN plazopago ON orden_compra.IdPlazo = plazopago.IdPlazo WHERE orden_compra.IdOrden='".$idcompra."'";
	$cltorden=mysql_query($sqlorden,$cnn) or die(mysql_error());

	
	$pdf =& new Cezpdf('letter');
	$pdf -> selectFont('../fonts/courier.afm');
	$pdf -> ezSetCmMargins(1,1,2,1);

	$rs=mysql_fetch_assoc($cltproveedor);
	$rsorden=mysql_fetch_assoc($cltorden);


	$sqlproyecto="SELECT proyectos.IdProyecto, proyectos.IdCliente, proyectos.NombreProyecto, proyectos.LugarEvento, proyectos.FechaEvento, proyectos.IdUnidad FROM produccion Inner Join proyectos ON produccion.IdProyecto = proyectos.IdProyecto WHERE produccion.IdProduccion =  '".$rsorden['IdProduccion']."'";
	$cltproyecto=mysql_query($sqlproyecto,$cnn) or die(mysql_error());
	$rsproyecto=mysql_fetch_assoc($cltproyecto);

	$unidad=$rsproyecto['IdUnidad'];

	$sqlnegocio="SELECT negocios.IdNegocio, negocios.IdProyecto, negocios.FechaCreacion, negocios.Anticipo, negocios.PorcAnticipo FROM negocios WHERE 
negocios.IdProyecto =  '".$rsproyecto['IdProyecto']."'";

	$cltnegocio=mysql_query($sqlnegocio,$cnn) or die(mysql_error());
	$rsnegocio=mysql_fetch_assoc($cltnegocio);
	$idnegocio=$rsnegocio['IdNegocio'];

	$sqlcliente="SELECT clientes.NombreCliente, clientes.Identificacion, clientes.DV FROM clientes WHERE clientes.IdCliente =  '".$rsproyecto['IdCliente']."'";
	$cltcliente=mysql_query($sqlcliente,$cnn) or die(mysql_error());
	$rscliente=mysql_fetch_assoc($cltcliente);

	$sqlproduccion="SELECT produccion.IdProduccion, produccion.Finalizada, produccion.Aprobada FROM produccion WHERE produccion.IdProduccion=".$produccion;
	$cltproduccion=mysql_query($sqlproduccion,$cnn) or die(mysql_error());
	$rsproduccion=mysql_fetch_assoc($cltproduccion);

	$prodfinalizada=$rsproduccion['Finalizada'];
    $prodaprobada=$rsproduccion['Aprobada'];
    
	$tipon='';
	$plazon='';

	$sqltipon="SELECT negocios_tipo.IdNegocio, tiponegocio.IdTipoN, tiponegocio.TipoNegocio FROM negocios_tipo Inner Join tiponegocio ON negocios_tipo.TipoNegocio = tiponegocio.IdTipoN WHERE negocios_tipo.IdNegocio =  '$idnegocio'";
	$clttipon= mysql_query($sqltipon,$cnn) or die(mysql_error());
	$totaltipo=mysql_num_rows($clttipon);

	if ($totaltipo>1){
		while($rstipon=mysql_fetch_assoc($clttipon)){
			$tipon.=$rstipon['TipoNegocio'].', ';
		}
		$tipon=substr($tipon,0,strlen($tipon)-2);
	}

	if ($totaltipo==1){
		$rstipon=mysql_fetch_assoc($clttipon);
		$tipon=$rstipon['TipoNegocio'];
	}

	
	$datos = array(
				   array(
						 '1'=>'',
						 '2'=>'',
						 '3'=>'FECHA DE ENVIO',
						 '4'=>date('d-m-Y')
						),
				   array(
						 '1'=>'PROVEEDOR:',
						 '2'=>$rs['NombreProveedor'],
						 '3'=>'CONSECUTIVO:',
						 '4'=>$idcompra
						),
				   array(
						 '1'=>'NIT:',
						 '2'=>$rs['Identificacion'].' DV '.$rs['DV'],
						 '3'=>'TIPO PROVEEDOR:',
						 '4'=>$rs['Actividad']
						),
				   array(
						 '1'=>'CONTACTO PROVEEDOR:',
						 '2'=>$rs['Representante'],
						 '3'=>'PROYECTO:',
						 '4'=>$rsproyecto['NombreProyecto']
						),
				   array(
						 '1'=>'DIRECCION:',
						 '2'=>$rsproyecto['LugarEvento'],
						 '3'=>'VR. ORDEN DE COMPRA:',
						 '4'=>aMoneda($rsorden['VrCompra'])
						),
				   array(
						 '1'=>'TIPO DE NEGOCIO:',
						 '2'=>$tipon,
						 '3'=>'EMAIL:',
						 '4'=>$rs['Correo']
						 ),
				   array(
						 '1'=>'PLAZO DE PAGO:',
						 '2'=>strtoupper($rsorden['Plazo']),
						 '3'=>'OBSERVACIONES:',
						 '4'=>$rsorden['Observacion']
						 )
				   );

	$general = array(
					array(
						 '1'=>'',
						 '2'=>'',
						 '3'=>'FACTURAR A:',
						 '4'=>'ENTRETENIMIENTO SIN LIMITES LTDA',
						 '5'=>'FECHA APROBACION:',
						 '6'=>ConvFecha($rsnegocio['FechaCreacion'])
						),
				   	array(
						 '1'=>'FECHA EVENTO:',
						 '2'=>ConvFecha($rsproyecto['FechaEvento']),
						 '3'=>'NIT CLIENTE:',
						 '4'=>'900080794-6',
						 '5'=>'NO. NEGOCIO:',
						 '6'=>$rsproyecto['IdProyecto']
						)
					 );


	$sqldetalle="SELECT detalle_compra.IdOrden, detalle_compra.Detalle, detalle_compra.Cantidad, detalle_compra.Dias, detalle_compra.VrUnit, detalle_compra.VrTotal, detalle_compra.VrIva FROM detalle_compra WHERE detalle_compra.IdOrden =  '$idcompra'";
	$cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
	$totdetalle=mysql_num_rows($cltdetalle);

	while($rsdetalle=mysql_fetch_assoc($cltdetalle)){
		$contenido[]= array(
							'Detalle'=>$rsdetalle['Detalle'],
							'Cantidad'=>number_format($rsdetalle['Cantidad'],0),
							'Dias'=>number_format($rsdetalle['Dias'],0),
							'Valor Unitario'=>aMoneda($rsdetalle['VrUnit']),
							'Valor Total'=>aMoneda($rsdetalle['VrTotal']),
							'Valor IVA'=>aMoneda($rsdetalle['VrIva'])
							);
	}

	$retenciones[] = array(
					'1'=>'(-) RETE IVA:',
					'2'=>aMoneda($rsorden['VrReteIva']),
					'3'=>'(-) RETE ICA:',
					'4'=>aMoneda($rsorden['VrReteIca']),
					'5'=>'(-) RETE FUENTE:',
					'6'=>aMoneda($rsorden['VrReteFte'])
					);
                    
	$opciones = array(
					'shaded'=>0,
					'showHeadings'=>0,
					'titleFontSize' => 10,
                	'xOrientation'=>'center',
                	'width'=>uPDF(18),
					'fontSize'=> 7,
					'cols'=>array(
								  '2'=>array('justification'=>'right'),
								  '4'=>array('justification'=>'right'),
								  '6'=>array('justification'=>'right')
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
						'titleFontSize' => 10,
						'width'=>uPDF(18),
						'fontSize'=> 8,
						'cols'=>array(
								  'Cantidad'=>array('justification'=>'right'),
								  'Días'=>array('justification'=>'right'),
								  'Valor Unitario'=>array('justification'=>'right'),
								  'Valor Total'=>array('justification'=>'right'),
								  'Valor IVA'=>array('justification'=>'right')
								  )
					);
	
	$opnota= array(
				   'aleft'=>70,
				   'justification'=>'left'
				   );
                   
	switch($unidad){
		case 1:
			$pdf->addJpegFromFile('images/esl_corp.jpg',uPDF(2),uPDF(24.5),200,80);
			break;
		case 2:
			$pdf->addJpegFromFile('images/esl_dig.jpg',uPDF(2),uPDF(24.5),200,80);
			break;
		case 3:
			$pdf->addJpegFromFile('images/esl_ago.jpg',uPDF(2),uPDF(24.5),250,80);
			break;
		case 4:
			$pdf->addJpegFromFile('images/esl_sax.jpg',uPDF(2),uPDF(24.5),250,80);
			break;
		case 5:
			$pdf->addJpegFromFile('images/envivo.jpg',uPDF(2),uPDF(24.5),250,80);
			break;
	}

	$pdf->addText(uPDF(14.5),uPDF(25),8,"ENTRETENIMIENTO SIN LIMITES LTDA");
	$pdf->addText(uPDF(17.5),uPDF(24.5),8,"NIT 900080794-6");
	$pdf->ezText("\n\n\n\n\n\n\n");
	//$pdf->filledRectangle(uPDF(2.11),uPDF(23.45),uPDF(18),uPDF(0.9));
	//$pdf->setColor(255,255,255);
    
    if($rscompra['IdEstadoOrden']==4){
        $pdf->setColor(255,0,0);
        $pdf->addText(uPDF(4.5),uPDF(13),34,"ORDEN DE COMPRA ANULADA",-45);
        $pdf->setColor(0,0,0);
    }
    
    
    if (($prodfinalizada==1) && ($prodaprobada==1)){
        $pdf->addText(uPDF(9),uPDF(23.75),15,"ORDEN DE COMPRA");   
    }else{
        $pdf->addText(uPDF(8),uPDF(23.75),15,"ORDEN DE PRODUCCION");
    }    
    
    
	$pdf->setColor(0,0,0);
	$pdf->ezTable($datos,'','',$opciones);
	$pdf->ezText("\n");
	$pdf->ezTable($general,'','INFORMACION GENERAL',$opciones);
	$pdf->ezText("\n");
	if($totdetalle>=1){
		$pdf->ezTable($contenido,'','INFORMACION COMPANIA',$optablas);
		$pdf->ezText("\n");
	}

	$pdf->ezTable($retenciones,'','',$opciones);
	$pdf->ezText("\n");
	$pdf->ezText("NOTA: La Informacion presentada en este formulario esta sujeta al contrato o lo acuerdos establecidos entre el PROVEEDOR y la COMPANIA",7);
	if($prodfinalizada=='0'){
		$pdf->ezText("\n");
		$pdf->ezText("ORDEN DE COMPRA PROVISIONAL: Esta Orden de Compra es Provisional y no aplica para facturacion, sin embargo acepta por parte de ESL LTDA el compromiso de la prestacion del servicio",7);
	}
    
	$documento_pdf = $pdf->ezOutput();
	$archivo = 'compra.pdf';
	$fichero = fopen($archivo,'wb');
	fwrite ($fichero, $documento_pdf);
	fclose ($fichero);

echo '
<div class="cuerpo">
	<h3>Consulta de <span>Orden de Compra</span></h3>
	<p class="p0">A Continuaci&oacute;n se presenta la Orden de Compra para el proveedor seleccionado</p>
	<br />
	<object type="application/pdf" data="'.$archivo.'" width="80%" height="650" ></object>
</div>';
	mysql_close($cnn);
}
?>