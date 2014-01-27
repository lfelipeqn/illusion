<?php
//	session_start();
	include ('Connections/cnn.php');
	include('class.ezpdf.php');
    
if(isset($_SESSION['usuario'])){
	
    $connect=mysql_select_db($database_cnn,$cnn);
    $idpresupuesto=$_GET['seguimiento'];
    
	$sql="SELECT clientes.NombreCliente AS NombreCliente, proyectos.NombreProyecto AS NombreProyecto, proyectos.NombreContacto AS NombreContacto, proyectos.Ciudades AS Ciudades, presupuestos.IdPresupuesto AS IdPresupuesto, presupuestos.Presupuesto AS Presupuesto, presupuestos.Version AS Version, presupuestos.IdProyecto AS IdProyecto, presupuestos.FechaPresentacion AS FechaPresentacion, presupuestos.FormaPago AS FormaPago, presupuestos.Subtotal AS Subtotal, presupuestos.Descuento AS Descuento, presupuestos.KnowHow AS KnowHow, presupuestos.Total AS Total, presupuestos.FechaAprobacion AS FechaAprobacion, presupuestos.IdUnidad AS IdUnidad, tipoempresa.TipoEmpresa AS TipoEmpresa, usuarios.Nombre AS Presentadopor, usuarios.Usuario FROM ((presupuestos INNER JOIN proyectos ON ((proyectos.IdProyecto = presupuestos.IdProyecto))) INNER JOIN clientes ON ((clientes.IdCliente = proyectos.IdCliente))) INNER JOIN tipoempresa ON tipoempresa.IdTipo = clientes.TipoEmpresa INNER JOIN usuarios ON presupuestos.Presentadopor = usuarios.Usuario where (presupuestos.IdPresupuesto = '$idpresupuesto')";
    $consulta=mysql_query($sql,$cnn) or die(mysql_error());


	$pdf = new Cezpdf('letter');
	$pdf -> selectFont('../fonts/courier.afm');
	$pdf -> ezSetCmMargins(1,1,2,1);

	while ($rs=mysql_fetch_assoc($consulta)){
//		$codpresentado=$rs['IdUsuario'];
		if ($rs['FechaAprobacion']==0){
			$fechaaprob='';
		}else{
			$fechaaprob=ConvFecha($rs['FechaAprobacion']);
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
							 '1'=>'TIPO DE CLIENTE:',
							 '2'=>$rs['TipoEmpresa'],
							 '3'=>'FECHA APROBACION:',
							 '4'=>$fechaaprob
							),
					   array(
							 '1'=>'PROYECTO:',
							 '2'=>$rs['NombreProyecto'],
							 '3'=>'FECHA PRESENTACION:',
							 '4'=>ConvFecha($rs['FechaPresentacion'])
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
		$unidad=$rs['IdUnidad'];
	};

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
    
    $pdf->addJpegFromFile(Unidad($unidad),uPDF(2),uPDF(24.5),100,80);
	$pdf->addText(uPDF(14.5),uPDF(25),8,"ENTRETENIMIENTO SIN LIMITES LTDA");
	$pdf->addText(uPDF(17.5),uPDF(24.5),8,"NIT 900080794-6");
	$pdf->ezText("\n\n\n\n\n\n\n");
	$pdf->filledRectangle(uPDF(2.11),uPDF(23.65),uPDF(18),uPDF(0.5));
	$pdf->setColor(255,255,255);
	$pdf->addText(uPDF(9),uPDF(23.75),10,"HOJA DE PRESUPUESTO");
	$pdf->setColor(0,0,0);
	$pdf->ezTable($datos,'','',$opciones);
	$pdf->ezText("\n");
    
    $sql1="SELECT procesos.IdProceso, procesos.NombreProceso, procesos.NombreTabla FROM procesos";				
	$consulta1=mysql_query($sql1,$cnn) or die(mysql_error());
    $titulo='';
	$subtit='';
	$desc=0;

	$valida=false;
	while($rs1=mysql_fetch_assoc($consulta1)){
		if($titulo!=$rs1['NombreProceso']) $titulo=$rs1['NombreProceso'];
			$sql2="select * from categorias where IdProceso=".$rs1['IdProceso'];
			$categorias=mysql_query($sql2,$cnn) or die(mysql_error());
			$subt=0;
			while($rs2=mysql_fetch_assoc($categorias)){
				$sql3="SELECT * FROM ".$rs1['NombreTabla']." WHERE ((Tipo='".$rs2['NombreCategoria']."') AND (IdPresupuesto='".$idpresupuesto."'))";
				$detalle=mysql_query($sql3,$cnn) or die(mysql_error());
				if (mysql_num_rows($detalle)>=1){
				unset($contenido);
				if ($valida==false){
					$pdf->ezText("<b>".strtoupper($titulo)."</b>",12);
					$valida=true;
				}
				while ($rs3=mysql_fetch_assoc($detalle)){
					$subt+=$rs3['VrTotal'];
					if($subtit!=$rs2['NombreCategoria']) $subtit=$rs2['NombreCategoria'];
					$contenido[]= array(
									'Descripción'=>$rs3['Descripcion'],
									'Cantidad'=>number_format($rs3['Cantidad'],0),
									'Días'=>number_format($rs3['Dias'],0),
									'Valor Unitario'=>"$ ".number_format($rs3['VrUnitario'],2),
									'Valor Total'=>"$ ".number_format($rs3['VrTotal'],2)
									);
				}
				$pdf->ezTable($contenido,'',$subtit,$optablas);
				}
			}

			$valida=false;
			if($subt>0){
				$pdf->ezText("");
				$subtotal[]= array('1'=>'SUBTOTAL','2'=>"$ ".number_format($subt,2));
				$pdf->ezTable($subtotal,'','',$opsubt);
			}
			unset($subtotal);
	}
	
    mysql_close($cnn);
 
	$pdf->ezText("\n");
	$pdf->ezTable($totales,'','',$optotal);
	$pdf->ezText("A esta cotización hay que sumarle el 16% de IVA\n\nNOTA:\n1. Antes de iniciar cualquier proyecto, es indispensable la orden de producción o el documento que se asemeje.\n2. Entretenimiento sin Limites ltda, hará para cada proyecto aprobado un contrato comercial, el cual ira firmado por las compañías.\n3. los valores establecidos en el presente presupuesto pueden variar si las condiciones aquí plasmadas cambian. \n4. Entretenimiento sin Limites ltda, no  asume ningún ítem aquí no especificado.\n\n",7,$opnota);
	$pdf->ezText("ENTRETENIMIENTO SIN LIMITES LTDA | NIT. 900080794-6 | PBX: (571) 8053100 - 8053138",7,$opnota);

	$documento_pdf = $pdf->ezOutput();
	$archivo = 'presupuesto.pdf';
	$fichero = fopen($archivo,'wb');
	fwrite ($fichero, $documento_pdf);
	fclose ($fichero);
	
echo '
<div class="cuerpo">
	<h3>Consulta de <span>Presupuestos</span></h3>
	<p class="p0">A Continuaci&oacute;n se presenta el presupuesto seleccionado</p>
	<br />
	<object type="application/pdf" data="'.$archivo.'" width="80%" height="650" ></object>
</div>';
}
?>