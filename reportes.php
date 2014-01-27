<?php
if(isset($_SESSION['usuario'])){
	$privilegio=$_SESSION['perfil'];
	include ('Connections/cnn.php');
	include ('classes/libchart.php');
	$connect=mysql_select_db($database_cnn,$cnn);
echo '
<div class="cuerpo">
		<h3>Generador de <span>Reportes</span></h3>
		<p>De acuerdo con los privilegios del usuario, a continuaci&oacute;n se presentan los Reportes Disponibles</p>
		<div align="left">
			<form method="post" action="" id="reportes" name="reportes">
			<table>
				<tr>
					<td><label>Unidad de Negocio:</label></td>
					<td colspan="3"><select id="sunidad" name="sunidad">';
					$sqlunidades="SELECT unidades.IdUnidad, unidades.Unidad FROM unidades";
					$cltunidades=mysql_query($sqlunidades,$cnn) or die(mysql_error());
					while($rsunidades=mysql_fetch_assoc($cltunidades)){
						echo '<option value="'.$rsunidades['IdUnidad'].'">'.$rsunidades['Unidad'].'</option>';
					}
			   echo'</select></td>
				</tr>
				<tr>
					<td><label>Fecha Inicial: </label></td>
					<td><input type="text" id="finicio" name="finicio" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
					<td><label>Fecha Final: </label></td>
					<td><input type="text" id="ffin" name="ffin" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
				</tr>
				<tr>
					<td>';
					if(($privilegio=='Administrador')||($privilegio=='Productor General')){
						echo '<label><input name="sreport" type="radio" onclick="FAction(\'inicio.php?location=expagostecnica\')"/><b>Reporte Pagos T&eacute;cnica</b></label>';
					}
					echo '</td>
					<td>';
					if($privilegio=='Administrador'){
						echo '<label><input name="sreport" type="radio" onclick="FAction(\'inicio.php?location=reprent\')"/><b>Reporte Rentabilidad</b></label>';
					}
					echo '</td>
					<td>';
					if(($privilegio=='Administrador')||($privilegio=='Productor General')){
						echo '<label><input name="sreport" type="radio" onclick="FAction(\'inicio.php?location=repnego\')"/><b>Reporte Negocios</b></label>';
					}
					echo '</td>
					<td>';
					if(($privilegio=='Administrador')||($privilegio=='Comercial')){
						echo '<label><input name="sreport" type="radio" onclick="FAction(\'inicio.php?location=reprent\')"/><b>Reporte Presupuestos</b></label>';
					}
					echo '</td>
				</tr>
				<tr>
					<td>';
					if($privilegio=='Administrador'){
						echo '<label><input name="sreport" type="radio" onclick="FAction(\'inicio.php?location=repasigna\')"/><b>Asignaci&oacute;n de Productores</b></label>';
					}
			   echo'</td><td>';
			   		if($privilegio=='Administrador'){
						echo '<label><input name="sreport" type="radio" onclick="FAction(\'inicio.php?location=repanego\')"/><b>Negocios Sin Productor</b></label>';
					}
			   echo '</td>
				</tr>
				<tr>
					<td colspan="4">
						<div align="center">
						<input type="submit" value="Generar Reporte Seleccionado"/>
						</div>
					</td>
				</tr>
			</table>
			<hr>
		</form>
		</div>
</div>';
	mysql_close($cnn);
}
?>