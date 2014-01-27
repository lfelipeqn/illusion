<?php
    include ('../../Connections/cnn.php');
    require_once('../../classes/html2pdf/html2pdf.class.php');
    include('../../funciones.php');
    $conexion=mysql_select_db($rental_cnn,$cnn);
	$factura=$_GET['codigo'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sqlfact = "SELECT facturas.IdFactura, eventos.IdEvento, eventos.Evento, eventos.Dias, clientes.Identificacion, clientes.NombreCliente, clientes.Email, facturas.FechaEmision, facturas.FechaVencimiento, facturas.Subtotal, facturas.Impuesto, facturas.Total, facturas.Observaciones FROM facturas INNER JOIN eventos ON facturas.IdEvento = eventos.IdEvento INNER JOIN clientes ON eventos.IdCliente = clientes.Identificacion WHERE facturas.Idfactura='$factura'";
    $cltfact=mysql_query($sqlfact,$cnn) or die(mysql_error());
    $rsfactura=mysql_fetch_assoc($cltfact);
    
    $emision=split("-",$rsfactura['FechaEmision']);
    $vencimiento=split("-",$rsfactura['FechaVencimiento']);
    
    $sqldetalle="SELECT eventos_detalle.IdEvento, inventario.Codigo, categorias.Categoria, inventario.Articulo, eventos_detalle.ValorEquipo FROM eventos_detalle INNER JOIN inventario ON eventos_detalle.Codigo = inventario.Codigo INNER JOIN categorias ON inventario.IdCategoria = categorias.IdCategoria WHERE eventos_detalle.IdEvento='".$rsfactura['IdEvento']."'";
    $cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());    
    $html='
            <page>
            <link href="../styles/factura.css" rel="stylesheet" type="text/css" />
            <table class="head">
                <tr>
                    <td rowspan="2">
                        <img src="../images/rental_peq.jpg" class="imagen" />    
                    </td>
                    <td>
                        <p>Documento Interno de Cobro</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>'.$rsfactura['IdFactura'].'</div>
                    </td>
                </tr>
            </table>
            <br />
            <div class="fechas">
            <table>
                <tr>
                    <td rowspan="2">
                    <div class="contacto">
                        <table>
                            <tr>
                                <td>Contacto:</td>
                                <td>'.$rsfactura['NombreCliente'].'</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>'.$rsfactura['Email'].'</td>
                            </tr>   
                        </table>
                    </div>
                    </td>
                    <td class="titulo">Fecha de Emisi&oacute;n</td>
                    <td class="titulo">Fecha de Vencimiento</td>
                </tr>
                <tr>
                    <td>
                        <div class="contacto">
                            <table>
                                <tr>
                                    <td class="tipofg">'.$emision[0].'</td>
                                    <td class="tipofg">'.$emision[1].'</td>
                                    <td class="tipofg">'.$emision[2].'</td>
                                </tr>
                                <tr>
                                    <td class="tipof">D&iacute;a</td>
                                    <td class="tipof">Mes</td>
                                    <td class="tipof">A&ntilde;o</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="contacto">
                            <table>
                                <tr>
                                    <td class="tipofg">'.$vencimiento[0].'</td>
                                    <td class="tipofg">'.$vencimiento[1].'</td>
                                    <td class="tipofg">'.$vencimiento[2].'</td>
                                </tr>
                                <tr>
                                    <td class="tipof">D&iacute;a</td>
                                    <td class="tipof">Mes</td>
                                    <td class="tipof">A&ntilde;o</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            </div>
            <br />
            <table class="detalle">
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Equipo</th>
                    <th>Valor Unitario</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>';
    $i=1;
    while ($rsdetalle=mysql_fetch_assoc($cltdetalle)){
        if($i%2==0){
            $html.='<tr style="background:silver;">';    
        }else{
            $html.='<tr>';
        }
        
        $html.='<td>'.$rsdetalle['Categoria'].'</td>';
        $html.='<td>'.$rsdetalle['Articulo'].'</td>';
        $html.='<td class="valores2">'.aMoneda($rsdetalle['ValorEquipo']).'</td>';
        $html.='<td class="valores2">'.aMoneda($rsdetalle['ValorEquipo']*$rsfactura['Dias']).'</td>';
        $html.='</tr>';
        $i++;
    }
    $html.='
    </tbody>
    </table>
    <br />
    <table class="fechas">
        <tr>
            <td rowspan="3">
                <div class="observacion">
                    <b>Observaciones:</b>&nbsp;'.strtoupper($rsfactura['Observaciones']).'</div>
            </td>
            <td><b>Subtotal:</b></td>
            <td><div class="valores">'.aMoneda($rsfactura['Subtotal']).'</div></td>
        </tr>
        <tr>
            <td><b>Impuesto:</b></td>
            <td><div class="valores">'.aMoneda($rsfactura['Impuesto']).'</div></td>
        </tr>
        <tr>
            <td><b>Total:</b></td>
            <td><div class="valores">'.aMoneda($rsfactura['Total']).'</div></td>
        </tr>
    </table>
    <page_footer>
        <table class="foot">
            <tr>
                <td>______________________________</td>
                <td>______________________________</td>
                <td>______________________________</td>
            </tr>
            <tr>
                <td>Solicitante</td>
                <td>Direcci&oacute;n general</td>
                <td>Departamento Contabilidad</td>
            </tr>
        </table>
        <br />
        <div class="foot">Tel&eacute;fono: (571) 2360032 | Direcci&oacute;n Cr 46 No. 95 - 13 | Bogot&aacute; D.C. - Colombia</div>
    </page_footer>
    </page>';
    $html2pdf = new HTML2PDF('P','LETTER','en');
    $html2pdf->WriteHTML($html);
    $html2pdf->Output('factura.pdf','F');
    header("Location: ../rental.php?location=muestrafac");
?> 