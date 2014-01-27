<?php

	//session_start();

if(isset($_SESSION['usuario'])){

	include '../Connections/cnn.php';

	$proveedor=$_GET['seguimiento'];

	$sql="SELECT proveedores.Identificacion, proveedores.DV, proveedores.Fecha, proveedores.TipoIdentificacion, proveedores.NombreComercial, proveedores.NombreProveedor, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep, proveedores.IdTipoProveedor, proveedores.IdPago, proveedores.IVA, proveedores.ReteIva, proveedores.ReteIca, proveedores.ReteFte, proveedores.NombreCheque, proveedores.Cuenta, proveedores.TipoCuenta, proveedores.Entidad, proveedores.Contacto, proveedores.IdPlazo, proveedores.Descuento, proveedores.Observaciones FROM proveedores WHERE proveedores.Identificacion='".$proveedor."'";

	

	$connect=mysql_select_db($rental_cnn,$cnn);

	$consulta=mysql_query($sql,$cnn) or die(mysql_error());

	$rsprov=mysql_fetch_assoc($consulta);

	

	$sqltrib="SELECT tributariaproveedores.Identificacion, tributariaproveedores.Contribuyente, tributariaproveedores.IVA, tributariaproveedores.Autoretenedor, tributariaproveedores.ICA, tributariaproveedores.CIIU, tributariaproveedores.AutoretenedorICA, tributariaproveedores.CodActividad, tributariaproveedores.Tarifa FROM tributariaproveedores WHERE tributariaproveedores.Identificacion='".$proveedor."'";

	$clttrib=mysql_query($sqltrib,$cnn) or die(mysql_error());

	$rstrib=mysql_fetch_assoc($clttrib);

	

	

echo '

<div class="cuerpo">

		<form class="formulario">

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

							  <td colspan="4"><label><b>'.$rsprov['NombreProveedor'].'</b></label></td>

							  <td><label> Nombre Comercial </label></td>

							  <td colspan="4"><label><b>'.$rsprov['NombreComercial'].'</b></label></td>

							</tr>

							<tr>

								<td><label> Tipo Identificacion </label></td>

								<td colspan="4">';

									$sqlident="SELECT tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion FROM tipoidentificacion WHERE tipoidentificacion.IdTipo='".$rsprov['TipoIdentificacion']."'";

									

									$cltiden=mysql_query($sqlident,$cnn) or die(mysql_error());

									$rsiden=mysql_fetch_assoc($cltiden);

									echo '<label><b>'.$rsiden['TipoIdentificacion'].'</b></label>';

								echo '

								</td>

								<td><label> Identificacion </label></td>

								<td colspan="4">

									<label><label><b>'.$rsprov['Identificacion'].'</b></label>

									 DV <label><b>'.$rsprov['DV'].'</b></label></label>

								</td>

							</tr>

							<tr>

							  <td><label>Ciudad</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Ciudad'].'</b></label></td>

							  <td><label>Pa&iacute;s</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Pais'].'</b></label></td>

							</tr>

							<tr>

							  <td><label>Direcci&oacute;n</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Direccion'].'</b></label></td>

							  <td><label>Fax</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Fax'].'</b></label></td>

							</tr>

							<tr>

							  <td><label>Tel&eacute;fono</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Telefono'].'</b></label></td>

							  <td><label>E-Mail</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Correo'].'</b></label></td>

							</tr>

							<tr>

							  <td><label>Representante Legal</label></td>

							  <td colspan="4"><label><b>'.$rsprov['Representante'].'</b></label></td>

							  <td><label>c.c.</label></td>

							  <td colspan="4"><label><b>'.$rsprov['IdentRep'].'</b></label></td>

							</tr>

							<tr>

						</table>

					</td>

					<td class="celda">

						<table>

							<tr>

								<td><label>Gran Contribuyente</label></td>

								<td>';

									if ($rstrib['Contribuyente']=='SI') {

										echo '<label><b>SI</b></label>';

									}else{

										echo '<label><b>NO</b></label>';

									}

								echo '</td>

								<td><label>Autoretendedor</label></td>

								<td>';

									if ($rstrib['Autoretenedor']=='SI') {

										echo '<label><b>SI</b></label>';

									}else{

										echo '<label><b>NO</b></label>';

									}

								echo '</td>

							</tr>

							<tr>

								<td><label>Responsable de IVA</label></td>

								<td>';

									if ($rstrib['IVA']=='SI') {

										echo '<label><b>SI</b></label>';

									}else{

										echo '<label><b>NO</b></label>';

									}

								echo '</td>

								<td><label>Responsable ICA</label></td>

								<td>';

									if ($rstrib['AutoretenedorICA']=='SI') {

										echo '<label><b>SI</b></label>';

									}else{

										echo '<label><b>NO</b></label>';

									}

								echo '				

								</td>

							</tr>

							<tr>

								<td><label>% Tarifa IVA: </label></td>

								<td><label><b>'.($rsprov['IVA']*100).'</b></label></td>

								<td><label>% Rete IVA: </label></td>

								<td><label><b>'.($rsprov['ReteIva']*100).'</b></label></td>

							</tr>

							<tr>

								<td><label>% Rete ICA: </label></td>

								<td><label><b>'.($rsprov['ReteIca']*100).'</b></label></td>

								<td><label>% Rete FUENTE: </label></td>

								<td><label><b>'.($rsprov['ReteFte']*100).'</b></label></td>

							</tr>

							<tr>

								<td><label>C&oacute;digo Actividad Econ&oacute;mica</label></td>

								<td><label><b>'.$rstrib['CodActividad'].'</b></label></td>

								<td><label>Actividad Econ&oacute;mica</label></td>

								<td><label><b>'.$rsprov['Actividad'].'</b></label></td>

							</tr>

							<tr>

								<td><label>CIIU - A.C.</label></td>

								<td><label><b>'.$rstrib['CIIU'].'</b></label></td>

								<td><label>Tarifa x 1000</label></td>

								<td><label><b>'.$rstrib['Tarifa'].'</b><label></td>

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

							  <td>';

									if ($rsprov['IdPago']=='1') {

										echo '<label><b>Transferencia</b></label>';

									}else{

										echo '<label><b>Cheque</b></label>';

									}

								echo ' </td>

							  <td><label>Persona de Contacto para Pagos </label></td>

							  <td><label><b>'.$rsprov['Contacto'].'</b><label></td>

							</tr>

							<tr>

								<td><label>Cuenta No.</label></td>

							  	<td><label><b>'.$rsprov['Cuenta'].'</b></label></td>

							 	<td><label>Tipo</label></td>

								<td>';

									if ($rsprov['TipoCuenta']=='1') {

										echo '<label><b>Ahorros</b></label>';

									}else{

										echo '<label><b>Corriente</b></label>';

									}

								echo '</td>

							</tr>

							<tr>

							  <td><label>Entidad</label></td>

							  <td><label><b>'.$rsprov['Entidad'].'</b></label></td>

							  <td><label>Cheque a la Orden de: </label></td>

							  <td><label><b>'.$rsprov['NombreCheque'].'</b></label></td>

							</tr>

						</table>

					</td>

					<td class="celda">

						<table>

							<tr>

								<td><label>Tipo de Proveedor</label></td>

								<td>';

									if ($rsprov['IdTipoProveedor']=='1') {

										echo '<label><b>Talento</b></label>';

									}

									if ($rsprov['IdTipoProveedor']=='2') {

										echo '<label><b>Rental</b></label>';

									}

									if ($rsprov['IdTipoProveedor']=='3') {

										echo '<label><b>Servicios</b></label>';

									}

								echo '</td>

								<td><label>Forma de Pago</label></td>

								<td>';

									if ($rsprov['IdPlazo']=='1') {

										echo '<label><b>30 d&iacute;as</b></label>';

									}

									if ($rsprov['IdPlazo']=='2') {

										echo '<label><b>45 d&iacute;as</b></label>';

									}

									if ($rsprov['IdPlazo']=='3') {

										echo '<label><b>60 d&iacute;as</b></label>';

									}

									if ($rsprov['IdPlazo']=='4') {

										echo '<label><b>Otro Plazo</b></label>';

									}

								echo '</td>

							</tr>

							<tr>

								<td><label>Descuento por pronto Pago</label></td>

								<td>';

									if ($rsprov['Descuento']=='SI') {

										echo '<label><b>SI</b></label>';

									}else{

										echo '<label><b>NO</b></label>';

									}

								echo '</td>

								<td><label>Observaciones o Comentarios</label></td>

								<td colspan="2"><label><b>'.$rsprov['Observaciones'].'</b></label></td>

							</tr>

						</table>

					</td>

				</tr>

			</table>

			</form>

</div>';

mysql_close($cnn);

}

?>