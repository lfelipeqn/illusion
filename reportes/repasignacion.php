<?php
session_start();
if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	include ('classes/libchart.php');
	$finicio=aMySQL($_POST['finicio']);
	$ffin=aMySQL($_POST['ffin']);
	
	$connect=mysql_select_db($database_cnn,$cnn);
	
	$sqlasignacion="SELECT vw_asignacion.usuario, Count(vw_asignacion.IdProyecto) AS Proyectos FROM vw_asignacion WHERE vw_asignacion.FechaEvento >= '".$finicio."' AND vw_asignacion.FechaEvento <= '".$ffin."' GROUP BY vw_asignacion.Usuario";
	$cltasignacion=mysql_query($sqlasignacion,$cnn) or die(mysql_error());
	$filas=mysql_num_rows($cltasignacion);
	$chart= new VerticalBarChart(500, 250);
	$dataSet = new XYDataset();
	echo '
	<div class="cuerpo">
		<h3>Reporte de <span>Asignaci&oacute;n de Productores</span></h3>
		<p>El reporte presenta la asignaci&oacute;n de negocios a los diferentes productores dentro del periodo seleccionado</p>
		<div align="left">
			<table>
			<tr><td><b><label>Total Registros: </label></b></td><td>'.$filas.'</td></tr>
			<tr><td><b><label>Fecha Inicial: </label></b></td><td>'.ConvFecha($finicio).'</td></tr>
			<tr><td><b><label>Fecha Final: </label></b></td><td>'.ConvFecha($ffin).'</td></tr>
			<tr><td><b><label>Unidad de Negocio: </label></b></td><td><b>TODAS</b></td></tr>
			</table>
			<hr>
			<table>
			<tr><td>
			<table class="estilotabla">
				<tr>
					<td class="estilocelda"><div align="center"><label>Productor</label></div></td>
					<td class="estilocelda"><div align="center"><label>Proyectos Asignados</label></div></td>
				</tr>';
				while($rsasignacion=mysql_fetch_assoc($cltasignacion)){
					echo '<tr>';
						echo'<td>'.$rsasignacion['Usuario'].'</td>';
						echo'<td>'.$rsasignacion['Proyectos'].'</td>';
						$dataSet->addPoint(new Point($rsasignacion['Usuario'], $rsasignacion['Proyectos']));
				    echo '</tr>';
				}
			echo '</table></td>
			<td>
				<table>
					<tr><td>';
					$chart->setDataSet($dataSet);
					$chart->setTitle("Asignacion de Productores");
					$chart->render("reportes/asignacion.png");
					echo '<img src="reportes/asignacion.png"></td></tr>
				</table>
			</td>
			</tr>
			</table>
			</div>
	</div>';
	mysql_close($cnn);
}
?>