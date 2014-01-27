<?php
	//session_start();
if(isset($_SESSION['usuario'])){
	include('Connections/cnn.php');
	$idprov=$_GET['seguimiento'];
	$conect=mysql_select_db($database_cnn,$cnn);
	$sql="SELECT proveedores.NombreProveedor, proveedores.Fecha, proveedores.Identificacion, proveedores.DV, proveedores.NombreComercial, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep, proveedores.IdTipoP, tipoidentificacion.TipoIdentificacion, tipoidentificacion.IdTipo, tipopersona.IdPersona, tipopersona.Persona, proveedores.IVA, proveedores.ReteIva, proveedores.ReteIca, proveedores.ReteFte FROM proveedores RIGHT JOIN tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo RIGHT JOIN tipopersona ON proveedores.TipoPersona = tipopersona.IdPersona WHERE proveedores.Identificacion='".$idprov."'";
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$rsprov=mysql_fetch_assoc($consulta);

	$sqltrib="SELECT tributariaproveedores.IdProveedor, tributariaproveedores.Contribuyente, tributariaproveedores.IVA, tributariaproveedores.Autoretenedor, tributariaproveedores.ICA, tributariaproveedores.CodActividad, tributariaproveedores.CIIU, tributariaproveedores.AutoretenedorICA, tributariaproveedores.Tarifa FROM tributariaproveedores WHERE tributariaproveedores.IdProveedor='".$idprov."'";
	$clttrib=mysql_query($sqltrib,$cnn) or die(mysql_error());
	$rstrib=mysql_fetch_assoc($clttrib);

	$sqlpagos="SELECT pagosproveedores.IdProveedor, pagosproveedores.NombreCheque, pagosproveedores.Cuenta, pagosproveedores.TipoCuenta, pagosproveedores.Entidad, pagosproveedores.Contacto, tipopago.TipoPago, tipopago.IdPago FROM pagosproveedores LEFT JOIN tipopago ON pagosproveedores.IdPago = tipopago.IdPago WHERE pagosproveedores.IdProveedor='".$idprov."'";
	$cltpagos=mysql_query($sqlpagos,$cnn) or die(mysql_error());
	$rspagos=mysql_fetch_assoc($cltpagos);

	$sqlvinculo="SELECT vinculoproveedor.IdProveedor, vinculoproveedor.Descuento, vinculoproveedor.Observaciones, plazopago.IdPlazo, plazopago.Plazo, tipoproveedor.TipoProveedor, tipoproveedor.IdTipoP FROM vinculoproveedor LEFT JOIN plazopago ON vinculoproveedor.FormaPago = plazopago.IdPlazo LEFT JOIN tipoproveedor ON vinculoproveedor.TipoProveedor = tipoproveedor.IdTipoP WHERE vinculoproveedor.IdProveedor='".$idprov."'";	
	$cltvinculo=mysql_query($sqlvinculo,$cnn) or die(mysql_error());
	$rsvinculo=mysql_fetch_assoc($cltvinculo);
    
echo '
<div class="cuerpo"> 
        <form action="proveedores/actualizaprov.php" method="post" id="formingreso">
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
                  <td>';
				  	$sqlpersona="SELECT tipopersona.IdPersona, tipopersona.Persona FROM tipopersona";
					$cltpersonas=mysql_query($sqlpersona,$cnn) or die(mysql_error());
					$x=0;
					while ($rspersona=mysql_fetch_assoc($cltpersonas)){
						$x++;
						if($rspersona['IdPersona']==$rsprov['IdPersona']){
							echo'<label><input type="radio" id="ntpersona'.$x.'" name="ntpersona" checked="checked" value="'.$rspersona['IdPersona'].'"/>'.$rspersona['Persona'].'</label>';
						}else{
							echo'<label><input type="radio" id="ntpersona'.$x.'" name="ntpersona" value="'.$rspersona['IdPersona'].'"/>'.$rspersona['Persona'].'</label>';
						}
					}

	              echo '</td>
                </tr>
	            <tr>
	              <td><label> Nombre o Raz&oacute;n Social </label></td>
	              <td>
				  	<input type="hidden" id="idproveedor" name="idproveedor" value="'.$idprov.'"/>
					<input id="nproveedor" name="nproveedor" type="text" size="37" value="'.$rsprov['NombreProveedor'].'"/>
				  </td>
	              <td><label> Nombre Comercial </label></td>
	              <td><input type="text" id="ncomercial" name="ncomercial" size="37" value="'.$rsprov['NombreComercial'].'"/></td>
                </tr>
	            <tr>
					<td><label> Tipo Identificacion </label></td>
					<td>
						<select id="tipoi" name="tipoi">
						<option value="0">--- Tipo de Identificaci&oacute;n---</option>';
							$sqliden="SELECT tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion FROM tipoidentificacion";
							$cltiden=mysql_query($sqliden,$cnn) or die(mysql_error());
							while($rsiden=mysql_fetch_assoc($cltiden)){
								if($rsiden['IdTipo']==$rsprov['IdTipo']){
									echo '<option value="'.$rsiden['IdTipo'].'" selected="selected">'.$rsiden['TipoIdentificacion'].'</option>';
								}else{
									echo '<option value="'.$rsiden['IdTipo'].'">'.$rsiden['TipoIdentificacion'].'</option>';	
								}
							}
					echo '
							</select>
					</td>
					<td><label> Identificacion </label></td>
                    <td>
                    	<label><input id="nnit" name="nnit" type="text" size="24" value="'.$rsprov['Identificacion'].'"/>
	             		 DV <input id="ndv" name="ndv" type="text" size="5" value="'.$rsprov['DV'].'"/></label>
                    </td>
                </tr>
	            <tr>
	              <td><label>Ciudad</label></td>
	              <td><input id="nciudad" name="nciudad" type="text" size="37" value="'.$rsprov['Ciudad'].'"/></td>
	              <td><label>Pa&iacute;s</label></td>
	              <td><input type="text" id="npais" name="npais" size="37" value="'.$rsprov['Pais'].'"/></td>
                </tr>
	            <tr>
	              <td><label>Direcci&oacute;n</label></td>
	              <td><input id="ndir" name="ndir" type="text" size="37" value="'.$rsprov['Direccion'].'"/></td>
	              <td><label>Fax</label></td>
	              <td><input type="text" id="npfax" name="npfax" size="37" value="'.$rsprov['Fax'].'"/></td>
                </tr>
	            <tr>
	              <td><label>Tel&eacute;fono</label></td>
	              <td><input id="ntel" name="ntel" type="text" size="37" value="'.$rsprov['Telefono'].'"/></td>
	              <td><label>E-Mail</label></td>
	              <td><input type="text" id="ncorreo" name="ncorreo" size="37" value="'.$rsprov['Correo'].'"/></td>
                </tr>
	            <tr>
	              <td><label>Representante Legal</label></td>
	              <td><input id="nrepl" name="nrepl" type="text" size="37" value="'.$rsprov['Representante'].'"/></td>
	              <td><label>c.c.</label></td>
	              <td><input type="text" id="ncc" name="ncc" size="37" value="'.$rsprov['IdentRep'].'"/></td>
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
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;';
							if($rstrib['Contribuyente']=='SI'){
								echo '<input type="radio" id="ntcontrib1" name="ntcontrib" value="SI" checked="checked"/>&nbsp;NO&nbsp;<input type="radio" id="ntcontrib2" name="ntcontrib" value="NO"/>';	
							}else if($rstrib['Contribuyente']=='NO'){
								echo '<input type="radio" id="ntcontrib1" name="ntcontrib" value="SI" />&nbsp;NO&nbsp;<input type="radio" id="ntcontrib2" name="ntcontrib" value="NO" checked="checked"/>';
							}else{
								echo '<input type="radio" id="ntcontrib1" name="ntcontrib" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="ntcontrib2" name="ntcontrib" value="NO"/>';
							}
							echo '</div></td>
							<td><div align="left">&nbsp;Autoretendedor&nbsp;</b></div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;';
							if($rstrib['Autoretenedor']=='SI'){
								echo '<input type="radio" id="naret1" name="naret" value="SI" checked="checked"/>&nbsp;NO&nbsp;<input type="radio" id="naret2" name="naret" value="NO"/>';	
							}else if($rstrib['Autoretenedor']=='NO'){
								echo '<input type="radio" id="naret1" name="naret" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="naret2" name="naret" value="NO" checked="checked"/>';
							}else{
								echo '<input type="radio" id="naret1" name="naret" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="naret2" name="naret" value="NO"/>';
							}
							echo '</div></td>
						</tr>
						<tr>
							<td><div align="left">&nbsp;Responsable de IVA&nbsp;</div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;';
							if($rstrib['IVA']=='SI'){
								echo '<input type="radio" id="niva1" name="niva" value="SI" checked="checked"/>&nbsp;NO&nbsp;<input type="radio" id="niva2" name="niva" value="NO"/>';	
							}else if($rstrib['IVA']=='NO'){
								echo '<input type="radio" id="niva1" name="niva" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="niva2" name="niva" value="NO" checked="checked"/>';
							}else{
								echo '<input type="radio" id="niva1" name="niva" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="niva2" name="niva" value="NO"/>';
							}
							echo'</div></td>
							<td><div align="left">&nbsp;Responsable ICA&nbsp;</div></td>
							<td colspan="2"><div align="center">&nbsp;SI&nbsp;';
							if($rstrib['ICA']=='SI'){
								echo '<input type="radio" id="nica1" name="nica" value="SI" checked="checked"/>&nbsp;NO&nbsp;<input type="radio" id="nica2" name="nica" value="NO"/>';	
							}else if($rstrib['ICA']=='NO'){
								echo '<input type="radio" id="nica1" name="nica" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="nica2" name="nica" value="NO" checked="checked"/>';
							}else{
								echo '<input type="radio" id="nica1" name="nica" value="SI"/>&nbsp;NO&nbsp;<input type="radio" id="nica2" name="nica" value="NO"/>';
							}
							echo'</div></td>
						</tr>
						<tr>
							<td><label>% Tarifa IVA: </label></td>
							<td colspan="2"><input type="text" id="tiva" name="tiva" size="12" maxlength="8" value="'.($rsprov['IVA']*100).'"/></td>
							<td><label>% Rete IVA: </label></td>
							<td colspan="2"><input type="text" id="triva" name="triva" size="12" maxlength="8" value="'.($rsprov['ReteIva']*100).'"/></td>
						</tr>
						<tr>
							<td><label>% Rete ICA: </label></td>
							<td colspan="2"><input type="text" id="trica" name="trica" size="12" maxlength="8" value="'.($rsprov['ReteIca']*100).'"/></td>
							<td><label>% Rete FUENTE: </label></td>
							<td colspan="2"><input type="text" id="trfte" name="trfte" size="12" maxlength="8" value="'.($rsprov['ReteFte']*100).'"/></td>
						</tr>
					</table>
					</div>
					<td>
                </tr>
	            <tr>
		            <td><label>C&oacute;digo Actividad Econ&oacute;mica</label></td>
	            	<td><input type="text" id="ncodac" name="ncodac" size="39" value="'.$rstrib['CodActividad'].'"/></td>
                </tr>
				<tr>
	              	<td><label>Actividad Econ&oacute;mica</label></td>
	              	<td colspan="5"><input id="nactiv" name="nactiv" type="text" size="98" value="'.$rsprov['Actividad'].'"/></td>
                </tr>
				<tr>
					<td><label>CIIU - A.C.</label></td>
	            	<td><input type="text" id="nciiu" name="nciiu" size="39" value="'.$rstrib['CIIU'].'"/></td>
				</tr>
	            <tr>
	              	<td><label>Tarifa x 1000</label></td>
	              	<td><input name="ntarifa" type="text" size="39" value="'.$rstrib['Tarifa'].'"/></td>
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
                  <td>';
				  		$sqltipop="SELECT tipopago.IdPago, tipopago.TipoPago FROM tipopago";
						$clttipop=mysql_query($sqltipop,$cnn) or die(mysql_error());
						$j=0;
						while($rstipop=mysql_fetch_assoc($clttipop)){
							$j++;
							if($rstipop['IdPago']==$rspagos['IdPago']){
								echo'<label><input type="radio" id="nmedio'.$j.'" name="nmedio" value="'.$rstipop['IdPago'].'" checked="checked" onclick="ValidaPago(\'nmedio'.$j.'\')"/>'.$rstipop['TipoPago'].'</label>';
							}else{
								echo'<label><input type="radio" id="nmedio'.$j.'" name="nmedio" value="'.$rstipop['IdPago'].'" onclick="ValidaPago(\'nmedio'.$j.'\')"/>'.$rstipop['TipoPago'].'</label>';
							}
						}
				  echo '</td>
                </tr>
				<tr>
	              <td><label>Cheque a la Orden de: </label></td>
                  <td><input id="ncheque" name="ncheque" type="text" value="'.$rspagos['NombreCheque'].'"/></td>
                </tr>
                <tr>
	              <td><label>Tipo</label></td>
                  <td>';
				  $sqlcuentas="SELECT tipocuentas.IdTipo, tipocuentas.TipoCuenta FROM tipocuentas";
				  $cltcuentas=mysql_query($sqlcuentas,$cnn) or die(mysql_error());
				  $k=0;
				  while($rscuentas=mysql_fetch_assoc($cltcuentas)){
					  $k++;
					  if($rscuentas['IdTipo']==$rspagos['TipoCuenta']){
						  echo '<label><input type="radio" id="ntipoc'.$k.'" name="ntipoc" checked="checked" value="'.$rscuentas['IdTipo'].'"/>'.$rscuentas['TipoCuenta'].'</label>';
					  }else{
						  echo '<label><input type="radio" id="ntipoc'.$k.'" name="ntipoc" value="'.$rscuentas['IdTipo'].'"/>'.$rscuentas['TipoCuenta'].'</label>';
					  }
				  }
    	          echo '</td>
				  <td><label>Cuenta No.</label></td>
                  <td><input id="ncuenta" name="ncuenta" type="text" value="'.$rspagos['Cuenta'].'"/></td>
                </tr>
               	<tr>
					<td><label>Entidad</label></td>
                  <td><input id="nentidad" name="nentidad" type="text" value="'.$rspagos['Entidad'].'"/></td>
	              <td><label>Persona de Contacto para Pagos </label></td>
                  <td><input id="npcontacto" name="npcontacto" type="text" value="'.$rspagos['Contacto'].'"/></td>
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
						$sqltprov="SELECT tipoproveedor.IdTipoP, tipoproveedor.TipoProveedor FROM tipoproveedor";
						$clttprov=mysql_query($sqltprov,$cnn) or die(mysql_error());
						$l=1;
                        echo '<tr>';
						while($rstprov=mysql_fetch_assoc($clttprov)){
							if($rstprov['IdTipoP']==$rsprov['IdTipoP']){
								echo '<td><label><input type="radio" id="ntipop'.$l.'" name="ntipop" value="'.$rstprov['IdTipoP'].'" checked="checked"/>'.$rstprov['TipoProveedor'].'</label></td>';
							}else{
								echo '<td><label><input type="radio" id="ntipop'.$l.'" name="ntipop" value="'.$rstprov['IdTipoP'].'"/>'.$rstprov['TipoProveedor'].'</label></td>';
							}
                            if ($l%3 == 0){
                                echo '</tr><tr>';
                            }
                            $l++;
						}
                    echo '</tr></table></td>
                </tr>
                <tr>
                    <td><label>Forma de Pago</label></td>
                    <td>';
						$sqlforma="SELECT plazopago.IdPlazo, plazopago.Plazo FROM plazopago";
						$cltforma=mysql_query($sqlforma,$cnn) or die(mysql_error());
						$m=0;
						while($rsforma=mysql_fetch_assoc($cltforma)){
							$m++;
							if($rsforma['IdPlazo']==$rsvinculo['IdPlazo']){
								echo '<label><input type="radio" id="nfpago'.$m.'" name="nfpago" value="'.$rsforma['IdPlazo'].'" checked="checked" onclick="PagoNormal()"/>'.$rsforma['Plazo'].'</label>';
							}else{
								echo '<label><input type="radio" id="nfpago'.$m.'" name="nfpago" value="'.$rsforma['IdPlazo'].'" onclick="PagoNormal()"/>'.$rsforma['Plazo'].'</label>';
							}
						}
                    echo '</td></tr>
                    <tr><td><label>Descuento por pronto Pago</label></td>
                    <td>';
                    	if($rsvinculo['Descuento']=='SI'){
							echo '<label><input type="radio" id="ndprontop1" name="ndprontop" value="SI" checked="checked"/>SI</label>
                        <label><input type="radio" id="ndprontop2" name="ndprontop" value="NO"/>NO</label>';
						}else if($rsvinculo['Descuento']=='NO'){
							echo '<label><input type="radio" id="ndprontop1" name="ndprontop" value="SI"/>SI</label>
                        <label><input type="radio" id="ndprontop2" name="ndprontop" value="NO" checked="checked"/>NO</label>';
						}else{
							echo '<label><input type="radio" id="ndprontop1" name="ndprontop" value="SI"/>SI</label>
                        <label><input type="radio" id="ndprontop2" name="ndprontop" value="NO" />NO</label>';
						}
                    echo '</td>
                </tr>
                <tr>
                	<td><label>Observaciones o Comentarios</label></td>
                </tr>
                <tr>
                	<td colspan="4"><input name="npobservaciones" type="text" size="130" height="80" value="'.$rsvinculo['Observaciones'].'"/></td>
                </tr>
                </table>
                </li>
                </ul>
                <br  />
               	<div align="left">
               		<input type="submit" value="Actualizar Informaci&oacute;n del Proveedor"/>
                </div>
                <br  />
			</fieldset>
	    <form>
</div>';
}
?>