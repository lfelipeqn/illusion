<?php
	//session_start();
	include '../Connections/cnn.php';
if(isset($_SESSION['usuario'])){
	$contador=1;
	$connect=mysql_select_db($rental_cnn,$cnn);
	ListaInventario();
echo '
<div class="cuerpo">
  <form action="inventario/creacotizacion.php" method="post" id="formdetalle">
  	<input type="hidden" id="nequipos" name="nequipos" value="1"/>
		<div align="left"><h2><span>Salida de </span>Equipos</h2></div>
		<hr>
		<p>Por Favor ejecute ahora la lectura de los codigos de cada equipo a incluir en el evento o digite manualmente el c&oacute;digo del mismo.</p>
		<table>
			<tr>
				<td><label style="font-weight:bold;font-size:10px">Elija el Cliente</label></td>
				<td><select id="ncliente" name="ncliente" style="width:300px">';
					$sqlcliente="SELECT clientes.Identificacion, clientes.NombreCliente FROM clientes";
					$cltcliente=mysql_query($sqlcliente,$cnn) or die(mysql_error());
					$filas=mysql_num_rows($cltcliente);
					echo '<option value="0">--- Elija un Cliente ---</option>';
					while($rscliente=mysql_fetch_assoc($cltcliente)){
						echo '<option value="'.$rscliente['Identificacion'].'">'.$rscliente['NombreCliente'].'</option>';
					}
				echo'</select></td>
			</tr>
			<tr>
				<td>
					<label style="font-weight:bold;font-size:10px">Seleccione el Tipo de Precio a Aplicar</label>
				</td>
				<td>
					<select id="tipop" name="tipop" style="width:300px">';
						$sqlop="SELECT tipo_precio.IdPrecio, tipo_precio.TipoPrecio, tipo_precio.Campo FROM tipo_precio";
						$cltop=mysql_query($sqlop,$cnn) or die(mysql_error());
						while($rsop=mysql_fetch_assoc($cltop)){
							echo '<option value="'.$rsop['IdPrecio'].'">'.$rsop['TipoPrecio'].'</option>';
						}
					echo '</select>
				</td>
			</tr>
		</table>';
		echo '<table id="tequipos" name="tequipos">
			<thead>
			<tr>
				<td class="estilocelda"><label>Opciones</label></td>
				<td class="estilocelda"><label>Codigo Equipo</label></td>
				<td class="estilocelda"><label>Nombre Equipo</label></td>
				<td class="estilocelda"><label>Valor Equipos</label></td>
			</tr>
			</thead>
			<tbody id="cuerpo" name="cuerpo"><tr><td class="estilocontenido"><img src="images/elimina.gif" onclick="EliminaFila(\'tequipos\',this,\'cuerpo\')"/></td><td class="estilocontenido"><input type="text" id="ceq1" name="ceq1" onkeyup="NuevoElemento(event, this, \'tipop\')" /></td><td class="estilocontenido"><input type="text" id="neq1" name="neq1" READONLY /></td><td class="estilocontenido"><input type="text" id="veq1" name="veq1" READONLY /></td></tr></tbody>
		</table>
		<input type="button" value="Registrar Cotizaci&oacute;n" style="width:545px;" onclick="confirmar(\'formdetalle\')"/>
  </form>
</div>';
}
?>