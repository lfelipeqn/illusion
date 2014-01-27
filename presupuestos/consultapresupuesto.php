<?php
	//session_start();
	include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){	
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];
	
	switch($opcion){
		case 0:
			$sql = "SELECT
pr.IdCliente AS IdCliente,
pr.IdProyecto AS IdProyecto,
pr.NombreProyecto AS NombreProyecto,
pr.NombreContacto AS NombreContacto,
pr.Ciudades AS Ciudades,
p.Aprobabo AS Estado,
p.IdPresupuesto AS IdPresupuesto,
p.Presupuesto AS Presupuesto,
p.Version AS Version,
p.FechaPresentacion AS FechaPresentacion,
p.TipoCliente AS TipoCliente,
p.FormaPago AS FormaPago,
p.Subtotal AS Subtotal,
p.Descuento AS Descuento,
p.KnowHow AS KnowHow,
p.Total AS Total,
c.NombreCliente AS NombreCliente,
te.TipoEmpresa AS TipoEmpresa,
usr.Nombre AS Presentadopor,
facturas.Factura
FROM
((presupuestos AS p
INNER JOIN proyectos AS pr ON ((pr.IdProyecto = p.IdProyecto)))
INNER JOIN clientes AS c ON ((pr.IdCliente = c.IdCliente)))
INNER JOIN tipoempresa AS te ON te.IdTipo = c.TipoEmpresa
INNER JOIN usuarios AS usr ON p.Presentadopor = usr.Usuario
INNER JOIN usuarios_unidades ON p.IdUnidad = usuarios_unidades.IdUnidad
LEFT JOIN facturas ON p.IdCliente = facturas.IdCliente AND p.IdProyecto = facturas.IdProyecto WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 1:
			$sql = "SELECT
pr.IdCliente AS IdCliente,
pr.IdProyecto AS IdProyecto,
pr.NombreProyecto AS NombreProyecto,
pr.NombreContacto AS NombreContacto,
pr.Ciudades AS Ciudades,
p.Aprobabo AS Estado,
p.IdPresupuesto AS IdPresupuesto,
p.Presupuesto AS Presupuesto,
p.Version AS Version,
p.FechaPresentacion AS FechaPresentacion,
p.TipoCliente AS TipoCliente,
p.FormaPago AS FormaPago,
p.Subtotal AS Subtotal,
p.Descuento AS Descuento,
p.KnowHow AS KnowHow,
p.Total AS Total,
c.NombreCliente AS NombreCliente,
te.TipoEmpresa AS TipoEmpresa,
usr.Nombre AS Presentadopor,
facturas.Factura
FROM
((presupuestos AS p
INNER JOIN proyectos AS pr ON ((pr.IdProyecto = p.IdProyecto)))
INNER JOIN clientes AS c ON ((pr.IdCliente = c.IdCliente)))
INNER JOIN tipoempresa AS te ON te.IdTipo = c.TipoEmpresa
INNER JOIN usuarios AS usr ON p.Presentadopor = usr.Usuario
INNER JOIN usuarios_unidades ON p.IdUnidad = usuarios_unidades.IdUnidad
LEFT JOIN facturas ON p.IdCliente = facturas.IdCliente AND p.IdProyecto = facturas.IdProyecto WHERE usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 2:
			$sql = "SELECT
pr.IdCliente AS IdCliente,
pr.IdProyecto AS IdProyecto,
pr.NombreProyecto AS NombreProyecto,
pr.NombreContacto AS NombreContacto,
pr.Ciudades AS Ciudades,
p.Aprobabo AS Estado,
p.IdPresupuesto AS IdPresupuesto,
p.Presupuesto AS Presupuesto,
p.Version AS Version,
p.FechaPresentacion AS FechaPresentacion,
p.TipoCliente AS TipoCliente,
p.FormaPago AS FormaPago,
p.Subtotal AS Subtotal,
p.Descuento AS Descuento,
p.KnowHow AS KnowHow,
p.Total AS Total,
c.NombreCliente AS NombreCliente,
te.TipoEmpresa AS TipoEmpresa,
usr.Nombre AS Presentadopor,
facturas.Factura
FROM
((presupuestos AS p
INNER JOIN proyectos AS pr ON ((pr.IdProyecto = p.IdProyecto)))
INNER JOIN clientes AS c ON ((pr.IdCliente = c.IdCliente)))
INNER JOIN tipoempresa AS te ON te.IdTipo = c.TipoEmpresa
INNER JOIN usuarios AS usr ON p.Presentadopor = usr.Usuario
INNER JOIN usuarios_unidades ON p.IdUnidad = usuarios_unidades.IdUnidad
LEFT JOIN facturas ON p.IdCliente = facturas.IdCliente AND p.IdProyecto = facturas.IdProyecto WHERE c.NombreCliente LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 3:
			$sql = "SELECT
pr.IdCliente AS IdCliente,
pr.IdProyecto AS IdProyecto,
pr.NombreProyecto AS NombreProyecto,
pr.NombreContacto AS NombreContacto,
pr.Ciudades AS Ciudades,
p.Aprobabo AS Estado,
p.IdPresupuesto AS IdPresupuesto,
p.Presupuesto AS Presupuesto,
p.Version AS Version,
p.FechaPresentacion AS FechaPresentacion,
p.TipoCliente AS TipoCliente,
p.FormaPago AS FormaPago,
p.Subtotal AS Subtotal,
p.Descuento AS Descuento,
p.KnowHow AS KnowHow,
p.Total AS Total,
c.NombreCliente AS NombreCliente,
te.TipoEmpresa AS TipoEmpresa,
usr.Nombre AS Presentadopor,
facturas.Factura
FROM
((presupuestos AS p
INNER JOIN proyectos AS pr ON ((pr.IdProyecto = p.IdProyecto)))
INNER JOIN clientes AS c ON ((pr.IdCliente = c.IdCliente)))
INNER JOIN tipoempresa AS te ON te.IdTipo = c.TipoEmpresa
INNER JOIN usuarios AS usr ON p.Presentadopor = usr.Usuario
INNER JOIN usuarios_unidades ON p.IdUnidad = usuarios_unidades.IdUnidad
LEFT JOIN facturas ON p.IdCliente = facturas.IdCliente AND p.IdProyecto = facturas.IdProyecto WHERE pr.NombreProyecto LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 4:
			$sql = "SELECT
pr.IdCliente AS IdCliente,
pr.IdProyecto AS IdProyecto,
pr.NombreProyecto AS NombreProyecto,
pr.NombreContacto AS NombreContacto,
pr.Ciudades AS Ciudades,
p.Aprobabo AS Estado,
p.IdPresupuesto AS IdPresupuesto,
p.Presupuesto AS Presupuesto,
p.Version AS Version,
p.FechaPresentacion AS FechaPresentacion,
p.TipoCliente AS TipoCliente,
p.FormaPago AS FormaPago,
p.Subtotal AS Subtotal,
p.Descuento AS Descuento,
p.KnowHow AS KnowHow,
p.Total AS Total,
c.NombreCliente AS NombreCliente,
te.TipoEmpresa AS TipoEmpresa,
usr.Nombre AS Presentadopor,
facturas.Factura
FROM
((presupuestos AS p
INNER JOIN proyectos AS pr ON ((pr.IdProyecto = p.IdProyecto)))
INNER JOIN clientes AS c ON ((pr.IdCliente = c.IdCliente)))
INNER JOIN tipoempresa AS te ON te.IdTipo = c.TipoEmpresa
INNER JOIN usuarios AS usr ON p.Presentadopor = usr.Usuario
INNER JOIN usuarios_unidades ON p.IdUnidad = usuarios_unidades.IdUnidad
LEFT JOIN facturas ON p.IdCliente = facturas.IdCliente AND p.IdProyecto = facturas.IdProyecto WHERE pr.NombreContacto LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
		case 5:
			$sql = "SELECT
pr.IdCliente AS IdCliente,
pr.IdProyecto AS IdProyecto,
pr.NombreProyecto AS NombreProyecto,
pr.NombreContacto AS NombreContacto,
pr.Ciudades AS Ciudades,
p.Aprobabo AS Estado,
p.IdPresupuesto AS IdPresupuesto,
p.Presupuesto AS Presupuesto,
p.Version AS Version,
p.FechaPresentacion AS FechaPresentacion,
p.TipoCliente AS TipoCliente,
p.FormaPago AS FormaPago,
p.Subtotal AS Subtotal,
p.Descuento AS Descuento,
p.KnowHow AS KnowHow,
p.Total AS Total,
c.NombreCliente AS NombreCliente,
te.TipoEmpresa AS TipoEmpresa,
usr.Nombre AS Presentadopor,
facturas.Factura
FROM
((presupuestos AS p
INNER JOIN proyectos AS pr ON ((pr.IdProyecto = p.IdProyecto)))
INNER JOIN clientes AS c ON ((pr.IdCliente = c.IdCliente)))
INNER JOIN tipoempresa AS te ON te.IdTipo = c.TipoEmpresa
INNER JOIN usuarios AS usr ON p.Presentadopor = usr.Usuario
INNER JOIN usuarios_unidades ON p.IdUnidad = usuarios_unidades.IdUnidad
LEFT JOIN facturas ON p.IdCliente = facturas.IdCliente AND p.IdProyecto = facturas.IdProyecto WHERE pr.IdProyecto = '".$valor."' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
			break;
	}
	
	if($_SESSION['unidad']!=0){
		$sql.=" AND usuarios_unidades.IdUnidad = '".$_SESSION['unidad']."'";
	}
	
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
?>

