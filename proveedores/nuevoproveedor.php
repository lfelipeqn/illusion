<?php
	//session_start();
if(isset($_SESSION['usuario'])){
	include('Connections/cnn.php');
	$conect=mysql_select_db($database_cnn,$cnn);
echo '
<div class="cuerpo">
        <form action="proveedores/insertaprov.php" method="post" id="formingreso">
    		<fieldset>
            	<div class="menuheaders">
        		<div align="left"><h2>Informaci&oacute;n <span> Proveedor</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
	          	<table>
              	<tr>
	              <td colspan="6">
                  </td>
                </tr>
	            <tr>
				  <td><label> Persona </label></td>
                  <td>
				  	<label><input type="radio" id="ntpersona1" name="ntpersona" value="1"/> Jur&iacute;dica</label>
	                <label><input type="radio" id="ntpersona2" name="ntpersona" value="2"/> Natural</label>
	              </td>
                </tr>
	            <tr>
	              <td><label> Nombre o Raz&oacute;n Social </label></td>
	              <td><input id="nproveedor" name="nproveedor" type="text" size="37"/></td>
	              <td><label> Nombre Comercial </label></td>
	              <td><input type="text" id="ncomercial" name="ncomercial" size="37"/></td>
                </tr>
	            <tr>
					<td><label> Tipo Identificacion </label></td>
					<td>
						<select id="tipoi" name="tipoi">
							<option value="0">--- Tipo de Identificaci&oacute;n---</option>';
							$sqliden="SELECT tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion FROM tipoidentificacion";
							$cltiden=mysql_query($sqliden,$cnn) or die(mysql_error());
							while($rsiden=mysql_fetch_assoc($cltiden)){
								echo '<option value="'.$rsiden['IdTipo'].'">'.$rsiden['TipoIdentificacion'].'</option>';
							}
					echo '</select>
					</td>
					<td><label> Identificacion </label></td>
                    <td>
                    	<label><input id="nnit" name="nnit" type="text" size="24"/>
	             		 DV <input id="ndv" name="ndv" type="text" size="5"/></label>
                    </td>
                </tr>
	            <tr>
	              <td><label>Ciudad</label></td>
	              <td><input id="nciudad" name="nciudad" type="text" size="37"/></td>
	              <td><label>Pa&iacute;s</label></td>
	              <td><input type="text" id="npais" name="npais" size="37"/></td>
                </tr>
	            <tr>
	              <td><label>Direcci&oacute;n</label></td>
	              <td><input id="ndir" name="ndir" type="text" size="37"/></td>
	              <td><label>Fax</label></td>
	              <td><input type="text" id="npfax" name="npfax" size="37"/></td>
                </tr>
	            <tr>
	              <td><label>Tel&eacute;fono</label></td>
	              <td><input id="ntel" name="ntel" type="text" size="37"/></td>
	              <td><label>E-Mail</label></td>
	              <td><input type="text" id="ncorreo" name="ncorreo" size="37"/></td>
                </tr>
	            <tr>
	              <td><label>Representante Legal</label></td>
	              <td><input id="nrepl" name="nrepl" type="text" size="37"/></td>
	              <td><label>c.c.</label></td>
	              <td><input type="text" id="ncc" name="ncc" size="37"/></td>
                </tr>
                <tr>
                </table>
                </li>
                </ul>
                <div class="menuheaders">
                <div align="left"><h2>Informaci&oacute;n <span>Tributaria</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
                <table>
	            <tr>
					<td colspan="4">
					<div align="left">
					<table>
						<tr>
							<td><div align="left">&nbsp;Gran Contribuyente&nbsp;</div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;<input type="radio" id="ntcontrib1" name="ntcontrib" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="ntcontrib2" name="ntcontrib" value="NO"/></div></td>
							<td><div align="left">&nbsp;Autoretendedor&nbsp;</b></div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;<input type="radio" id="naret1" name="naret" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="naret2" name="naret" value="NO"/></div></td>
						</tr>
						<tr>
							<td><div align="left">&nbsp;Responsable de IVA&nbsp;</div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;<input type="radio" id="niva1" name="niva" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="niva2" name="niva" value="NO"/></div></td>
							<td><div align="left">&nbsp;Responsable ICA&nbsp;</div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;<input type="radio" id="nica1" name="nica" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="nica2" name="nica" value="NO"/></div></td>
						</tr>
						<tr>
							<td><label>% Tarifa IVA: </label></td>
							<td colspan="2"><input type="text" id="tiva" name="tiva" size="12" maxlength="8"/></td>
							<td><label>% Rete IVA: </label></td>
							<td colspan="2"><input type="text" id="triva" name="triva" size="12" maxlength="8"/></td>
						</tr>
						<tr>
							<td><label>% Rete ICA: </label></td>
							<td colspan="2"><input type="text" id="trica" name="trica" size="12" maxlength="8"/></td>
							<td><label>% Rete FUENTE: </label></td>
							<td colspan="2"><input type="text" id="trfte" name="trfte" size="12" maxlength="8"/></td>
						</tr>
					</table>
					</div>
					<td>
                </tr>
	            <tr>
		            <td><label>C&oacute;digo Actividad Econ&oacute;mica</label></td>
	            	<td><input type="text" id="ncodac" name="ncodac" size="39"/></td>
                </tr>
				<tr>
	              	<td><label>Actividad Econ&oacute;mica</label></td>
	              	<td colspan="5"><input id="nactiv" name="nactiv" type="text" size="98"/></td>
                </tr>
				<tr>
					<td><label>CIIU - A.C.</label></td>
	            	<td><input type="text" id="nciiu" name="nciiu" size="39"/></td>
				</tr>
	            <tr>
	              	<td><label>Tarifa x 1000</label></td>
	              	<td><input name="ntarifa" type="text" size="39"/></td>
                </tr>
                </table>
                </li>
                </ul>
                <div class="menuheaders">
                <div align="left"><h2>Informaci&oacute;n <span>Pagos</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
                <table>
	            <tr>
	              <td><label>Medio de Pago: </label></td>
                  <td>
				  		<label><input type="radio" id="nmedio1" name="nmedio" value="1" onclick="ValidaPago(\'nmedio1\')"/>Transferencia</label>
	    	         	<label><input type="radio" id="nmedio2" name="nmedio" value="2" onclick="ValidaPago(\'nmedio2\')"/>Cheque</label>
				  </td>
                </tr>
				<tr>
	              <td><label>Cheque a la Orden de: </label></td>
                  <td><input id="ncheque" name="ncheque" type="text"/></td>
                </tr>
                <tr>
	              <td><label>Tipo</label></td>
                  <td>
            	    	<label><input type="radio" id="ntipoc1" name="ntipoc" value="1"/>Ahorros</label>
	    	         	<label><input type="radio" id="ntipoc2" name="ntipoc" value="2"/>Corriente</label>
    	          </td>
				  <td><label>Cuenta No.</label></td>
                  <td><input id="ncuenta" name="ncuenta" type="text"/></td>
                </tr>
               	<tr>
					<td><label>Entidad</label></td>
                  <td><input id="nentidad" name="nentidad" type="text"/></td>
	              <td><label>Persona de Contacto para Pagos </label></td>
                  <td><input id="npcontacto" name="npcontacto" type="text"/></td>
                </tr>
                </table>
                </li>
                </ul>
                <div class="menuheaders">
                	<div align="left">
                        <h2>Informaci&oacute;n <span>Compa&ntilde;&iacute;a</span></h2>
                    </div>
                </div>
                <ul class="menucontents">
                <li>
                <table>
                </tr>
                <tr>
                    <td><label>Tipo de Proveedor</label></td>
                    <td><table>';
                        $sqltipop="SELECT tipoproveedor.IdTipoP, tipoproveedor.TipoProveedor FROM tipoproveedor";
                        $cltprov=mysql_query($sqltipop,$cnn) or die(mysql_error());
                        $i=1;
                        echo '<tr>';
                        while($rsprov=mysql_fetch_assoc($cltprov)){
                            echo '<td><label><input type="radio" id="ntipop'.$i.'" name="ntipop" value="'.$rsprov['IdTipoP'].'"/>'.$rsprov['TipoProveedor'].'</label></td>';
                            if ($i%3 == 0){
                                echo '</tr><tr>';
                            }
                            $i++;
                        }                    
                    echo '</tr></table></td>
                </tr>
                <tr>
                    <td><label>Forma de Pago</label></td>
                    <td>
                    	<label><input type="radio" id="nfpago1" name="nfpago" value="1" onclick="PagoNormal()"/> 30 d&iacute;as </label>
                        <label><input type="radio" id="nfpago2" name="nfpago" value="2" onclick="PagoNormal()"/> 45 d&iacute;as </label>
                        <label><input type="radio" id="nfpago3" name="nfpago" value="3" onclick="PagoNormal()"/> 60 d&iacute;as </label>
                        <label><input type="radio" id="nfpago4" name="nfpago" onclick="PagoNormal()"/> Otro </label>
                    </td>
                    
                </tr>
                <tr>
                    <td><label>Descuento por pronto Pago</label></td>
                    <td>
                    	<label><input type="radio" id="ndprontop1" name="ndprontop" value="SI"/>SI</label>
                        <label><input type="radio" id="ndprontop2" name="ndprontop" value="NO"/>NO</label>
                    </td>
                </tr>
                <tr>
                	<td><label>Observaciones o Comentarios</label></td>
                </tr>
                <tr>
                	<td colspan="4"><input name="npobservaciones" type="text" size="130" height="80"/></td>
                </tr>
                </table>
                </li>
                </ul>
                <br  />
               	<div align="center">
               		<input type="button" value="Registrar Informaci&oacute;n del Proveedor" onclick="validarform(\'formingreso\',\'proveedor\')"/>
                </div>
                <br  />
			</fieldset>
	    <form>
</div>';
}
?>