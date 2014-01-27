<?php
	//session_start();
	include '../Connections/cnn.php';
if(isset($_SESSION['usuario'])){
    $cotizacion=$_GET['seguimiento'];
	$contador=1;
	$connect=mysql_select_db($rental_cnn,$cnn);
    
    ListaInventario();
    
    $sqlcotizacion="SELECT cotizacion.IdCotizacion, cotizacion.Fecha, cotizacion.IdCliente, cotizacion.IdPrecio, cotizacion.Elementos, cotizacion.Dias, cotizacion.Total, cotizacion.adicionales, cotizacion.Usuario FROM cotizacion WHERE cotizacion.IdCotizacion=".$cotizacion;
    $cltcotizacion=mysql_query($sqlcotizacion,$cnn) or die(mysql_error());
    $rscotizacion=mysql_fetch_assoc($cltcotizacion);
echo '
<div class="cuerpo">
  <form action="cotizaciones/actualcotiz.php" method="post" id="formdetalle">
  	<input type="hidden" id="nequipos" name="nequipos" value="'.$rscotizacion['Elementos'].'"/>
		<div align="left"><h2><span>Edici&oacute;n de </span>Cotizaci&oacute;n</h2></div>
		<hr>
		<p>Realice ahora las modificaciones que considere convenientes a la cotizaci&oacute;n</p>
		<table>
			<tr>
				<td><label style="font-weight:bold;font-size:10px">Elija el Cliente:</label></td>
				<td colspan="3">
                    <select id="ncliente" name="ncliente" style="width:300px">';
					   $sqlcliente="SELECT clientes.Identificacion, clientes.NombreCliente FROM clientes";
					   $cltcliente=mysql_query($sqlcliente,$cnn) or die(mysql_error());
					   $filas=mysql_num_rows($cltcliente);
					   echo '<option value="0">--- Elija un Cliente ---</option>';
					   while($rscliente=mysql_fetch_assoc($cltcliente)){
					       if($rscotizacion['IdCliente']==$rscliente['Identificacion']){
					           echo '<option value="'.$rscliente['Identificacion'].'" selected="selected">'.$rscliente['NombreCliente'].'</option>';
					       }else{
					           echo '<option value="'.$rscliente['Identificacion'].'">'.$rscliente['NombreCliente'].'</option>';   
					       }
					   }
				echo'</select></td>
			</tr>
			<tr>
				<td>
					<label style="font-weight:bold;font-size:10px">Tipo de Precio a Aplicar:</label>
				</td>
				<td colspan="3">
					<select id="tipop" name="tipop" style="width:300px">';
						$sqlop="SELECT tipo_precio.IdPrecio, tipo_precio.TipoPrecio, tipo_precio.Campo FROM tipo_precio";
						$cltop=mysql_query($sqlop,$cnn) or die(mysql_error());
						while($rsop=mysql_fetch_assoc($cltop)){
						  if($rsop['IdPrecio']==$rscotizacion['IdPrecio']){
						    echo '<option value="'.$rsop['IdPrecio'].'" selected="selected">'.$rsop['TipoPrecio'].'</option>';  
						  }else{
						    echo '<option value="'.$rsop['IdPrecio'].'">'.$rsop['TipoPrecio'].'</option>';  
						  }
						}
					echo '</select>
				</td>
			</tr>
            <tr>
                <td>
                    <label style="font-weight:bold;font-size:10px">D&iacute;as del Evento</label>
                </td>
                <td>
                    <input type="text" id="tdias" name="tdias" value="'.$rscotizacion['Dias'].'"/> 
                </td>
                <td>
                    <label style="font-weight:bold;font-size:10px">Valor Equipos</label>
                </td>
                <td>
                    <input type="text" id="tevento" name="tevento" value="'.aMoneda($rscotizacion['Total']).'" READONLY/>
                </td>
            </tr>
        </table>';
        echo '
        <table>
            <tr>
                <td valign="top">
                    <table id="tequipos" name="tequipos">
            			<thead>
            			<tr>
            				<th class="estilocelda"><label>Opciones</label></th>
            				<th class="estilocelda"><label>Codigo Equipo</label></th>
            				<th class="estilocelda"><label>Nombre Equipo</label></th>
            				<th class="estilocelda"><label>Valor Unitario</label></th>
            			</tr>
            			</thead>
            			<tbody id="cuerpo" name="cuerpo">';
                        
                        $sqldetcot="SELECT cotizacion_detalle.IdCotizacion, cotizacion_detalle.Codigo, inventario.Articulo, cotizacion_detalle.Valor FROM cotizacion_detalle INNER JOIN inventario ON cotizacion_detalle.Codigo = inventario.Codigo WHERE cotizacion_detalle.IdCotizacion =".$cotizacion;
                        $cltcot=mysql_query($sqldetcot,$cnn) or die(mysql_error());
                        $elementos=$rscotizacion['Elementos'];
                        $i=1;
                        while($rsdetcot=mysql_fetch_assoc($cltcot)){
                            echo '<tr>';
                                echo '<td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFilaC(\'tequipos\',this,\'cuerpo\')"/></td>';
                                echo '<td class="estilocontenido"><input type="text" id="ceq'.$i.'" name="ceq'.$i.'" onkeyup="NuevoElemento(event, this, \'tipop\')" value="0'.$rsdetcot['Codigo'].'"/></td>';
                                echo '<td class="estilocontenido"><input type="text" id="neq'.$i.'" name="neq'.$i.'" READONLY value="'.$rsdetcot['Articulo'].'" /></td>';
                                echo '<td class="estilocontenido"><input type="text" id="veq'.$i.'" name="veq'.$i.'" READONLY value="'.aMoneda($rsdetcot['Valor']).'"/></td>';
                            echo '</tr>';
                            $i++;
                        }
                            echo '<tr>';
                                echo '<td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFilaC(\'tequipos\',this,\'cuerpo\')"/></td>';
                                echo '<td class="estilocontenido"><input type="text" id="ceq'.$i.'" name="ceq'.$i.'" onkeyup="NuevoElemento(event, this, \'tipop\')" /></td>';
                                echo '<td class="estilocontenido"><input type="text" id="neq'.$i.'" name="neq'.$i.'" READONLY /></td>';
                                echo '<td class="estilocontenido"><input type="text" id="veq'.$i.'" name="veq'.$i.'" READONLY /></td>';
                            echo '</tr>';
                        echo '</tbody>
            		</table>
                </td>
                <td valign="top">
                    <table id="adicionales" name="adicionales">
                    <thead>
                        <tr>
                            <th class="estiloceldagr">Concepto</th>
                            <th class="estiloceldagr">Valor</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
                        //$sqlconcepto="SELECT conceptos.IdConcepto, conceptos.Concepto FROM conceptos ORDER BY conceptos.IdConcepto ASC";
                        $sqlconcepto="SELECT cotizacion_conceptos.IdCotizacion, conceptos.IdConcepto, conceptos.Concepto, cotizacion_conceptos.ValorConcepto FROM cotizacion_conceptos RIGHT JOIN conceptos ON cotizacion_conceptos.IdConcepto = conceptos.IdConcepto WHERE cotizacion_conceptos.IdCotizacion=$cotizacion OR cotizacion_conceptos.IdCotizacion IS NULL ORDER BY conceptos.IdConcepto ASC";
                        //$sqlconcepto="SELECT cotizacion_conceptos.IdCotizacion, cotizacion_conceptos.IdConcepto, conceptos.Concepto, cotizacion_conceptos.ValorConcepto FROM cotizacion_conceptos INNER JOIN conceptos ON cotizacion_conceptos.IdConcepto = conceptos.IdConcepto WHERE cotizacion_conceptos.IdCotizacion =".$cotizacion." ORDER BY conceptos.IdConcepto ASC";
                        $cltconcepto=mysql_query($sqlconcepto,$cnn) or die(mysql_error());
                        $total=mysql_num_rows($cltconcepto);
                        $x=1;
                        while($rsconcepto=mysql_fetch_assoc($cltconcepto)){
                            echo '<tr>';
                            echo '<td>
                                    <input type="hidden" id="concepto'.$x.'" name="concepto'.$x.'" value="'.$rsconcepto['IdConcepto'].'"/><label style="font-weight:bold;font-size:10px">'.$rsconcepto['Concepto'].'</label>
                                  </td>';
                            echo '<td><input type="text" id="valconcepto'.$x.'" name="valconcepto'.$x.'" value="'.aMoneda($rsconcepto['ValorConcepto']).'" onblur="FormatoN(this)"/></td>';
                            echo '</tr>';
                            $x++;
                        }
                        $x--;
              echo '</tbody>
                    <input type="hidden" id="ncotizacion" name="ncotizacion" value="'.$cotizacion.'"/>
                    <input type="hidden" id="tfilas" name="tfilas" value="'.$total.'"/>
                    </table>
                </td>
            </tr>
        </table>';
        
        echo '<hr style="alignmentwidth:500px; background-color:F00;"/>
        <div align="left"><input type="button" class="boton" value="Registrar Cotizaci&oacute;n" onclick="validarform(\'formdetalle\',\'cotizacion\')"/></div>
  </form>
</div>';
}
?>