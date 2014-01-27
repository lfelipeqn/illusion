<?php
	include('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Actualizaci&oacute;n de <span>Clientes</span></h3>
	<form action="clientes/actualizacliente.php" method="post" id="contacts-form">
		<fieldset>
			<table>
				<tr>
					<td><label>Elija el Cliente a Modificar</label></td>
					<td width="3px"></td>
					<td>';
						$sql = "SELECT clientes.NombreCliente FROM clientes INNER JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON clientes_unidades.IdUnidad = usuarios_unidades.IdUnidad";
						if($_SESSION['unidad']!=0){
							$sql.=" WHERE usuarios_unidades.IdUnidad = '".$_SESSION['unidad']."'";
						}
						$sql.=" GROUP BY clientes.NombreCliente";
						
						$connect=mysql_select_db($database_cnn,$cnn);
						$consulta=mysql_query($sql,$cnn) or die(mysql_error());
						echo '<select name="quien" >';
						while($registros=mysql_fetch_assoc($consulta)){
							echo '<option value="'.$registros['NombreCliente'].'" >'.$registros['NombreCliente'].'</option>';
						}
						echo '</select>';
						echo '</td>
				</tr>
				<tr>
					<td><label>Actualizar Tipo Empresa</label></td>
					<td width="3px"></td>
					<td>';
						$sql = "select * from tipoempresa";
						$connect=mysql_select_db($database_cnn,$cnn);
						$consulta=mysql_query($sql,$cnn) or die(mysql_error());
						$i=0;
						while($registros=mysql_fetch_assoc($consulta)){
							$i+=1;
echo '<label><input type="radio" id="ntempresa'.$i.'" name="ntempresa" value='.$registros['IdTipo'].' onclick="Verifica(\'ntempresa'.$i.'\')"/> '.$registros['TipoEmpresa'].'</label></br>';
						}
						mysql_close();
					echo '</td>
				</tr>
				<tr>
					<td><label>Actualizar Identificaci&oacute;n</label></td>
					<td width="3px"></td>
					<td><input type="text" id="nident" name="nident" /></td>
				</tr>                    
				<tr>
					<td><label>Actualizar Digito Verificaci&oacute;n</label></td>
					<td width="3px"></td>
					<td><input type="text" id="ndigit" name="ndigit" /></td>
				</tr>
				<tr>
					<td><label>Nuevo Tel&eacute;fono</label></td>
					<td width="3px"></td>
					<td><input type="text" id="ntelcont" name="ntelcont" /></td>
				</tr>
				<tr>
					<td><label>Nuevo E-mail</label></td>
					<td width="3px"></td>
					<td><input type="text" id="nmail" name="nmail" /></td>
				</tr>
				<tr>
					<td><label>Nueva Direcci&oacute;n</label></td>
					<td width="3px"></td>
					<td><input type="text" id="ndir" name="ndir" /></td>
				</tr>
				<tr>
					<td><label>Nuevo N&uacute;mero Fax</label></td>
					<td width="3px"></td>
					<td><input type="text" id="nfax" name="nfax" /></td>
				</tr>
				<tr>
					<td colspan="3">
						<div align="center">
						  <input type="submit" id="actualiza" name="actualiza" value="Actualiza Informacion del Cliente"/>
						</div>
				  </td>
				</tr>
			</table>
		</fieldset>
	<form>
</div>';
}
?>