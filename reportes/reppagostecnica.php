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
	
	$sqlreporte="SELECT vw_pagos_tecnica.IdProyecto, vw_pagos_tecnica.NombreProyecto, vw_pagos_tecnica.FechaEvento, vw_pagos_tecnica.Finalizada, vw_pagos_tecnica.Aprobada, vw_pagos_tecnica.NombreCargo, vw_pagos_tecnica.Usuario, vw_pagos_tecnica.Nombre, vw_pagos_tecnica.VrTotal, vw_pagos_tecnica.IdUnidad, vw_pagos_tecnica.Unidad FROM vw_pagos_tecnica WHERE vw_pagos_tecnica.IdUnidad=".$unidad." AND vw_pagos_tecnica.FechaEvento>='".$finicio."' AND vw_pagos_tecnica.FechaEvento<='".$ffin."' ORDER BY vw_pagos_tecnica.Nombre ASC, vw_pagos_tecnica.NombreCargo ASC, vw_pagos_tecnica.NombreProyecto ASC";	
	
	$cltreporte=mysql_query($sqlreporte,$cnn) or die(mysql_error());
	$filas=mysql_num_rows($cltreporte);
	echo '
	<div class="cuerpo">
		<h3>Reporte de <span>Pagos T&eacute;cnica</span></h3>
		<p>A continuaci&oacute;n se presenta el reporte de pagos de t&eacute;cnica</p>
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
					<td class="estilocelda"><div align="center"><label>Nombre Proyecto</label></div></td>
					<td class="estilocelda"><div align="center"><label>Fecha Evento</label></div></td>
					<td class="estilocelda"><div align="center"><label>Nombre</label></div></td>
					<td class="estilocelda"><div align="center"><label>Cargo</label></div></td>
					<td class="estilocelda"><div align="center"><label>Valor</label></div></td>
				</tr>';
				while($rsreporte=mysql_fetch_assoc($cltreporte)){
					echo '<tr>';
						echo'<td>'.$rsreporte['IdProyecto'].'</td>';
						echo'<td>'.$rsreporte['NombreProyecto'].'</td>';
						echo'<td>'.ConvFecha($rsreporte['FechaEvento']).'</td>';
						echo'<td>'.$rsreporte['Nombre'].'</td>';
						echo'<td>'.$rsreporte['NombreCargo'].'</td>';
						echo'<td>'.aMoneda($rsreporte['VrTotal']).'</td>';
				    echo '</tr>';
				}
			echo '</table>
		</div>
	</div>';
	mysql_close($cnn);
}
?>