<div class="cuerpo">
    <h3>Consulta de <span>Presupuestos</span></h3>
    <p><img src="images/aprobado.png" />Presupuesto Aprobado<img src="images/noaprobado.png" />Presupuesto NO Aprobado</p>
	<table id="results">
        <thead>
            <tr>
                <th><div align="center"><label>Opciones</label></div></th>
                <th><div align="center"><label>Cliente</label></div></th>
                <th><div align="center"><label>Proyecto</label></div></th>
                <th><div align="center"><label>Presupuesto</label></div></th>
                <th><div align="center"><label>Fecha Presentaci&oacute;n</label></div></th>
                <th><div align="center"><label>Contacto</label></div></th>
                <th><div align="center"><label>Presentado por</label></div></th>
                <th><div><label>Total del Proyecto</label></div></th>
                <th><div><label>Factura</label></div></th>
            </tr>
        </thead>
        <tbody>
<?
	while($registros=mysql_fetch_assoc($consulta)){
		$seguimiento=$registros['IdPresupuesto'];
		$fecha=ConvFecha($registros['FechaPresentacion']);
		echo '<tr>';
		$linkaprobar='inicio.php?location=aprobarpres&seguimiento='.$seguimiento;
		$linkeliminar='inicio.php?location=borrarpres&seguimiento='.$seguimiento;
		$linkedicion='inicio.php?location=continuepres&seguimiento='.$seguimiento;
        
		echo '
        <td>
            <table class="tabla-opciones">
                <tr>
                    <td><a href="inicio.php?location=verpresup&seguimiento='.$seguimiento.'"><img src="images/ver.png"  /></a></td>
                    <td><img src="images/elimina.png" onclick="ValidaAccion(\''.$linkeliminar.'\')"/></td>
                    <td>';
                    if($_SESSION['unidad']!=0){
                        echo '<img src="images/editar.png"  onclick="ValidaAccion(\''.$linkedicion.'\')"/>';
                    }
              echo '</td>';
		      if($registros['Estado']==1){
			     echo '<td><div align="center"><img src="images/aprobado.png"></div></td>';	
		      }else{
			     echo '<td><div align="center"><img src="images/noaprobado.png" onclick="ValidaAccion(\''.$linkaprobar.'\')"></div></td>';
		      }
              echo '</tr>
              </table>
        </td>';
		echo '<td><div>'.$registros['NombreCliente'].'</div></td>';
		echo '<td><div>'.$registros['NombreProyecto'].'</div></td>';
		echo '<td><div>P'.$registros['Presupuesto'].' - V'.$registros['Version'].'</div></td>';
		echo '<td><div>'.$fecha.'</div></td>';
		echo '<td><div>'.$registros['NombreContacto'].'</div></td>';
		echo '<td><div>'.$registros['Presentadopor'].'</div></td>';
		echo '<td><div>'."$ ".number_format($registros['Total']).'</div></td>';
        if($registros['Factura']==null){
            echo '<td><div class="no-factura">Sin Factura</div></td>';
        }else{
            echo '<td><div>'.$registros['Factura'].'</div></td>';   
        }
		echo '</tr>';
	}
    mysql_close($cnn);
?>
            </tbody>
	   </table>
	</div>
<?
}
?>