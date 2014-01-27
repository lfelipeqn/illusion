<?php
	include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	
			$sql = "SELECT
facturas.Factura,
facturas.IdProyecto,
facturas.IdCliente,
facturas.FechaEmision,
facturas.FechaVencimiento,
facturas.Subtotal,
facturas.Iva,
facturas.Total,
usuarios_unidades.usuario,
proyectos.IdUnidad,
proyectos.NombreProyecto
FROM facturas INNER JOIN proyectos ON facturas.IdProyecto = proyectos.IdProyecto INNER JOIN usuarios_unidades ON proyectos.IdUnidad = usuarios_unidades.IdUnidad WHERE usuarios_unidades.usuario = '".$_SESSION['usuario']."'";
	
	if($_SESSION['unidad']!=0){
		$sql.=" AND proyectos.IdUnidad = '".$_SESSION['unidad']."'";
	}
	$sql.=" ORDER BY facturas.IdProyecto DESC";
	
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
echo'
<div class="cuerpo">
	<h3>Consulta de <span>Facturas</span></h3>
	<p>A Continuaci&oacute;n se presenta el listado de facturas registradas en el sistema</p>
	<table id="results">
        <thead>
            <tr>
        		<th><div align="center"><label>Factura</label></div></th>
        		<th><div align="center"><label>Proyecto</label></div></th>
                <th><div align="center"><label>Nombre Proyecto</label></div></th>
        		<th><div align="center"><label>Emisi&oacute;n</label></div></th>
        		<th><div align="center"><label>Vencimiento</label></div></th>
        		<th><div align="center"><label>Subtotal</label></div></th>
        		<th><div align="center"><label>Iva</label></div></th>
        		<th><div align="center"><label>Total Factura</label></div></th>
        	</tr>
        </thead>
        <tbody>';
	$i=1;
	while ($rs=mysql_fetch_assoc($consulta)){
		$fechae=ConvFecha($rs['FechaEmision']);
		$fechav=ConvFecha($rs['FechaVencimiento']);
		echo '
		<tr>
			<td>'.$rs['Factura'].'</td>
			<td>'.$rs['IdProyecto'].'</td>
            <td>'.$rs['NombreProyecto'].'</td>
			<td>'.$fechae.'</td>
			<td>'.$fechav.'</td>
			<td>'.aMoneda($rs['Subtotal']).'</td>
			<td>'.aMoneda($rs['Iva']).'</td>
			<td>'.aMoneda($rs['Total']).'</td>
		</tr>';
	}
	echo '
        </tbody>
        </table>
	<br />
</div>';
mysql_close($cnn);
}
?>