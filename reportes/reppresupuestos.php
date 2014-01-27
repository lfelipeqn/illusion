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
	
	$sqlreporte="SELECT presupuestos.IdPresupuesto, clientes.NombreCliente, presupuestos.IdProyecto, presupuestos.SubEspectaculos, presupuestos.SubEventosCorp, presupuestos.SubNuevasTec, presupuestos.SubProduccion, presupuestos.Subtotal, presupuestos.Descuento, presupuestos.KnowHow, presupuestos.FechaPresentacion FROM presupuestos INNER JOIN clientes ON presupuestos.IdCliente = clientes.IdCliente WHERE presupuestos.IdUnidad=".$unidad." AND presupuestos.FechaPresentacion>='".$finicio."' AND presupuestos.FechaPresentacion<='".$ffin."' AND presupuestos.Aprobabo=1 ORDER BY presupuestos.IdProyecto ASC";	
	$cltreporte=mysql_query($sqlreporte,$cnn) or die(mysql_error());
	$filas=mysql_num_rows($cltreporte);
	echo '
	<div class="cuerpo">
		<h3>Reporte de <span>Presupuestos</span></h3>
		<p>A continuaci&oacute;n se presenta el reporte de presupuestos aprobados en el periodo seleccionado</p>
		<div align="left">
		<table>
			<tr><td><b><label>Total Registros: </label></b></td><td>'.$filas.'</td></tr>
			<tr><td><b><label>Fecha Inicial: </label></b></td><td>'.ConvFecha($finicio).'</td></tr>
			<tr><td><b><label>Fecha Final: </label></b></td><td>'.ConvFecha($ffin).'</td></tr>
			<tr><td><b><label>Unidad de Negocio: </label></b></td><td>'.$rsunidad['Unidad'].'</td></tr>
		</table>
		<hr />
			<table class="estilotabla">
				<tr>
					<td class="estilocelda"><div align="center"><label>No. Proyecto</label></div></td>
					<td class="estilocelda"><div align="center"><label>Nombre Cliente</label></div></td>
					<td class="estilocelda"><div align="center"><label>Subtotal</label></div></td>
					<td class="estilocelda"><div align="center"><label>Know How</label></div></td>
					<td class="estilocelda"><div align="center"><label>Rental</label></div></td>
					<td class="estilocelda"><div align="center"><label>Ent. Corporativo</label></div></td>
					<td class="estilocelda"><div align="center"><label>Ent. Digital</label></div></td>
					<td class="estilocelda"><div align="center"><label>Produccion</label></div></td>
					<td class="estilocelda"><div align="center"><label>Descuentos</label></div></td>
				</tr>';
				while($rsreporte=mysql_fetch_assoc($cltreporte)){
					echo '<tr>';
						echo'<td>'.$rsreporte['IdProyecto'].'</td>';
						echo'<td>'.$rsreporte['NombreCliente'].'</td>';
						echo'<td>'.aMoneda($rsreporte['Subtotal']).'</td>';
						echo'<td>'.aMoneda($rsreporte['KnowHow']).'</td>';
						echo'<td>'.aMoneda($rsreporte['SubEspectaculos']).'</td>';
						echo'<td>'.aMoneda($rsreporte['SubEventosCorp']).'</td>';
						echo'<td>'.aMoneda($rsreporte['SubNuevasTec']).'</td>';
						echo'<td>'.aMoneda($rsreporte['SubProduccion']).'</td>';
						echo'<td>'.aMoneda($rsreporte['Descuento']).'</td>';
				    echo '</tr>';
					$subt+=$rsreporte['Subtotal'];
					$know+=$rsreporte['KnowHow'];
					$rent+=$rsreporte['SubEspectaculos'];
					$corp+=$rsreporte['SubEventosCorp'];
					$edig+=$rsreporte['SubNuevasTec'];
					$prod+=$rsreporte['SubProduccion'];
					$desc+=$rsreporte['Descuento'];
				}
				echo '
				<tr>
					<td colspan="2" class="estilocelda"><div align="left"><b><label>Total</label></b></div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($subt).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($know).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($rent).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($corp).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($edig).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($prod).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($desc).'</div></td>	
				</tr>';
			echo '</table>
		</div>
	</div>';
	mysql_close($cnn);
}
?>