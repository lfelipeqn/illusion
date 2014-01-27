<?php
    include ('../../Connections/cnn.php');
    require_once('../../classes/html2pdf/html2pdf.class.php');
    include('../../funciones.php');
    session_start();
	$norden=$_GET['norden'];
	$connect=mysql_select_db($database_cnn,$cnn);
    $html='';
if(isset($_SESSION['usuario'])){
    
    $html.='
            <link href="../styles/ordencompra.css" rel="stylesheet" type="text/css" />
            <page class=ordencompra>
            <table cellspacing="0">
                <tr>
                    <td><img src="../images/esl.jpg" /></td>
                    <td style="width:600px;">
                        <div style="text-align:right; padding-top:60px;"><b>ENTRETENIMIENTO SIN LIMITES LTDA</b></div>
                        <div style="text-align:right"><b>NIT 900080794-6</b></div>
                    </td>
                </tr>
            </table>';
    
    $html.='<br /><br /><div align="center" style="background-color:black; color:white; font-size:14px;">ORDEN DE COMPRA</div>
            <br />';

	$sqlcompra="SELECT orden_compra.IdOrden, orden_compra.IdProduccion, orden_compra.IdProveedor, 
    orden_compra.VrCompra, orden_compra.VrIva, orden_compra.VrRetencion, orden_compra.VrNeto, 
    orden_compra.VrReteIva, orden_compra.VrReteIca, orden_compra.VrReteFte, orden_compra.Observacion, 
    orden_compra.Usuario, orden_compra.FechaCreacion, orden_compra.IdPlazo 
    FROM orden_compra 
    WHERE orden_compra.IdOrden =".$norden;
    
	$cltcompra=mysql_query($sqlcompra,$cnn) or die(mysql_error());
	$rscompra=mysql_fetch_assoc($cltcompra);

	$sqlproveedor="SELECT proveedores.NombreProveedor, tipoidentificacion.TipoIdentificacion, proveedores.Identificacion, proveedores.DV, proveedores.Actividad, proveedores.Representante, proveedores.Correo, proveedores.Direccion FROM proveedores Inner Join tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo WHERE proveedores.Identificacion='".$_SESSION['usuario']."'";
	$cltproveedor=mysql_query($sqlproveedor,$cnn) or die(mysql_error());
    $rs=mysql_fetch_assoc($cltproveedor);
    
    $sqlorden="SELECT IdOrden, IdProduccion, IdProveedor, VrCompra, VrIva, VrRetencion, VrNeto, VrReteIva, VrReteIca, VrReteFte, Observacion, plazopago.Plazo FROM orden_compra LEFT JOIN plazopago ON orden_compra.IdPlazo = plazopago.IdPlazo WHERE IdOrden='".$norden."'";
	$cltorden=mysql_query($sqlorden,$cnn) or die(mysql_error());
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

	$sqlproduccion="SELECT produccion.IdProduccion, produccion.Finalizada FROM produccion WHERE produccion.IdProduccion=".$rsorden['IdProduccion'];
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

	$html.='
    <table style="widht=100%" cellspacing="0">
        <tr>
            <td></td>
            <td></td>
            <td class="titulo">FECHA DE ENVIO</td>
            <td class="detalle">'.date('d-m-Y').'</td>
        </tr>
        <tr>
            <td class="titulo">PROVEEDOR</td>
            <td class="detalle">'.$rs['NombreProveedor'].'</td>
            <td class="titulo">No. ORDEN COMPRA</td>
            <td class="detalle" style="color:red;">'.$norden.'</td>
        </tr>
        <tr>
            <td class="titulo">NIT</td>
            <td class="detalle">'.$rs['Identificacion'].' DV '.$rs['DV'].'</td>
            <td class="titulo">TIPO PROVEEDOR</td>
            <td class="detalle">'.$rs['Actividad'].'</td>
        </tr>
        <tr>
            <td class="titulo">CONTACTO PROVEEDOR</td>
            <td class="detalle">'.$rs['Representante'].'</td>
            <td class="titulo">PROYECTO</td>
            <td class="detalle">'.$rsproyecto['NombreProyecto'].'</td>
        </tr>
        <tr>
            <td class="titulo">DIRECCION</td>
            <td class="detalle">'.$rs['Direccion'].'</td>
            <td class="titulo">VR. ORDEN DE COMPRA</td>
            <td class="detalle">'.aMoneda($rsorden['VrCompra']).'</td>
        </tr>
        <tr>
            <td class="titulo">TIPO DE NEGOCIO</td>
            <td class="detalle">'.$tipon.'</td>
            <td class="titulo">EMAIL:</td>
            <td class="detalle">'.$rs['Correo'].'</td>
        </tr>
        <tr>
            <td class="titulo">PLAZO DE PAGO</td>
            <td class="detalle">'.strtoupper($rsorden['Plazo']).'</td>
            <td class="titulo">OBSERVACIONES</td>
            <td class="detalle">'.$rsorden['Observacion'].'</td>
        </tr>
    </table><br />';
    
    $html.='<br /><br /><div align="center" style="background-color:black; color:white; font-size:14px;">INFORMACION GENERAL</div><br />  
    <table cellspacing="0">
        <tr>
            <td class="titulo_gen" rowspan="2">No. NEGOCIO</td>
            <td class="detalle_gen" rowspan="2" style="font-size:24px;padding-right:10px;">'.$rsproyecto['IdProyecto'].'</td>
            <td class="titulo_gen">FACTURAR A:</td>
            <td class="detalle_gen">ENTRETENIMIENTO SIN LIMITES LTDA</td>
            <td class="titulo_gen">NIT CLIENTE</td>
            <td class="detalle_gen">900080794-6</td>
        </tr>
        <tr>
            <td class="titulo_gen">FECHA APROBACION</td>
            <td class="detalle_gen">'.ConvFecha($rsnegocio['FechaCreacion']).'</td>
            <td class="titulo_gen">FECHA EVENTO</td>
            <td class="detalle_gen">'.ConvFecha($rsproyecto['FechaEvento']).'</td>
        </tr>
    </table><br />';

    $html.='<br /><br /><div align="center" style="background-color:black; color:white; font-size:14px;">DETALLE DE LOS SERVICIOS</div><br />
        <table cellspacing="0">
            <thead>
                <tr>
                    <th>Detalle</th>
                    <th style="text-align:right;">Cantidad</th>
                    <th style="text-align:right;">Dias</th>
                    <th style="text-align:right;">Valor Unitario</th>
                    <th style="text-align:right;">Valor Total</th>
                    <th style="text-align:right;">Valor IVA</th>
                </tr>
            </thead>
            <tbody>';

	$sqldetalle="SELECT detalle_compra.IdOrden, detalle_compra.Detalle, detalle_compra.Cantidad, detalle_compra.Dias, detalle_compra.VrUnit, detalle_compra.VrTotal, detalle_compra.VrIva FROM detalle_compra WHERE detalle_compra.IdOrden =  '$norden'";
	$cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
	$totdetalle=mysql_num_rows($cltdetalle);
    $i=1;
	while($rsdetalle=mysql_fetch_assoc($cltdetalle)){
		$html.='<tr>';
        if($i%2==0){
            $html.='<td class="servicios_detalle" style="background-color:#F6F6F6">'.$rsdetalle['Detalle'].'</td>';
            $html.='<td class="servicios" style="background-color:#F6F6F6">'.number_format($rsdetalle['Cantidad'],0).'</td>';
            $html.='<td class="servicios" style="background-color:#F6F6F6">'.number_format($rsdetalle['Dias'],0).'</td>';
            $html.='<td class="servicios" style="background-color:#F6F6F6">'.aMoneda($rsdetalle['VrUnit']).'</td>';
            $html.='<td class="servicios" style="background-color:#F6F6F6">'.aMoneda($rsdetalle['VrTotal']).'</td>';
            $html.='<td class="servicios" style="background-color:#F6F6F6">'.aMoneda($rsdetalle['VrIva']).'</td>';
        }else{
            $html.='<td class="servicios_detalle">'.$rsdetalle['Detalle'].'</td>';
            $html.='<td class="servicios">'.number_format($rsdetalle['Cantidad'],0).'</td>';
            $html.='<td class="servicios">'.number_format($rsdetalle['Dias'],0).'</td>';
            $html.='<td class="servicios">'.aMoneda($rsdetalle['VrUnit']).'</td>';
            $html.='<td class="servicios">'.aMoneda($rsdetalle['VrTotal']).'</td>';
            $html.='<td class="servicios">'.aMoneda($rsdetalle['VrIva']).'</td>';    
        }
        $i++;
        $html.='</tr>';
	}
    $html.='</tbody></table>';
    
    $html.='<br /><br /><div align="center" style="background-color:black; color:white; font-size:14px;">DETALLE DE IMPUESTOS Y RETENCIONES</div><br />
    <table cellspacing="0">
        <tr>
            <td class="impuestos">(-) RETE IVA:</td>
            <td class="impuestos_detalle">'.aMoneda($rsorden['VrReteIva']).'</td>
            <td class="impuestos">(-) RETE ICA:</td>
            <td class="impuestos_detalle">'.aMoneda($rsorden['VrReteIca']).'</td>
            <td class="impuestos">(-) RETE FUENTE:</td>
            <td class="impuestos_detalle">'.aMoneda($rsorden['VrReteFte']).'</td>
        </tr>
    </table><br />';
    $html.='<div style="widht:100%; text-align:center">NOTA: La Informacion presentada en este formulario esta sujeta al contrato o lo acuerdos establecidos entre el PROVEEDOR y la COMPANIA prestadora del servicio.</div>';
    /*$html.='
    <page_footer>
        <hr>
        <div class="foot">        
            ORDEN DE COMPRA PROVISIONAL: Esta Orden de Compra es Provisional y no aplica para facturacion, sin embargo acepta por parte de ESL LTDA el compromiso de la prestacion del servicio
        </div>
    </page_footer>*/
    $html.='</page>';
    
    $html2pdf = new HTML2PDF('P','LETTER','en',false,"ISO-8859-1",array(10,10,10,10));
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('ordencompra.pdf','F');
    
    mysql_close($cnn);    
    header("Location: ../inicio.php?location=verorden");
}
?>
