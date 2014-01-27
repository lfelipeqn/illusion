<?php
    include ('../../Connections/cnn.php');
    require_once('../../classes/html2pdf/html2pdf.class.php');
    include('../../funciones.php');
	$idevento=$_GET['codigo'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	
    $sql="SELECT eventos.IdEvento, clientes.Identificacion, clientes.NombreCliente, eventos.Dias, eventos.Horas, eventos.Valor, 
    eventos.CostoEvento, proyectos.IdProyecto, proyectos.NombreProyecto AS Evento, proyectos.LugarEvento, proyectos.FechaMontaje AS FechaEntrega, 
    proyectos.FechaDesmontaje AS FechaRecogida, eventos.IdCotizacion 
    FROM eventos 
    INNER JOIN clientes ON eventos.IdCliente = clientes.Identificacion 
    INNER JOIN proyectos ON eventos.IdProyecto = proyectos.IdProyecto 
    WHERE eventos.IdEvento=".$idevento;
    
    
    $sqltoteq="SELECT Sum(eventos_detalle.ValorEquipo) AS ValorEquipos FROM eventos_detalle 
    WHERE eventos_detalle.IdEvento =".$idevento;
    
    $sqltotad="SELECT Sum(eventos_conceptos.ValorConcepto) AS ValorConceptos FROM eventos_conceptos 
    WHERE eventos_conceptos.IdEvento =".$idevento;
    
    $sqltotpv="SELECT Sum(eventos_proveedores.Valor) AS ValorProveedores FROM eventos_proveedores 
    WHERE eventos_proveedores.IdEvento =".$idevento;
    
    $cltoteq=mysql_query($sqltoteq,$cnn) or die(mysql_error());
    $rstoteq=mysql_fetch_assoc($cltoteq);
    
    $cltotad=mysql_query($sqltotad,$cnn) or die(mysql_error());
    $rstotad=mysql_fetch_assoc($cltotad);
    
    $cltotpv=mysql_query($sqltotpv,$cnn) or die(mysql_error());
    $rstotpv=mysql_fetch_assoc($cltotpv);
    
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());    
    
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
    $html.='<td class="descrip">No. Evento:</td>';
    $html.='<td class="contenido">'.$rs['IdProyecto'].'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Fecha Montaje:</td>';
    $html.='<td class="contenido">'.$rs['FechaEntrega'].'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Fecha Desmontaje:</td>';
    $html.='<td class="contenido">'.$rs['FechaRecogida'].'</td>';
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
    $html.='<td class="descrip">Valor Equipos:</td>';
    $html.='<td class="contenido">'.aMoneda($rstoteq['ValorEquipos']*$dias).'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Costo de Produccion:</td>';
    $html.='<td class="contenido">'.aMoneda($rstotpv['ValorProveedores']*$dias).'</td>';
    $html.='</tr>';
    $html.='<tr>';
    $html.='<td class="descrip">Costos Adicionales:</td>';
    $html.='<td class="contenido">'.aMoneda($rstotad['ValorConceptos']*$dias).'</td>';
    $html.='</tr>';
    $html.='</table><br />';
    
    
    $sqldetalle="SELECT eventos_detalle.Fecha, eventos_detalle.Codigo, eventos_detalle.ValorEquipo, eventos_detalle.Dias, eventos_detalle.Entrada, eventos_detalle.IdEvento, inventario.Articulo, categorias.Categoria, eventos.Dias FROM eventos_detalle INNER JOIN inventario ON eventos_detalle.Codigo = inventario.Codigo INNER JOIN categorias ON inventario.IdCategoria = categorias.IdCategoria INNER JOIN eventos ON eventos.IdEvento = eventos_detalle.IdEvento WHERE eventos_detalle.IdEvento=".$idevento;
  	$cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
      
      $html.='<div class="titulo">Detalle de Equipos</div>
      <br />
      <table class="detalle">
        <thead>
            <tr>
                <th style="width:130px">Categoria</th>
                <th style="width:310px">Articulo</th>
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
            $html.='<td class="moneda">'.aMoneda($rsdetalle['ValorEquipo']).'</td>';
            $html.='<td class="moneda">'.aMoneda($dias*$rsdetalle['ValorEquipo']).'</td>';
            $html.='</tr>';
            $valorevento+=$dias*$rsdetalle['ValorEquipo'];
            $i++;
        }    
        
        $html.='</tbody>
        </table>
        <br />
        <div class="titulo">Detalle de Personal</div>';
            
        $sqlproveedor="SELECT eventos_proveedores.IdEvento, proveedores.Identificacion, proveedores.NombreProveedor, proveedores_tipo.Tipo, proveedores_nivel.Nivel, eventos_proveedores.Valor FROM eventos_proveedores INNER JOIN proveedores ON eventos_proveedores.IdProveedor = proveedores.Identificacion INNER JOIN proveedores_tipo ON eventos_proveedores.IdTipo = proveedores_tipo.IdTipo INNER JOIN proveedores_nivel ON eventos_proveedores.IdNivel = proveedores_nivel.IdNivel WHERE eventos_proveedores.IdEvento=".$idevento;    
        $cltproveedor=mysql_query($sqlproveedor,$cnn) or die(mysql_error());
        
        $html.='
        <table>
            <thead>
                <tr>
                    <th style="width:95px">Servicio</th>
                    <th style="width:290px">Proveedor</th>
                    <th style="width:150px">Nivel</th>
                    <th style="width:40px">Dias</th>
                    <th>Valor Unitario</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>';
        $i=1;    
        while($rsproveedor=mysql_fetch_assoc($cltproveedor)){
            if ($i%2==0){
                $html.='<tr class="renglon">';   
            }else{
                $html.='<tr>';
            }
            $html.='<td>'.$rsproveedor['Tipo'].'</td>';
            $html.='<td>'.$rsproveedor['NombreProveedor'].'</td>';
            $html.='<td>'.$rsproveedor['Nivel'].'</td>';
            $html.='<td>'.$dias.'</td>';
            $html.='<td>'.aMoneda($rsproveedor['Valor']).'</td>';
            $html.='<td>'.aMoneda($dias*$rsproveedor['Valor']).'</td>';
            $html.='</tr>';           
            $costoevento+=$dias*$rsproveedor['Valor'];
            $i++;
        }
 
 
    $html.='</tbody>
    </table>
    
    <br />
    <div class="titulo">Detalle de Adicionales</div>';
    
    $sqladicionales="SELECT conceptos.Concepto, eventos_conceptos.ValorConcepto FROM eventos_conceptos INNER JOIN conceptos ON eventos_conceptos.IdConcepto = conceptos.IdConcepto WHERE eventos_conceptos.IdEvento =".$idevento;     
    $cltadicionales=mysql_query($sqladicionales,$cnn) or die(mysql_error());
    
    $html.='
        <table>
            <thead>
                <tr>
                    <th style="width:650px">Concepto</th>
                    <th style="width:100px">Valor</th>
                </tr>
            </thead>
            <tbody>';
        $i=1;    
        while($rsadicionales=mysql_fetch_assoc($cltadicionales)){
            if ($i%2==0){
                $html.='<tr class="renglon">';   
            }else{
                $html.='<tr>';
            }
            $html.='<td>'.$rsadicionales['Concepto'].'</td>';
            $html.='<td>'.aMoneda($rsadicionales['ValorConcepto']).'</td>';
            $html.='</tr>';           
            $i++;
        }
    $html.='</tbody>
    </table>
    <page_footer>
        <div class="foot">Tel&eacute;fono: (571) 2360032 | Direcci&oacute;n Cr 46 No. 95 - 13 | Bogot&aacute; D.C. - Colombia</div>
    </page_footer>
    </page>';
    
    $html2pdf = new HTML2PDF('P','LETTER','en',false,"ISO-8859-1",array(10,10,10,10));
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('evento.pdf','F');
    header("Location: ../rental.php?location=muestraevt");
?>