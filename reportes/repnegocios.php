<?php
session_start();
if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	include ('classes/libchart.php');
	$finicio=aMySQL($_POST['finicio']);
	$ffin=aMySQL($_POST['ffin']);
	$unidad=$_POST['sunidad'];
	
	$connect=mysql_select_db($database_cnn,$cnn);
	
	$sqlunidad="SELECT unidades.IdUnidad, unidades.Unidad FROM unidades WHERE unidades.IdUnidad=$unidad";
	$cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
	$rsunidad=mysql_fetch_assoc($cltunidad);
	
	$sqlreporte="SELECT produccion.IdProyecto, clientes.NombreCliente, usuarios.Nombre, produccion.ESLGEspectaculos, produccion.ESLGEventoCorporativo, produccion.ESLGNuevasTec, produccion.ESLGProduccion, produccion.ESLGImprevistos, produccion.ESLGTransporte, produccion.ESLGPersonal FROM produccion INNER JOIN clientes ON produccion.IdCliente = clientes.NombreCliente LEFT JOIN usuarios ON produccion.ProductorCampo = usuarios.IdUsuario INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto WHERE produccion.IdUnidad=".$unidad." AND proyectos.FechaEvento>='".$finicio."' AND proyectos.FechaEvento<='".$ffin."' AND produccion.Finalizada=1 ORDER BY produccion.IdProyecto ASC";	
	$cltreporte=mysql_query($sqlreporte,$cnn) or die(mysql_error());
	$filas=mysql_num_rows($cltreporte);
	echo '
	<div class="cuerpo">
		<h3>Reporte de <span>Negocios</span></h3>
		<p>A continuaci&oacute;n se presenta el reporte de negocios finalizados en el periodo seleccionado. El criterio de Fecha es la Fecha del Evento</p>
		<div align="left">
		<table>
			<tr><td><b><label>Total Registros: </label></b></td><td>'.$filas.'</td></tr>
			<tr><td><b><label>Fecha Inicial: </label></b></td><td>'.ConvFecha($finicio).'</td></tr>
			<tr><td><b><label>Fecha Final: </label></b></td><td>'.ConvFecha($ffin).'</td></tr>
			<tr><td><b><label>Unidad de Negocio: </label></b></td><td>'.$rsunidad['Unidad'].'</td></tr>
		</table>
		<hr />
		<div align="center">
			<table class="estilotabla">
				<tr>
					<td class="estilocelda"><div align="center"><label>No. Proyecto</label></div></td>
					<td class="estilocelda"><div align="center"><label>Nombre Cliente</label></div></td>
					<td class="estilocelda"><div align="center"><label>Productor</label></div></td>
					<td class="estilocelda"><div align="center"><label>Rental</label></div></td>
					<td class="estilocelda"><div align="center"><label>Ent. Corporativo</label></div></td>
					<td class="estilocelda"><div align="center"><label>Ent. Digital</label></div></td>
					<td class="estilocelda"><div align="center"><label>Produccion</label></div></td>
					<td class="estilocelda"><div align="center"><label>Imprevistos</label></div></td>
					<td class="estilocelda"><div align="center"><label>Transporte</label></div></td>
					<td class="estilocelda"><div align="center"><label>Personal</label></div></td>
				</tr>';
				while($rsreporte=mysql_fetch_assoc($cltreporte)){
					echo '<tr>';
						echo'<td>'.$rsreporte['IdProyecto'].'</td>';
						echo'<td>'.$rsreporte['NombreCliente'].'</td>';
						echo'<td>'.$rsreporte['Nombre'].'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGEspectaculos']).'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGEventoCorporativo']).'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGNuevasTec']).'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGProduccion']).'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGImprevistos']).'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGTransporte']).'</td>';
						echo'<td>'.aMoneda($rsreporte['ESLGPersonal']).'</td>';
				    echo '</tr>';
					$rent+=$rsreporte['ESLGEspectaculos'];
					$corp+=$rsreporte['ESLGEventoCorporativo'];
					$digi+=$rsreporte['ESLGNuevasTec'];
					$prod+=$rsreporte['ESLGProduccion'];
					$impr+=$rsreporte['ESLGImprevistos'];
					$trans+=$rsreporte['ESLGTransporte'];
					$pers+=$rsreporte['ESLGPersonal'];
				}
				echo '
				<tr>
					<td colspan="3" class="estilocelda"><div align="left"><b><label>Totales</label></b></div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($rent).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($corp).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($digi).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($prod).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($impr).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($trans).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($pers).'</div></td>	
				</tr>';
			echo '</table></div>
		</div>
	</div>';
	mysql_close($cnn);
}
?>