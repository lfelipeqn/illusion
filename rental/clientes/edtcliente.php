<?php
	//session_start();
	include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
$connect=mysql_select_db($rental_cnn,$cnn);
$codigo=$_GET['codigo'];
$sqlclie="SELECT clientes.Identificacion, clientes.NombreCliente, clientes.Digito, clientes.Telefono, clientes.Extension, clientes.Email, clientes.Direccion, clientes.Fax, clientes.ExtensionFax FROM clientes WHERE clientes.Identificacion = '".$codigo."'";
$cltclie=mysql_query($sqlclie,$cnn) or die(mysql_error());
$rsclie=mysql_fetch_assoc($cltclie);

echo'
<div class="cuerpo">
	<h2><span>Actualizacion de </span>Clientes</h2>
	<form action="clientes/actualizacliente.php" method="post" name ="fclientes" id="fclientes" class="formulario">
		<fieldset>
			<table>
				<tr>
					<td><label>Nombre Cliente</label></td>
					<td colspan="3"><input style="width:453px;" type="text" id="ncliente" name="ncliente" value="'.$rsclie['NombreCliente'].'" /></td>
				</tr>
				<tr>
					<td><label>Identificaci&oacute;n</label></td>
					<td><input type="text" id="nident" name="nident" READONLY value="'.$rsclie['Identificacion'].'" /></td>
					<td><label>Digito Verificaci&oacute;n</label></td>
					<td><input type="text" id="ndigit" name="ndigit" value="'.$rsclie['Digito'].'" /></td>
				</tr>                    
				<tr>
					<td><label>Tel&eacute;fono</label></td>
					<td><input type="text" id="ntelcont" name="ntelcont" value="'.$rsclie['Telefono'].'" /></td>
					<td><label>Extensi&oacute;n</label></td>
					<td><input type="text" id="next" name="next" value="'.$rsclie['Extension'].'" /></td>
				</tr>
				<tr>
					<td><label>N&uacute;mero Fax</label></td>
					<td><input type="text" id="nfax" name="nfax" value="'.$rsclie['Fax'].'" /></td>
					<td><label>Extensi&oacute;n Fax</label></td>
					<td><input type="text" id="nexfax" name="nexfax" value="'.$rsclie['ExtensionFax'].'" /></td>
				</tr>
				<tr>
					<td><label>Direcci&oacute;n</label></td>
					<td><input type="text" id="ndir" name="ndir" value="'.$rsclie['Direccion'].'" /></td>
					<td><label>E-mail</label></td>
					<td><input type="text" id="nmail" name="nmail" value="'.$rsclie['Email'].'" /></td>
				</tr>
				<tr>
					<td colspan="4">
						<div align="center">
						  <input style="width:580px" class="boton" type="button" onclick="validarform(\'fclientes\',\'accliente\')" name="enviar" value="Actualizar Datos Cliente"> 
						</div>
				  </td>
				</tr>
			</table>
		</fieldset>
	<form>
</div>';
}
?>