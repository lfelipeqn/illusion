<?php
    include ('../../Connections/cnn.php');
    require_once('../../classes/html2pdf/html2pdf.class.php');
    include('../../funciones.php');
	$idcotizacion=$_GET['seguimiento'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sql="SELECT cotizacion.IdCotizacion,cotizacion.Fecha, clientes.Identificacion, clientes.NombreCliente, tipo_precio.IdPrecio, tipo_precio.TipoPrecio, tipo_precio.Campo, cotizacion.Elementos, cotizacion.Total, cotizacion.Usuario, cotizacion.Dias, cotizacion.adicionales, cotizacion.descuento FROM cotizacion INNER JOIN clientes ON cotizacion.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio WHERE cotizacion.IdCotizacion=".$idcotizacion;
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
    
    $sqltotal="SELECT Sum(cotizacion_detalle.Valor) AS ValorEquipos, Count(cotizacion_detalle.Codigo) AS TotalEquipos FROM cotizacion_detalle WHERE cotizacion_detalle.IdCotizacion =".$idcotizacion;
    $cltotal=mysql_query($sqltotal,$cnn) or die(mysql_error());
    $rstotal=mysql_fetch_assoc($cltotal);
        
    $html='';
    $html='<page>
            <link href="../styles/eventos.css" rel="stylesheet" type="text/css" />
            <table class="header">
                <tr>
                    <td>
                        <img src="../images/rental_peq.jpg" class="imagen" />    
                    </td>
                    <td>
                        <div>esl rental Nit: 8909876-5</div>
                    </td>
                </tr>
            </table>
            <br />
            <div class="titulo">Informaci&oacute;n General</div>
            <br />
            <table>';        
    
    $rs=mysql_fetch_assoc($consulta);	
	$identificacion=$rs['Identificacion'];
    $dias=$rs['Dias'];
    
    $html.='<tr>';
    $html.='<td class="descrip">Cotizacion:</td>';
    $html.='<td class="contenido">'.$rs['IdCotizacion'].'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Fecha Generacion:</td>';
    $html.='<td class="contenido">'.ConvFecha($rs['Fecha']).'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Nombre Cliente:</td>';
    $html.='<td class="contenido">'.$rs['NombreCliente'].'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Identificacion:</td>';
    $html.='<td class="contenido">'.$identificacion.'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Cantidad Equipos:</td>';
    $html.='<td class="contenido">'.$rstotal['TotalEquipos'].'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Dias del Evento:</td>';
    $html.='<td class="contenido">'.$rs['Dias'].'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Subtotal Equipos:</td>';
    $html.='<td class="contenido">'.aMoneda($rstotal['ValorEquipos']*$dias).'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Descuento Aplicado:</td>';
    $html.='<td class="contenido">'.($rs['descuento']*100).' %</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Valor Equipos con Descuento:</td>';
    $totdesc=($rstotal['ValorEquipos']*$dias)-($rstotal['ValorEquipos']*$dias*$rs['descuento']);
    $html.='<td class="contenido">'.aMoneda($totdesc).'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Total Adicionales:</td>';
    $html.='<td class="contenido">'.aMoneda($rs['adicionales']).'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Total Evento:</td>';
    $html.='<td class="contenido">'.aMoneda($totdesc+$rs['adicionales']).'</td>';
    $html.='</tr>';
    $html.='</table><br />';
    
    $sqldetalle="SELECT cotizacion_detalle.Codigo, categorias.IdCategoria, categorias.Categoria, inventario.Articulo, inventario.PrecioComercial, inventario.PrecioAlianza FROM cotizacion_detalle INNER JOIN inventario ON cotizacion_detalle.Codigo = inventario.Codigo INNER JOIN categorias ON inventario.IdCategoria = categorias.IdCategoria WHERE cotizacion_detalle.IdCotizacion=".$idcotizacion." ORDER BY IdCategoria, Codigo";
	$cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
      
    $html.='<div class="titulo">Detalle de la Cotización</div>
      <br />
      <table class="detalle">
        <thead>
            <tr>
                <th style="width:100px">Categoria</th>
                <th style="width:330px">Articulo</th>
                <th style="width:50px">Dias</th>
                <th>Valor Unitario</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>';

        $valorevento=0;
        $i=1;
    while($rsdetalle=mysql_fetch_assoc($cltdetalle)){
               if ($i%2==0){
                   $html.='<tr class="renglon">';   
               }else{
                   $html.='<tr>';
               }
               $html.='<td>'.$rsdetalle['Categoria'].'</td>';
               $html.='<td>'.$rsdetalle['Articulo'].'</td>';
               $html.='<td>'.$dias.'</td>';
               $html.='<td class="moneda">'.aMoneda($rsdetalle[$rs['Campo']]).'</td>';
               $html.='<td class="moneda">'.aMoneda($dias*$rsdetalle[$rs['Campo']]).'</td>';
               $html.='</tr>';
               $valorevento+=$dias*$rsdetalle[$rs['Campo']];
               $i++;
           }    
        
        $html.='</tbody>
        </table>
        <br />
        <div class="titulo">Detalle de Adicionales</div>';
            
        $sqlconceptos="SELECT conceptos.IdConcepto, cotizacion_conceptos.IdCotizacion, conceptos.Concepto, cotizacion_conceptos.ValorConcepto FROM conceptos INNER JOIN cotizacion_conceptos ON cotizacion_conceptos.IdConcepto = conceptos.IdConcepto WHERE cotizacion_conceptos.IdCotizacion=".$idcotizacion;    
        $cltconceptos=mysql_query($sqlconceptos,$cnn) or die(mysql_error());
        
        $html.='
        <table>
            <thead>
                <tr>
                    <th style="width:390px">Tipo de Adicional</th>
                    <th style="width:350px">Valor del Adicional</th>
                </tr>
            </thead>
            <tbody>';
        $i=1;    
        while($rsconceptos=mysql_fetch_assoc($cltconceptos)){
            if ($i%2==0){
                $html.='<tr class="renglon">';   
            }else{
                $html.='<tr>';
            }
            $html.='<td>'.$rsconceptos['Concepto'].'</td>';
            $html.='<td class="moneda">'.aMoneda($rsconceptos['ValorConcepto']).'</td>';
            $html.='</tr>';           
            $valorevento-=$dias*$rsproveedor['Valor'];
            $i++;
        }
 
    $html.='</tbody>
    </table>
    <page_footer>
        <hr>
        <div class="foot">NOTA: La Informacion presentada en este formulario esta sujeta al contrato o lo acuerdos establecidos entre el PROVEEDOR y la EMPRESA</div>
    </page_footer>
    </page>';
    
    $html2pdf = new HTML2PDF('P','LETTER','en',false,"ISO-8859-1",array(10,10,10,10));
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('cotizacion.pdf','F');
    header("Location: ../rental.php?location=verct");
?>