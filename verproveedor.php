<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include 'Connections/cnn.php';
	$proveedor=$_GET['seguimiento'];
	$sql = "SELECT tipopersona.Persona, proveedores.NombreProveedor, proveedores.Fecha, proveedores.Identificacion, proveedores.DV, proveedores.NombreComercial, proveedores.TipoPersona, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep, proveedores.IVA, proveedores.ReteIva, proveedores.ReteIca, proveedores.ReteFte, tipoproveedor.IdTipoP, tipoproveedor.TipoProveedor FROM proveedores LEFT JOIN tipopersona ON proveedores.TipoPersona = tipopersona.IdPersona LEFT JOIN tipoproveedor ON proveedores.IdTipoP = tipoproveedor.IdTipoP Where Identificacion='$proveedor'";
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());

echo'
<style type="text/css">
			td {
				font-family:arial,verdana;
				font-size:9pt;
			}
</style>

<div class="cuerpo">
			<h3>Consulta de <span>Proveedores</span></h3>
			<p>A Continuaci&oacute;n se presenta la totalidad de la Informaci&oacute;n Asociada al Proveedor Seleccionado</p>
	<div class="menuheaders">
    	<div align="left"><h2>Informaci&oacute;n <span>General</span></h2></div>
                </div>
                <ul class="menucontents">
                <li>
				<table>';
				$rs=mysql_fetch_assoc($consulta);
				$fecha=ConvFecha($rs['Fecha']);
				echo '
					<tr>
						<td><div align="left"><b><label>Fecha de Registro</label></b></div></td>
						<td>
							<div align="right">'.$fecha.'</div>
						</td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Nombre del Proveedor</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['NombreProveedor']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Identificaci&oacute;n</label></b></div></td>
						<td><div align="right"><label>'.$rs['Identificacion'].'</label>
						<label>DV</label>
						<label>'.$rs['DV'].'</label>
						</div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Nombre Comercial</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['NombreComercial']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Tipo Persona</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Persona']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Direcci&oacute;n</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Direccion']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Ciudad</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Ciudad']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Pa&iacute;s</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Pais']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Tel&eacute;fono</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Telefono']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Fax</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Fax']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Correo</label></b></div></td>
						<td><div align="right"><a href="mailto:'.$rs['Correo'].'">'.$rs['Correo'].'</a></label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Representante Legal</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['Representante']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Identificaci&oacute;n Representante</label></b></div></td>
						<td><div align="right"><label>'.$rs['IdentRep'].'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Tarifa IVA</label></b></div></td>
						<td><div align="right"><label>'.($rs['IVA']*100).' % </label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>ReteIva</label></b></div></td>
						<td><div align="right"><label>'.($rs['ReteIva']*100).' % </label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>ReteIca</label></b></div></td>
						<td><div align="right"><label>'.($rs['ReteIca']*100).' % </label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>ReteFte</label></b></div></td>
						<td><div align="right"><label>'.($rs['ReteFte']*100).' % </label></div></td>
					</tr>';
				echo '</table></li></ul>';
				echo '<div class="menuheaders">
    				<div align="left"><h2>Informaci&oacute;n <span>Tributaria</span></h2></div>
                </div>
                <ul class="menucontents">
                <li><table>';
				$sqlfin="select * from tributariaproveedores where IdProveedor='$proveedor'";
				$cltfin=mysql_query($sqlfin,$cnn) or die(mysql_error());
				while ($rsfin=mysql_fetch_assoc($cltfin)){
					echo '
					<tr>
						<td><div align="left"><b><label>Contibuyente</label></b></div></td>
						<td><div align="right">'.$rsfin['Contribuyente'].'</div></td>
						<td> &nbsp;&nbsp; </td>
						<td><div align="left"><b><label>IVA</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsfin['IVA']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Autoretenedor</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsfin['Autoretenedor']).'</label>
						</div></td>
						<td> &nbsp;&nbsp; </td>
						<td><div align="left"><b><label>ICA</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsfin['ICA']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>C&oacute;d. Actividad</label></b></div></td>
						<td><div align="right"><label>'.$rsfin['CodActividad'].'</label></div></td>
						<td> &nbsp;&nbsp; </td>
						<td><div align="left"><b><label>CIIU</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsfin['CIIU']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Autoretenedor ICA</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsfin['AutoretenedorICA']).'</label></div></td>
						<td> &nbsp;&nbsp; </td>
						<td><div align="left"><b><label>Tarifa</label></b></div></td>
						<td><div align="right"><label>'.$rsfin['Tarifa'].'</label></div></td>
					</tr>';
				}
				echo '</table></li></ul>';
				echo '<div class="menuheaders">
    				<div align="left"><h2>Informaci&oacute;n para <span>Pagos</span></h2></div>
                </div>
                <ul class="menucontents">
                <li><table>';
				$sqlpag="SELECT pagosproveedores.IdProveedor, pagosproveedores.NombreCheque, pagosproveedores.Cuenta, pagosproveedores.Entidad, pagosproveedores.Contacto, tipocuentas.TipoCuenta, tipopago.TipoPago FROM pagosproveedores LEFT JOIN tipocuentas ON pagosproveedores.TipoCuenta = tipocuentas.IdTipo LEFT JOIN tipopago ON pagosproveedores.IdPago = tipopago.IdPago where IdProveedor='$proveedor'";
				$cltpag=mysql_query($sqlpag,$cnn) or die(mysql_error());
				while ($rspag=mysql_fetch_assoc($cltpag)){
					echo '
					<tr>
						<td><div align="left"><b><label>Medio de Pago:</label></b></div></td>
						<td>
							<div align="right">'.$rspag['TipoPago'].'</div>
						</td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Cheque a Nombre de:</label></b></div></td>
						<td>
							<div align="right">'.$rspag['NombreCheque'].'</div>
						</td>
					</tr>
					<tr>
						<td><div align="left"><b><label>N&uacute;mero de Cuenta</label></b></div></td>
						<td><div align="right"><label>'.$rspag['Cuenta'].'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Tipo de Cuenta</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rspag['TipoCuenta']).'</label>
						</div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Entidad</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rspag['Entidad']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Contacto para pagos</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rspag['Contacto']).'</label></div></td>
					</tr>';
				}
				echo'</table></li></ul>';
				echo '<div class="menuheaders">
    				<div align="left"><h2>Informaci&oacute;n <span>Compa&ntilde;&iacute;a</span></h2></div>
                </div>
                <ul class="menucontents">
                <li><table>';
				$sqlvin="SELECT vinculoproveedor.IdRegistro, vinculoproveedor.IdProveedor, vinculoproveedor.Solicitante, vinculoproveedor.Descuento, vinculoproveedor.Observaciones, tipoproveedor.TipoProveedor, plazopago.Plazo FROM vinculoproveedor LEFT JOIN plazopago ON vinculoproveedor.FormaPago = plazopago.IdPlazo LEFT JOIN tipoproveedor ON vinculoproveedor.TipoProveedor = tipoproveedor.IdTipoP where IdProveedor='$proveedor'";
				$cltvin=mysql_query($sqlvin,$cnn) or die(mysql_error());
				while ($rsvin=mysql_fetch_assoc($cltvin)){
					echo '
					<tr>
						<td><div align="left"><b><label>Tipo de Proveedor</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rs['TipoProveedor']).'</label></div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Forma de Pago</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsvin['Plazo']).'</label>
						</div></td>
					</tr>
					<tr>
						<td><div align="left"><b><label>Descuento</label></b></div></td>
						<td><div align="right"><label>'.strtoupper($rsvin['Descuento']).'</label></div></td>
					</tr>
					<tr>
						<td colspan="2"><div align="left"><b><label>Observaciones</label></b></div></td>
					</tr>
					<tr>
						<td><div align="right"><label>'.strtoupper($rsvin['Observaciones']).'</label></div></td>
					</tr>';
				}
				echo'</table></li></ul></div>';
                mysql_close($cnn);
}
?>