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
	
	$sqlreporte="SELECT produccion.IdProyecto, clientes.NombreCliente, presupuestos.Subtotal, produccion.GranTotal, produccion.Rentabilidad FROM produccion INNER JOIN clientes ON clientes.IdCliente = produccion.IdCliente INNER JOIN presupuestos ON produccion.IdPresupuesto = presupuestos.IdPresupuesto INNER JOIN proyectos ON proyectos.IdProyecto = produccion.IdProyecto WHERE proyectos.FechaEvento >= '".$finicio."' AND proyectos.FechaEvento <= '".$ffin."' AND produccion.Finalizada = 1 AND proyectos.IdUnidad=".$unidad." ORDER BY produccion.IdProyecto ASC";
	$cltreporte=mysql_query($sqlreporte,$cnn) or die(mysql_error());
	$filas=mysql_num_rows($cltreporte);
	echo '
	<div class="cuerpo">
		<h3>Reporte de <span>Rentabilidad</span></h3>
		<p>A continuaci&oacute;n se presenta el reporte de rentabilidad para los negocios con Hoja de Produccion Finalizada. Las fechas del reporte se toman a partir de la fecha de evento</p>
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
					<td class="estilocelda"><div align="center"><label>Subtotal Presupuesto</label></div></td>
					<td class="estilocelda"><div align="center"><label>Total Producci&oacute;n</label></div></td>
					<td class="estilocelda"><div align="center"><label>Rentabilidad</label></div></td>
				</tr>';
				while($rsreporte=mysql_fetch_assoc($cltreporte)){
					echo '<tr>';
						echo'<td>'.$rsreporte['IdProyecto'].'</td>';
						echo'<td>'.$rsreporte['NombreCliente'].'</td>';
						echo'<td>'.aMoneda($rsreporte['Subtotal']).'</td>';
						echo'<td>'.aMoneda($rsreporte['GranTotal']).'</td>';
						echo'<td>'.($rsreporte['Rentabilidad']*100).' % </td>';
				    echo '</tr>';
					$subt+=$rsreporte['Subtotal'];
					$tot+=$rsreporte['GranTotal'];
				}
				$rent=($subt-$tot)/$subt;
				$res=aMoneda($rent*100);
				$res=str_replace("$","",$res);
				echo '
				<tr>
					<td colspan="2" class="estilocelda"><div align="left"><b><label>Totales</label></b></div></td>
					<td class="estilocelda" ><div align="rigth">'.aMoneda($subt).'</div></td>
					<td class="estilocelda"><div align="rigth">'.aMoneda($tot).'</div></td>
					<td class="estilocelda"><div align="rigth">'.$res.' % </div></td>	
				</tr>';
			echo '</table>
			</div>
		</div>
	</div>';
	mysql_close($cnn);
}
?>