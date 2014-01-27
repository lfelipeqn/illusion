<?php
	session_start();
	include('../Connections/cnn.php');
	include ('../funciones.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	
	$orden=$_POST['orden'];
	
    $sqlorden="SELECT orden_compra.IdOrden, orden_compra.VrCompra, orden_compra_estado.IdEstadoOrden,
orden_compra_estado.EstadoOrden, proveedores.NombreProveedor, clientes.NombreCliente, proyectos.IdProyecto, proyectos.NombreProyecto 
FROM orden_compra 
INNER JOIN proveedores ON orden_compra.IdProveedor = proveedores.Identificacion
INNER JOIN produccion ON orden_compra.IdProduccion = produccion.IdProduccion
INNER JOIN proyectos ON produccion.IdProyecto = proyectos.IdProyecto
INNER JOIN clientes ON produccion.IdCliente = clientes.IdCliente
LEFT JOIN orden_compra_estado ON orden_compra.IdEstadoOrden = orden_compra_estado.IdEstadoOrden WHERE orden_compra.IdOrden='".$orden."'";
	
	$clorden=mysql_query($sqlorden,$cnn) or die (mysql_error());
	$rsorden=mysql_fetch_assoc($clorden);
    $resultado = array();
    
    $row['NombreCliente']=$rsorden['NombreCliente'];
    $row['NombreProveedor']=$rsorden['NombreProveedor'];
    $row['NombreProyecto']=$rsorden['NombreProyecto'];
    $row['IdEstadoOrden']=$rsorden['IdEstadoOrden'];
    $row['VrCompra']=$rsorden['VrCompra'];
    
    array_push($resultado, $row);
    mysql_close($cnn);
	echo json_encode($resultado);
}
?>