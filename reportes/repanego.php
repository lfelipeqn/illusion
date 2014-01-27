<?php
session_start();
if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	include ('classes/libchart.php');
	$unidad=$_POST['sunidad'];
	$connect=mysql_select_db($database_cnn,$cnn);
	
	$sqlunidad="SELECT unidades.IdUnidad, unidades.Unidad FROM unidades WHERE unidades.IdUnidad=$unidad";
	$cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
	$rsunidad=mysql_fetch_assoc($cltunidad);
	
	$sqlnegocios="SELECT proyectos.IdProyecto, proyectos.NombreProyecto, unidades.IdUnidad, unidades.Unidad FROM negocios INNER JOIN proyectos ON negocios.IdProyecto = proyectos.IdProyecto INNER JOIN unidades ON proyectos.IdUnidad = unidades.IdUnidad INNER JOIN produccion ON proyectos.IdProyecto = produccion.IdProyecto WHERE negocios.Productor = '' AND produccion.Finalizada = 0 AND proyectos.IdUnidad = '".$unidad."' ORDER BY negocios.IdProyecto ASC";
	$cltnegocios=mysql_query($sqlnegocios,$cnn) or die(mysql_error());
	$filas=mysql_num_rows($cltnegocios);
	echo '
	<div class="cuerpo">
		<h3>Reporte de <span>Negocios Sin Productor Asignado</span></h3>
		<p>A continuaci&oacute;n se presenta el reporte de la totalidad de negocios que a la fecha no cuentan con un productor asignado en la Unidad de negocio Seleccionada</p>
		<div align="left">
		<table>
			<tr><td><b><label>Total Sin Asignar: </label></b></td><td>'.$filas.'</td></tr>
			<tr><td><b><label>Unidad de Negocio: </label></b></td><td><b>'.$rsunidad['Unidad'].'</b></td></tr>
		</table>
		<hr />
		<div align="center">
			<table class="estilotabla">
				<tr>
					<td class="estilocelda"><div align="center"><label>No. Proyecto</label></div></td>
					<td class="estilocelda"><div align="center"><label>Nombre Proyecto</label></div></td>
				</tr>';
				while($rsreporte=mysql_fetch_assoc($cltnegocios)){
					echo '<tr>';
						$linkasigna="inicio.php?location=listnego&tipo=5&valor=".$rsreporte['IdProyecto'];
						echo'<td>'.$rsreporte['IdProyecto'].'</td>';
						echo'<td>'.$rsreporte['NombreProyecto'].'</td>';
				    echo '</tr>';
				}
		echo '</table>
		<div align="center" id="pageNavPosition"></div>
		</div>
		</div>
	</div>';
echo '
	<script type="text/javascript">
       var pager = new Pager(\'results\', 14); 
       pager.init(); 
       pager.showPageNav(\'pager\', \'pageNavPosition\'); 
       pager.showPage(1);
    </script>';
mysql_close($cnn);
}
?>