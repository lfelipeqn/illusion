<?php
	include('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
echo'
<div class="cuerpo">
	<h3>Registro de <span>Clientes</span></h3>
	<form action="clientes/insertacliente.php" method="post" name ="fclientes" id="fclientes" widht="100%">
		<fieldset>
			<table>
				<tr>
					<td><label>Nombre del Cliente</label></td>
					<td><input type="text" id="ncliente" name="ncliente" /></td>
				</tr>
				<tr>
					<td><label>Tipo Empresa</label></td>
					<td><div>';
							$sql = "select * from tipoempresa";
							$connect=mysql_select_db($database_cnn,$cnn);
							$consulta=mysql_query($sql,$cnn) or die(mysql_error());
							$i=0;
							while($registros=mysql_fetch_assoc($consulta)){
								$i+=1;
echo '<label><input type="radio" id="ntempresa'.$i.'" name="ntempresa" value='.$registros['IdTipo'].' onclick="Verifica(\'ntempresa'.$i.'\')"/> '.$registros['TipoEmpresa'].'</label></br>';
							}
							mysql_close();
						echo'</div>
					</td>
				</tr>
				<tr>
					<td><label>Identificaci&oacute;n</label></td>
					<td><input type="text" id="nident" name="nident" /></td>
				</tr>                    
				<tr>
					<td><label>Digito Verificaci&oacute;n</label></td>
					<td><input type="text" id="ndigit" name="ndigit" /></td>
				</tr>
				<tr>
					<td><label>Tel&eacute;fono</label></td>
					<td><input type="text" id="ntelcont" name="ntelcont" /></td>
				</tr>
				<tr>
					<td><label>E-mail</label></td>
					<td><input type="text" id="nmail" name="nmail" /></td>
				</tr>
				<tr>
					<td><label>Direcci&oacute;n</label></td>
					<td><input type="text" id="ndir" name="ndir" /></td>
				</tr>
				<tr>
					<td><label>N&uacute;mero Fax</label></td>
					<td><input type="text" id="nfax" name="nfax" /></td>
				</tr>
				<tr>
					<td colspan="3">
						<div align="center">
						  <input type=button onclick="validarform(\'fclientes\',\'cliente\')" name="enviar" value="Registrar Cliente Nuevo"> 
						</div>
				  </td>
				</tr>
			</table>
		</fieldset>
	<form>
</div>';
}
?>