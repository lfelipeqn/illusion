<?php
	//session_start();
	include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
$connect=mysql_select_db($rental_cnn,$cnn);
echo'
<div class="cuerpo">
	<h2><span>Registro de </span>Clientes</h2>
	<form action="clientes/insertacliente.php" method="post" name ="fclientes" id="fclientes" class="formulario">
		<fieldset>
			<table>
				<tr>
					<td><label>Nombre Cliente</label></td>
					<td colspan="3"><input style="width:410px;" type="text" id="ncliente" name="ncliente" /></td>
				</tr>
				<tr>
					<td><label>Identificaci&oacute;n</label></td>
					<td><input type="text" id="nident" name="nident" /></td>
					<td><label>Digito Verificaci&oacute;n</label></td>
					<td><input type="text" id="ndigit" name="ndigit" /></td>
				</tr>                    
				<tr>
					<td><label>Tel&eacute;fono</label></td>
					<td><input type="text" id="ntelcont" name="ntelcont" /></td>
					<td><label>Extensi&oacute;n</label></td>
					<td><input type="text" id="next" name="next" /></td>
				</tr>
				<tr>
					<td><label>N&uacute;mero Fax</label></td>
					<td><input type="text" id="nfax" name="nfax" /></td>
					<td><label>Extensi&oacute;n Fax</label></td>
					<td><input type="text" id="nexfax" name="nexfax" /></td>
				</tr>
				<tr>
					<td><label>Direcci&oacute;n</label></td>
					<td><input type="text" id="ndir" name="ndir" /></td>
					<td><label>E-mail</label></td>
					<td><input type="text" id="nmail" name="nmail" /></td>
				</tr>
				<tr>
					<td colspan="4">
						<div align="center">
						  <input style="width:490px" class="boton" type="button" onclick="validarform(\'fclientes\',\'cliente\')" name="enviar" value="Registrar Cliente Nuevo"> 
						</div>
				  </td>
				</tr>
			</table>
		</fieldset>
	<form>
</div>';
}
?>