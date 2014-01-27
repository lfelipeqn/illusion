<?php
	//session_start();
	include '../Connections/cnn.php';
if(isset($_SESSION['usuario'])){
	$contador=1;
	$connect=mysql_select_db($rental_cnn,$cnn);
	ListaInventario();
?>
<div class="cuerpo">
  <form action="cotizaciones/creacotizacion.php" method="post" id="formdetalle">
  	<input type="hidden" id="nequipos" name="nequipos" value="1"/>
		<div align="left"><h2><span>Cotizacion de </span>Equipos</h2></div>
		<hr />
		<p>Por Favor ejecute ahora la lectura de los codigos de cada equipo a incluir en el evento o digite manualmente el c&oacute;digo del mismo.</p>
		<table>
			<tr>
				<td><label style="font-weight:bold;font-size:10px">Elija el Cliente:</label></td>
				<td colspan="3"><select id="scliente" name="scliente" style="width:300px">
                <?
					$sqlcliente="SELECT clientes.Identificacion, clientes.NombreCliente FROM clientes";
					$cltcliente=mysql_query($sqlcliente,$cnn) or die(mysql_error());
					$filas=mysql_num_rows($cltcliente);
					echo '<option value="0">--- Elija un Cliente ---</option>';
					while($rscliente=mysql_fetch_assoc($cltcliente)){
						echo '<option value="'.$rscliente['Identificacion'].'">'.$rscliente['NombreCliente'].'</option>';
					}
                ?>
				</select></td>
			</tr>
            <tr>
                <td><label style="font-weight:bold;font-size:10px">Elija el Proyecto:</label></td>
				<td colspan="3">
                    <select id="sproy" name="sproy" style="width:300px">
                        <option value="">--- Elija un Proyecto ---</option>
				    </select>
                </td>
            </tr>
			<tr>
				<td>
					<label style="font-weight:bold;font-size:10px">Tipo de Precio a Aplicar:</label>
				</td>
				<td colspan="3">
					<select id="tipop" name="tipop" style="width:300px">
                    <?
						$sqlop="SELECT tipo_precio.IdPrecio, tipo_precio.TipoPrecio, tipo_precio.Campo FROM tipo_precio";
						$cltop=mysql_query($sqlop,$cnn) or die(mysql_error());
						while($rsop=mysql_fetch_assoc($cltop)){
							echo '<option value="'.$rsop['IdPrecio'].'">'.$rsop['TipoPrecio'].'</option>';
						}
                    ?>
					</select>
				</td>
			</tr>
            <tr>
                <td>
                    <label style="font-weight:bold;font-size:10px">D&iacute;as del Evento</label>
                </td>
                <td>
                    <input type="text" id="tdias" name="tdias" /> 
                </td>
                <td>
                    <label style="font-weight:bold;font-size:10px">Valor Equipos</label>
                </td>
                <td>
                    <input type="text" id="tevento" name="tevento" value="0" READONLY />
                </td>
            </tr>
        </table>
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
            			<tbody id="cuerpo" name="cuerpo"><tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFilaC('tequipos',this,'cuerpo')"/></td><td class="estilocontenido"><input type="text" id="ceq1" name="ceq1" onkeyup="NuevoElemento(event, this, 'tipop')" /></td><td class="estilocontenido"><input type="text" id="neq1" name="neq1" readonly="readonly" /></td><td class="estilocontenido"><input type="text" id="veq1" name="veq1" readonly="readonly" /></td></tr></tbody>
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
                    <tbody>
                    <?
                        $sqlconcepto="SELECT conceptos.IdConcepto, conceptos.Concepto FROM conceptos ORDER BY conceptos.IdConcepto ASC";
                        $cltconcepto=mysql_query($sqlconcepto,$cnn) or die(mysql_error());
                        $total=mysql_num_rows($cltconcepto);
                        $x=1;
                        while($rsconcepto=mysql_fetch_assoc($cltconcepto)){
                            echo '<tr>';
                            echo '<td>
                                    <input type="hidden" id="concepto'.$x.'" name="concepto'.$x.'" value="'.$rsconcepto['IdConcepto'].'"/><label style="font-weight:bold;font-size:10px">'.$rsconcepto['Concepto'].'</label>
                                  </td>';
                            echo '<td><input type="text" id="valconcepto'.$x.'" name="valconcepto'.$x.'" onblur="FormatoN(this)"/></td>';
                            echo '</tr>';
                            $x++;
                        }
                        $x--;
                    ?>
                    </tbody>
                    <input type="hidden" id="tfilas" name="tfilas" value="<? echo $total; ?>" />
                    </table>
                </td>
            </tr>
        </table>
        <hr style="alignmentwidth:500px; background-color:F00;"/>
        <div align="left"><input type="button" class="boton" value="Registrar Cotizaci&oacute;n" onclick="validarform('formdetalle','cotizacion')"/></div>
  </form>
</div>
<script>
    $('#scliente').change(function(){
       $('#sproy option').remove();
       $('#sproy').append('<option value="">--- Elija un Proyecto ---</option>');
       var idcliente = $(this).val();    
       $.ajax({
        method: "get",
        data:{"cliente": idcliente},
        url:"cotizaciones/proyectoscliente.php",
        success: function(response){
            var json = $.parseJSON(response);
            var i=0;
            $.each(json,function(){
                $('#sproy').append('<option value="'+this.IdProyecto+'">'+this.NombreProyecto+'</option>')
            })
        }
       });
    });
</script>
<?
}
?>