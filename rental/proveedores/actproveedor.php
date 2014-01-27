<?php
	//session_start();
if(isset($_SESSION['usuario'])){
	include('../Connections/cnn.php');
	$idprov=$_GET['seguimiento'];
	$conect=mysql_select_db($rental_cnn,$cnn);
	$sql="SELECT proveedores.Identificacion, proveedores.DV, proveedores.Fecha, proveedores.TipoIdentificacion, proveedores.NombreComercial, proveedores.NombreProveedor, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep, proveedores.IdTipoProveedor, proveedores.IdPago, proveedores.IVA, proveedores.ReteIva, proveedores.ReteIca, proveedores.ReteFte, proveedores.NombreCheque, proveedores.Cuenta, proveedores.TipoCuenta, proveedores.Entidad, proveedores.Contacto, proveedores.IdPlazo, proveedores.Descuento, proveedores.Observaciones FROM proveedores WHERE proveedores.Identificacion='".$idprov."'";
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$rsprov=mysql_fetch_assoc($consulta);

	$sqltrib="SELECT tributariaproveedores.Identificacion, tributariaproveedores.Contribuyente, tributariaproveedores.IVA, tributariaproveedores.Autoretenedor, tributariaproveedores.ICA, tributariaproveedores.CIIU, tributariaproveedores.AutoretenedorICA, tributariaproveedores.CodActividad, tributariaproveedores.Tarifa FROM tributariaproveedores WHERE tributariaproveedores.Identificacion='".$idprov."'";
	$clttrib=mysql_query($sqltrib,$cnn) or die(mysql_error());
	$rstrib=mysql_fetch_assoc($clttrib);

echo '
<div class="cuerpo">
        <form class="formulario" action="proveedores/actualizaprov.php" method="post" id="formingreso">
    		<fieldset>
			<table>
				<tr>
					<td><div align="left"><h2><span>Informaci&oacute;n</span> Proveedor</h2></div></td>
					<td><div align="left"><h2><span>Informaci&oacute;n</span> Tributaria</h2></div></td>
				</tr>
				<tr>
					<td class="celda">
						<table>
							<tr>
							  <td><label> Nombre o Raz&oacute;n Social </label></td>
							  <td colspan="4"><input id="nproveedor" name="nproveedor" type="text" size="37" value="'.$rsprov['NombreProveedor'].'"/></td>
							  <td><label> Nombre Comercial </label></td>
							  <td colspan="4"><input type="text" id="ncomercial" name="ncomercial" size="37" value="'.$rsprov['NombreComercial'].'"/></td>
							</tr>
							<tr>
								<td><label> Tipo Identificacion </label></td>
								<td colspan="4">
									<select id="tipoi" name="tipoi">
										<option value="0">--- Tipo de Identificaci&oacute;n---</option>';
										$sqliden="SELECT tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion FROM tipoidentificacion";
										$cltiden=mysql_query($sqliden,$cnn) or die(mysql_error());
										while($rsiden=mysql_fetch_assoc($cltiden)){
											if($rsiden['IdTipo']==$rsprov['TipoIdentificacion']){
												echo '<option value="'.$rsiden['IdTipo'].'" selected="selected">'.$rsiden['TipoIdentificacion'].'</option>';
											}else{
												echo '<option value="'.$rsiden['IdTipo'].'">'.$rsiden['TipoIdentificacion'].'</option>';
											}
										}
								echo '</select>
								</td>
								<input id="ident" name="ident" type="hidden" value="'.$rsprov['Identificacion'].'"/>
								<td><label> Identificacion </label></td>
								<td colspan="4">
									<label><input id="nnit" name="nnit" type="text" style="background-color:CFDEBC;width:97px;" value="'.$rsprov['Identificacion'].'" READONLY/>
									 DV <input id="ndv" name="ndv" type="text" size="5" style="width:30px;" value="'.$rsprov['DV'].'"/></label>
								</td>
							</tr>
							<tr>
							  <td><label>Ciudad</label></td>
							  <td colspan="4"><input id="nciudad" name="nciudad" type="text" size="37" value="'.$rsprov['Ciudad'].'"/></td>
							  <td><label>Pa&iacute;s</label></td>
							  <td colspan="4"><input type="text" id="npais" name="npais" size="37" value="'.$rsprov['Pais'].'"/></td>
							</tr>
							<tr>
							  <td><label>Direcci&oacute;n</label></td>
							  <td colspan="4"><input id="ndir" name="ndir" type="text" size="37" value="'.$rsprov['Direccion'].'"/></td>
							  <td><label>Fax</label></td>
							  <td colspan="4"><input type="text" id="npfax" name="npfax" size="37" value="'.$rsprov['Fax'].'"/></td>
							</tr>
							<tr>
							  <td><label>Tel&eacute;fono</label></td>
							  <td colspan="4"><input id="ntel" name="ntel" type="text" size="37" value="'.$rsprov['Telefono'].'"/></td>
							  <td><label>E-Mail</label></td>
							  <td colspan="4"><input type="text" id="ncorreo" name="ncorreo" size="37" value="'.$rsprov['Correo'].'"/></td>
							</tr>
							<tr>
							  <td><label>Representante Legal</label></td>
							  <td colspan="4"><input id="nrepl" name="nrepl" type="text" size="37" value="'.$rsprov['Representante'].'"/></td>
							  <td><label>c.c.</label></td>
							  <td colspan="4"><input type="text" id="ncc" name="ncc" size="37" value="'.$rsprov['IdentRep'].'"/></td>
							</tr>
							<tr>
						</table>
					</td>
					<td class="celda">
						<table>
							<tr>
								<td><label>Gran Contribuyente</label></td>
								<td>
									<table>
										<tr>
											<td><label>SI</label></td>
											<td><input type="radio" id="ntcontrib1" name="ntcontrib" value="SI"';
											if ($rstrib['Contribuyente']=='SI') echo 'checked="checked"';
											echo '/></td>
										</tr>
										<tr>
											<td><label>NO</label></td>
											<td><input type="radio" id="ntcontrib2" name="ntcontrib" value="NO"';
											if ($rstrib['Contribuyente']=='NO') echo 'checked="checked"';
											echo '/></td>
										</tr>
									</table>									
								</td>
								<td><label>Autoretendedor</label></td>
								<td>
									<table>
										<tr>
											<td><label>SI</label></td>
											<td><input type="radio" id="naret1" name="naret" value="SI"';
											if ($rstrib['Autoretenedor']=='SI') echo 'checked="checked"';
											echo '/></td>
										</tr>
										<tr>
											<td><label>NO</label></td>
											<td><input type="radio" id="naret2" name="naret" value="NO"';
											if ($rstrib['Autoretenedor']=='NO') echo 'checked="checked"';
											echo '/></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td><label>Responsable de IVA</label></td>
								<td>
									<table>
										<tr>
											<td><label>SI</label></td>
											<td><input type="radio" id="niva1" name="niva" value="SI"';
											if ($rstrib['IVA']=='SI') echo 'checked="checked"';
											echo '/></td>
										</tr>
										<tr>
											<td><label>NO</label></td>
											<td><input type="radio" id="niva2" name="niva" value="NO"';
											if ($rstrib['IVA']=='NO') echo 'checked="checked"';
											echo '/></td>
										</tr>
									</table>
								</td>
								<td><label>Responsable ICA</label></td>
								<td>
									<table>
										<tr>
											<td><label>SI</label></td>
											<td><input type="radio" id="nica1" name="nica" value="SI"';
											if ($rstrib['AutoretenedorICA']=='SI') echo 'checked="checked"';
											echo '/></td>
										</tr>
										<tr>
											<td><label>NO</label></td>
											<td><input type="radio" id="nica2" name="nica" value="NO"';
											if ($rstrib['AutoretenedorICA']=='NO') echo 'checked="checked"';
											echo '/></td>
										</tr>
									</table>				
								</td>
							</tr>
							<tr>
								<td><label>% Tarifa IVA: </label></td>
								<td><input type="text" id="tiva" name="tiva" value="'.($rsprov['IVA']*100).'"/></td>
								<td><label>% Rete IVA: </label></td>
								<td><input type="text" id="triva" name="triva" value="'.($rsprov['ReteIva']*100).'"/></td>
							</tr>
							<tr>
								<td><label>% Rete ICA: </label></td>
								<td><input type="text" id="trica" name="trica" value="'.($rsprov['ReteIca']*100).'"/></td>
								<td><label>% Rete FUENTE: </label></td>
								<td><input type="text" id="trfte" name="trfte" value="'.($rsprov['ReteFte']*100).'"/></td>
							</tr>
							<tr>
								<td><label>C&oacute;digo Actividad Econ&oacute;mica</label></td>
								<td><input type="text" id="ncodac" name="ncodac" value="'.$rstrib['CodActividad'].'"/></td>
								<td><label>Actividad Econ&oacute;mica</label></td>
								<td><input id="nactiv" name="nactiv" type="text" value="'.$rsprov['Actividad'].'"/></td>
							</tr>
							<tr>
								<td><label>CIIU - A.C.</label></td>
								<td><input type="text" id="nciiu" name="nciiu" value="'.$rstrib['CIIU'].'"/></td>
								<td><label>Tarifa x 1000</label></td>
								<td><input name="ntarifa" type="text" value="'.$rstrib['Tarifa'].'"/></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><div align="left"><h2><span>Informaci&oacute;n </span>Pagos</h2></div></td>
					<td><div align="left"><h2><span>Informaci&oacute;n </span>Compa&ntilde;&iacute;a</h2></div></td>
				</tr>
				<tr>
					<td class="celda">
						<table>
							<tr>
							  <td><label>Medio de Pago: </label></td>
							  <td>
							  	<table>
									<tr>
										<td><label>Transferencia</label></td>
										<td><input type="radio" id="nmedio1" name="nmedio" value="1" onclick="ValidaPago(\'nmedio1\')"'; if ($rsprov['IdPago']=='1') echo 'checked="checked"'; echo '/></td>
									</tr>
									<tr>
										<td><label>Cheque</label></td>
										<td><input type="radio" id="nmedio2" name="nmedio" value="2" onclick="ValidaPago(\'nmedio2\')"'; if ($rsprov['IdPago']=='2') echo 'checked="checked"'; echo '/></td>
									</tr>
								</table>
							  </td>
							  <td><label>Persona de Contacto para Pagos </label></td>
							  <td><input id="npcontacto" name="npcontacto" type="text" value="'.$rsprov['Contacto'].'"/></td>
							</tr>
							<tr>
								<td><label>Cuenta No.</label></td>
							  	<td><input id="ncuenta" name="ncuenta" type="text" value="'.$rsprov['Cuenta'].'"/></td>
							 	<td><label>Tipo</label></td>
								<td>
								  <table>
									  <tr>
										  <td><label>Ahorros</label></td>
										  <td><input type="radio" id="ntipoc1" name="ntipoc" value="1" '; if ($rsprov['TipoCuenta']=='1') echo 'checked="checked"'; echo '/></td>
									  </tr>
									  <tr>
										  <td><label>Corriente</label></td>
										  <td><input type="radio" id="ntipoc2" name="ntipoc" value="2" '; if ($rsprov['TipoCuenta']=='2') echo 'checked="checked"'; echo '/></td>
									  </tr>
								  </table>
								</td>
							</tr>
							<tr>
							  <td><label>Entidad</label></td>
							  <td><input id="nentidad" name="nentidad" type="text" value="'.$rsprov['Entidad'].'"/></td>
							  <td><label>Cheque a la Orden de: </label></td>
							  <td><input id="ncheque" name="ncheque" type="text" value="'.$rsprov['NombreCheque'].'"/></td>
							</tr>
						</table>
					</td>
					<td class="celda">
						<table>
							<tr>
								<td><label>Tipo de Proveedor</label></td>
								<td><table>';
								$sqltprov="SELECT proveedores_tipo.IdTipo, proveedores_tipo.Tipo FROM proveedores_tipo";
								$clttprov=mysql_query($sqltprov,$cnn) or die(mysql_error());
								$i=1;
								while($rstprov=mysql_fetch_assoc($clttprov)){
									echo'<tr><td><label>'.$rstprov['Tipo'].'</label></td><td><input type="radio" id="ntipop'.$i.'" name="ntipop" value="'.$rstprov['IdTipo'].'"'; 
                                        if($rstprov['IdTipo']==$rsprov['IdTipoProveedor']) echo 'checked="checked"';
                                    echo '/></td></tr>';
									$i++;
								}
								echo '</table>
								</td>
								<td><label>Forma de Pago</label></td>
								<td>
									<table>
										<tr>
											<td><label>30 d&iacute;as</label></td>
											<td><input type="radio" id="nfpago1" name="nfpago" value="1" '; if ($rsprov['IdPlazo']=='1') echo 'checked="checked"'; echo '/></td>
										</tr>
										<tr>
											<td><label>45 d&iacute;as</label></td>
											<td><input type="radio" id="nfpago2" name="nfpago" value="2" '; if ($rsprov['IdPlazo']=='2') echo 'checked="checked"'; echo '/></td>
										</tr>
										<tr>
											<td><label>60 d&iacute;as</label></td>
											<td><input type="radio" id="nfpago3" name="nfpago" value="3" '; if ($rsprov['IdPlazo']=='3') echo 'checked="checked"'; echo '/></td>
										</tr>
										<tr>
											<td><label> Otro </label></td>
											<td><input type="radio" id="nfpago4" name="nfpago" '; if ($rsprov['IdPlazo']=='4') echo 'checked="checked"'; echo '/></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td><label>Descuento por pronto Pago</label></td>
								<td>
									<table>
										<tr>
											<td><label>SI</label></td>
											<td><input type="radio" id="ndprontop1" name="ndprontop" value="SI" '; if ($rsprov['Descuento']=='SI') echo 'checked="checked"'; echo ' /></td>
										</tr>
										<tr>
											<td><label>NO</label></td>
											<td><input type="radio" id="ndprontop2" name="ndprontop" value="NO"  '; if ($rsprov['Descuento']=='NO') echo 'checked="checked"'; echo '/></td>
										</tr>
									</table>
								</td>
								<td><label>Observaciones o Comentarios</label></td>
								<td colspan="2"><textarea name="npobservaciones" id="npobservaciones">'.$rsprov['Observaciones'].'</textarea></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
            <br  />
            <div align="center">
               <input type="submit" class="boton" value="Actualiza Informaci&oacute;n del Proveedor" style="width:250px; height:25px"/>
            </div>
		</fieldset>
	<form>
</div>';
}
?>