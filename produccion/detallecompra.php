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

	$sqlanula="UPDATE orden_compra SET IdEstadoOrden=4 WHERE orden_compra.IdProveedor='$proveedor' AND orden_compra.IdProduccion='$produccion'";
    $cltanula=mysql_query($sqlanula,$cnn) or die(mysql_error());
    
    $sqlprov="SELECT tipoidentificacion.TipoIdentificacion, proveedores.NombreProveedor, proveedores.Identificacion, 
    proveedores.DV, proveedores.Ciudad, proveedores.Direccion, proveedores.Telefono, proveedores.Fax, proveedores.Correo, 
    proveedores.IVA, proveedores.ReteIva, proveedores.ReteIca,proveedores.ReteFte, tipoproveedor.TipoProveedor, proveedores.Representante 
    FROM proveedores 
    INNER JOIN tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo 
    INNER JOIN tipoproveedor ON proveedores.IdTipoP = tipoproveedor.IdTipoP 
    WHERE proveedores.Identificacion='".$proveedor."'";
    
	$cltprov=mysql_query($sqlprov,$cnn) or die(mysql_error());
	$rsprov=mysql_fetch_assoc($cltprov);

	$valoriva=$rsprov['IVA'];
	$valorreteiva=$rsprov['ReteIva'];
	$valorreteica=$rsprov['ReteIca'];
	$valorretefte=$rsprov['ReteFte'];
	$fecha=date('Y-m-d');
	$usuario=$_SESSION['usuario'];

	if(($valoriva==0)&&($valorreteiva==0)&&($valorreteica==0)&&($valorretefte==0)){
		echo '
		<div class="cuerpo">
			<h3>Generaci&oacute;n de Ordenes de <span>Compra</span></h3>
			<p>No Puede crear la orden de Compra seleccionada debido a que no se encuentran cargados los valores de retencion del proveedor</p>
			<p>Por Favor, actualice la Informaci&oacute;n del proveedor para continuar con la generaci&oacute;n de la orden de compra</p>
		</div>';

	}else{
		$sqlborra="DELETE FROM compra_temp";
		$cltborra=mysql_query($sqlborra, $cnn) or die(mysql_error());

		for($i=1;$i<=4;$i++){
			switch($i){
				case 1:
					$sqltot="SELECT produccion_ec.IdProduccion, produccion_ec.UsaProveedor, produccion_ec.IdProveedor, produccion_ec.Categoria, produccion_ec.Detalle, produccion_ec.Cantidad, produccion_ec.Dias, produccion_ec.Ciudades, produccion_ec.VrUnitario, produccion_ec.VrTotal FROM produccion_ec WHERE produccion_ec.IdProduccion='".$produccion."' AND produccion_ec.IdProveedor='".$proveedor."'";
					break;
				case 2:
					$sqltot="SELECT produccion_esl.IdProduccion, produccion_esl.UsaProveedor, produccion_esl.IdProveedor, produccion_esl.Categoria, produccion_esl.Detalle, produccion_esl.Cantidad, produccion_esl.Dias, produccion_esl.Ciudades, produccion_esl.VrUnitario, produccion_esl.VrTotal FROM produccion_esl WHERE produccion_esl.IdProduccion='".$produccion."' AND produccion_esl.IdProveedor='".$proveedor."'";	
					break;
				case 3:
					$sqltot="SELECT produccion_nt.IdProduccion, produccion_nt.UsaProveedor, produccion_nt.IdProveedor, produccion_nt.Categoria, produccion_nt.Detalle, produccion_nt.Cantidad, produccion_nt.Dias, produccion_nt.Ciudades, produccion_nt.VrUnitario, produccion_nt.VrTotal FROM produccion_nt WHERE produccion_nt.IdProduccion='".$produccion."' AND produccion_nt.IdProveedor='".$proveedor."'";	
					break;
				case 4:
					$sqltot="SELECT produccion_im.IdProduccion, produccion_im.UsaProveedor, produccion_im.IdProveedor, produccion_im.Categoria, produccion_im.Detalle, produccion_im.Cantidad, produccion_im.Dias, produccion_im.Ciudades, produccion_im.VrUnitario, produccion_im.VrTotal FROM produccion_im WHERE produccion_im.IdProduccion='".$produccion."' AND produccion_im.IdProveedor='".$proveedor."'";	
					break;
			}

			$consulta=mysql_query($sqltot,$cnn) or die(mysql_error());
			$filas=mysql_num_rows($consulta);
			if($filas>=1){
				while($rscompra=mysql_fetch_assoc($consulta)){
					$sqlanexar="INSERT INTO compra_temp(IdProduccion, IdProveedor, Detalle, Cantidad, Dias, VrUnitario, VrTotal) VALUES('".$rscompra['IdProduccion']."','".$rscompra['IdProveedor']."','".$rscompra['Detalle']."','".$rscompra['Cantidad']."','".$rscompra['Dias']."','".$rscompra['VrUnitario']."','".$rscompra['VrTotal']."')";
					$cltanexa=mysql_query($sqlanexar,$cnn) or die(mysql_error());
				}
			}
		}

		$sqlresumen="SELECT compra_temp.IdProduccion, compra_temp.IdProveedor, Sum(compra_temp.VrTotal) AS Total FROM compra_temp WHERE compra_temp.IdProduccion='".$produccion."' AND compra_temp.IdProveedor='".$proveedor."' GROUP BY compra_temp.IdProduccion, compra_temp.IdProveedor";
		$cltresumen=mysql_query($sqlresumen,$cnn)or die(mysql_error());
		$rstot=mysql_fetch_assoc($cltresumen);
        
		$valorcompra=$rstot['Total'];	
		$valorreten=$rstot['Total']*($valoriva+$valorreteiva+$valorreteica+$valorretefte);
		$valorneto=$valorcompra-$valorreten;

		$totaliva=$rstot['Total']*$valoriva;
		$totalreteiva=$rstot['Total']*$valorreteiva;
		$totalreteica=$rstot['Total']*$valorreteica;
		$totalretefte=$rstot['Total']*$valorretefte;

		$sqlvin="SELECT plazopago.IdPlazo, plazopago.Plazo, vinculoproveedor.IdProveedor FROM vinculoproveedor RIGHT JOIN plazopago ON vinculoproveedor.FormaPago = plazopago.IdPlazo WHERE vinculoproveedor.IdProveedor='".$proveedor."'";
		$cltvin=mysql_query($sqlvin,$cnn) or die(mysql_error());
		$rsvin=mysql_fetch_assoc($cltvin);

		$plazo=$rsvin['IdPlazo'];

		$sql="insert into orden_compra(IdProduccion, IdProveedor, VrCompra, VrIva, VrRetencion, VrNeto, VrReteIva, VrReteIca, VrReteFte, Usuario, FechaCreacion,IdPlazo, IdEstadoOrden) VALUES ('$produccion','$proveedor','$valorcompra','$totaliva','$valorreten','$valorneto','$totalreteiva','$totalreteica','$totalretefte' ,'$usuario','$fecha','$plazo', '1')";
		$cltcompra=mysql_query($sql,$cnn) or die(mysql_error());
		$idcompra=mysql_insert_id();


		$sqldet="SELECT compra_temp.IdProduccion, compra_temp.IdProveedor, compra_temp.VrTotal, compra_temp.Detalle, compra_temp.Cantidad, compra_temp.Dias, compra_temp.Ciudades, compra_temp.VrUnitario FROM compra_temp WHERE compra_temp.IdProduccion='".$produccion."' AND compra_temp.IdProveedor='".$proveedor."'";
		$cltdet=mysql_query($sqldet, $cnn) or die(mysql_error());

		while($rsdet=mysql_fetch_assoc($cltdet)){
			$detalle=$rsdet['Detalle'];
			$cantidad=$rsdet['Cantidad'];
			$dias=$rsdet['Dias'];
			$vrunit=$rsdet['VrUnitario'];
			$vrtot=$rsdet['VrTotal'];
			$iva=$rsdet['VrTotal']*$valoriva;
		
			$sqldetalle="insert into detalle_compra(IdOrden, Detalle, Cantidad, Dias, VrUnit, VrTotal, VrIva) values ('$idcompra','$detalle','$cantidad','$dias','$vrunit','$vrtot','$iva')";		
			$cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
		}

		$sqlorden="SELECT orden_compra.IdOrden, orden_compra.IdProduccion, orden_compra.IdProveedor, orden_compra.VrCompra, orden_compra.VrIva, orden_compra.VrRetencion, orden_compra.VrNeto, orden_compra.VrReteIva, orden_compra.VrReteIca, orden_compra.VrReteFte, orden_compra.Observacion, plazopago.Plazo FROM orden_compra LEFT JOIN plazopago ON orden_compra.IdPlazo = plazopago.IdPlazo WHERE orden_compra.IdOrden='".$idcompra."'";
		$cltorden=mysql_query($sqlorden,$cnn) or die(mysql_error());

		$pdf =& new Cezpdf('letter');
		$pdf -> selectFont('../fonts/courier.afm');
		$pdf -> ezSetCmMargins(1,1,2,1);

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
		$sqlproduccion="SELECT produccion.IdProduccion, produccion.Finalizada FROM produccion WHERE produccion.IdProduccion=".$produccion;

		$cltproduccion=mysql_query($sqlproduccion,$cnn) or die(mysql_error());
		$rsproduccion=mysql_fetch_assoc($cltproduccion);

		$prodfinalizada=$rsproduccion['Finalizada'];

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
							 '2'=>$rsprov['NombreProveedor'],
							 '3'=>'CONSECUTIVO:',
							 '4'=>$idcompra
							),
					   array(
							 '1'=>'NIT:',
							 '2'=>$rsprov['Identificacion'].' DV '.$rsprov['DV'],
							 '3'=>'TIPO PROVEEDOR:',
							 '4'=>$rsprov['TipoProveedor']
							),
					   array(
							 '1'=>'CONTACTO PROVEEDOR:',
							 '2'=>$rsprov['Representante'],
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
							 '4'=>$rsprov['Correo']
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
							 '3'=>'FACTURAR A NOMBRE DE:',
							 '4'=>$rsprov['NombreProveedor'],
							 '5'=>'FECHA APROBACION:',
							 '6'=>ConvFecha($rsnegocio['FechaCreacion'])
							),
						array(
							 '1'=>'FECHA EVENTO:',
							 '2'=>ConvFecha($rsproyecto['FechaEvento']),
							 '3'=>'NIT CLIENTE:',
							 '4'=>$rscliente['Identificacion'].' '.$rscliente['DV'],
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
						'fontSize'=> 8,
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
		
		$pdf->addJpegFromFile(Unidad($unidad),uPDF(2),uPDF(24.5),200,80);
		$pdf->addText(uPDF(14.5),uPDF(25),8,"ENTRETENIMIENTO SIN LIMITES LTDA");
		$pdf->addText(uPDF(17.5),uPDF(24.5),8,"NIT 900080794-6");
		$pdf->ezText("\n\n\n\n\n\n\n");
		$pdf->filledRectangle(uPDF(2.11),uPDF(23.65),uPDF(18),uPDF(0.5));
		$pdf->setColor(255,255,255);
		$pdf->addText(uPDF(9),uPDF(23.75),10,"ORDEN DE COMPRA");
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
	}
	mysql_close($cnn);
}
?>