<?php
	include ('../Connections/cnn.php');

if(isset($_SESSION['usuario'])){
	$evento=$_GET['codigo'];
	$proveedor=$_GET['proveedor'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	
	$sqlorden="SELECT orden_compra.IdOrden, orden_compra.IdEvento, orden_compra.IdProveedor, orden_compra.Fecha FROM orden_compra WHERE orden_compra.IdEvento ='".$evento."' AND orden_compra.IdProveedor ='".$proveedor."'";
	$cltorden=mysql_query($sqlorden,$cnn) or die(mysql_error());
	$totorden=mysql_num_rows($cltorden);
	if ($totorden<1){
		$fecha=date("Y-m-d");
		$sqlord="INSERT INTO orden_compra (IdEvento, IdProveedor, Fecha) VALUES ('".$evento."','".$proveedor."','".$fecha."')";
		$cltord=mysql_query($sqlord,$cnn) or die(mysql_error());
		$idorden=mysql_insert_id();
	}else{
		$rsorden=mysql_fetch_assoc($cltorden);
		$idorden=$rsorden['IdOrden'];
		$fecha=$rsorden['Fecha'];
	}
	
	$sqlprov="SELECT proveedores.Identificacion, proveedores.DV, tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion, proveedores.NombreComercial, proveedores.NombreProveedor, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.IdTipoProveedor, proveedores_tipo.Tipo, proveedores.IVA, proveedores.ReteIva, proveedores.ReteIca, proveedores.ReteFte, plazopago.IdPlazo, plazopago.Plazo, proveedores.Observaciones FROM proveedores INNER JOIN tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo INNER JOIN proveedores_tipo ON proveedores.IdTipoProveedor = proveedores_tipo.IdTipo INNER JOIN plazopago ON proveedores.IdPlazo = plazopago.IdPlazo WHERE proveedores.Identificacion=".$proveedor;

	$cltprov=mysql_query($sqlprov,$cnn) or die(mysql_error());
	$rsprov=mysql_fetch_assoc($cltprov) or die(mysql_error());
	
	$sqlevt="SELECT
eventos.IdEvento,
clientes.Identificacion,
clientes.NombreCliente,
eventos.Dias,
eventos.Horas,
eventos.Valor,
eventos.CostoEvento,
proyectos.IdProyecto,
proyectos.NombreProyecto AS Evento,
proyectos.LugarEvento,
proyectos.FechaMontaje AS FechaEntrega,
proyectos.FechaDesmontaje AS FechaRecogida,
eventos.IdCotizacion
FROM
eventos
INNER JOIN clientes ON eventos.IdCliente = clientes.Identificacion
INNER JOIN proyectos ON eventos.IdProyecto = proyectos.IdProyecto WHERE eventos.IdEvento=".$evento;
	$cltevt=mysql_query($sqlevt,$cnn) or die(mysql_error());
	$rsevt=mysql_fetch_assoc($cltevt);
	
	$pdf = new FPDF();
	$pdf->AddPage();
	//$pdf->SetMargins(30,30,30);
	$pdf->SetFont('Arial','',12);
	$pdf->Image('images/rental_peq.png',10,10,80,20);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell('',20,"eslrental",0,'R',0);
	$pdf->Ln(5);
	$pdf->Cell('',20,"Nit: 8909876-5",0,'R',0);
	$pdf->SetFont('Arial','',10);
	
	$pdf->Ln(20);
	$pdf->SetFillColor(230,50,47);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell('',5,'ORDEN DE COMPRA',0,1,'C',true);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell('','',"CONSECUTIVO:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$idorden,0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"FECHA DE GENERACION:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',NormalFecha($fecha),0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"PROVEEDOR:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsprov['NombreProveedor'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"IDENTIFICACION:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsprov['Identificacion'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"DIRECCION:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsprov['Direccion'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"EMAIL:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsprov['Correo'],0,1,'R');
	$pdf->Ln(5);
	
	$pdf->SetFillColor(20,179,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell('',5,'INFORMACION DEL EVENTO',0,1,'C',true);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell('','',"EVENTO:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsevt['IdProyecto'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"NOMBRE EVENTO:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsevt['Evento'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"CLIENTE:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsevt['NombreCliente'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"LUGAR EVENTO:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsevt['LugarEvento'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"FECHA ENTREGA EQUIPOS:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsevt['FechaEntrega'],0,1,'R');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell('','',"FECHA RECOGIDA EQUIPOS:",0,1,'L');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell('','',$rsevt['FechaRecogida'],0,1,'R');
	
	$pdf->Ln(5);
	$pdf->SetFillColor(1,61,134);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell('',5,'DETALLE DE LOS SERVICIOS',0,1,'C',true);
	$pdf->SetTextColor(0,0,0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Rect(10,125,50,5,'D');
	$pdf->Rect(60,125,80,5,'D');
	$pdf->Rect(140,125,59.5,5,'D');
	$pdf->Cell('30',5,'Categoria',0,0,'R');
	$pdf->Cell('65',5,'Servicio',0,0,'R');
	$pdf->Cell('70',5,'Valor',0,0,'R');
	
	$sqldetalle="SELECT eventos_proveedores.IdEvento, eventos_proveedores.IdProveedor, eventos_proveedores.Valor, proveedores.NombreProveedor, proveedores_tipo.IdTipo, proveedores_tipo.Tipo, proveedores_nivel.IdNivel, proveedores_nivel.Nivel FROM eventos_proveedores INNER JOIN proveedores ON eventos_proveedores.IdProveedor = proveedores.Identificacion INNER JOIN proveedores_tipo ON eventos_proveedores.IdTipo = proveedores_tipo.IdTipo INNER JOIN proveedores_nivel ON eventos_proveedores.IdNivel = proveedores_nivel.IdNivel WHERE eventos_proveedores.IdEvento='".$evento."' AND eventos_proveedores.IdProveedor='".$proveedor."'";
	$cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
	$y=130;
	$total=0;
	while($rsdetalle=mysql_fetch_assoc($cltdetalle)){
		$pdf->Rect(10,$y,50,5,'D');
		$pdf->Rect(60,$y,80,5,'D');
		$pdf->Rect(140,$y,59.5,5,'D');
		$pdf->Ln(5);
		$pdf->Cell('50',5,$rsdetalle['Tipo'],0,0,'L');
		$pdf->Cell('55',5,$rsdetalle['Nivel'],0,0,'L');
		$pdf->Cell('',5,aMoneda($rsdetalle['Valor']),0,0,'R');
		$y+=5;
		$total+=$rsdetalle['Valor'];
	}
	$pdf->Ln(5);
	$pdf->Rect(140,$y,59.5,5,'D');
	$pdf->Cell('',5,aMoneda($total),0,0,'R');
	
	$pdf->Ln(10);
	$pdf->Cell('26',5,'(-) RETE IVA:',0,0,'R');
	$pdf->Rect(10,$y+10,31.5,5,'D');
	$pdf->Cell('37',5,aMoneda($rsprov['ReteIva']*$total),0,0,'R');
	$pdf->Rect(41.5,$y+10,31.5,5,'D');
	$pdf->Cell('26',5,'(-) RETE ICA:',0,0,'R');
	$pdf->Rect(73,$y+10,31.5,5,'D');
	$pdf->Cell('37',5,aMoneda($rsprov['ReteIca']*$total),0,0,'R');
	$pdf->Rect(104.5,$y+10,31.5,5,'D');
	$pdf->Cell('26',5,'(-) RETE FTE.:',0,0,'R');
	$pdf->Rect(136,$y+10,31.5,5,'D');
	$pdf->Cell('37',5,aMoneda($rsprov['ReteFte']*$total),0,0,'R');
	$pdf->Rect(167.5,$y+10,31.5,5,'D');
	

	mysql_close($cnn);
	$pdf->SetY(-34);
	$pdf->SetDrawColor(204,0,0);
	$pdf->SetLineWidth(0.5);
	$pdf->Line(10,265,200,265);
	$pdf->SetFont('Arial','',8.5);
	$pdf->Cell('',10,'NOTA: La Informacion presentada en este formulario esta sujeta al contrato o lo acuerdos establecidos entre el PROVEEDOR y la EMPRESA',0,0,'L');

	$archivo = 'OrdenCompra.pdf';
	$pdf->Output($archivo,'F');

echo '
<div class="cuerpo">
		<h2><span>Orden </span> de Compra</h2>
		<p class="p0">A Continuaci&oacute;n se presenta la Orden de Compra para el proveedor seleccionado</p>
		<br />
		<object type="application/pdf" data="'.$archivo.'" width="80%" height="650" ></object>
</div>';
}
?>