<?php
	include '../../Connections/cnn.php';
	
    $connect=mysql_select_db($rental_cnn,$cnn);		
	
	$cliente=$_GET['cliente'];	
	$resultado = array();
    
	$sqlproyecto="SELECT proyectos.IdProyecto, proyectos.NombreProyecto 
    FROM proyectos 
    INNER JOIN cotizacion ON proyectos.IdProyecto = cotizacion.IdProyecto 
    WHERE proyectos.IdCliente = '$cliente' AND cotizacion.estado =1";	
    $resultado=array();	
	$cltproyecto=mysql_query($sqlproyecto,$cnn);
	
	while($rsproyecto=mysql_fetch_assoc($cltproyecto)){
		$row['IdProyecto']=$rsproyecto['IdProyecto'];
		$row['NombreProyecto']=$rsproyecto['NombreProyecto'];	
		array_push($resultado,$row);
	}	
	
	echo json_encode($resultado);
?>