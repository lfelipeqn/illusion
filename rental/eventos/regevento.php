<?php
	session_start();
    date_default_timezone_set("America/Bogota");
if(isset($_SESSION['usuario'])){
	include('../../Connections/cnn.php');
	include('../../funciones.php');
	$conect=mysql_select_db($rental_cnn,$cnn);
	
    $cliente=$_POST['scliente'];
    $proyect=$_POST['sproy'];
	
	$horas=aNumero($_POST['nhoras']);
    $fecha=date("Y-m-d H:i:s");
    
    $sqldias="SELECT DATEDIFF(proyectos.FechaDesmontaje,proyectos.FechaMontaje)+1 AS Dias 
    FROM proyectos 
    WHERE proyectos.IdProyecto=$proyect";
    $cltdias=mysql_query($sqldias,$cnn) or die(mysql_error());
    $rsdias=mysql_fetch_assoc($cltdias);
    $dias=$rsdias['Dias'];
    
    $sqlcotiz="SELECT proyectos.IdProyecto, proyectos.IdCliente, cotizacion.IdCotizacion, cotizacion.IdPrecio 
    FROM proyectos INNER JOIN cotizacion ON proyectos.IdProyecto = cotizacion.IdProyecto 
    WHERE cotizacion.estado = 1 AND proyectos.IdCliente = $cliente AND proyectos.IdProyecto = $proyect";
    $cltcotiz=mysql_query($sqlcotiz,$cnn) or die(mysql_error());
    $rscotiz=mysql_fetch_assoc($cltcotiz);
    $cotiz=$rscotiz['IdCotizacion'];
    $tipop=$rscotiz['IdPrecio'];
    
	$str="insert into eventos(IdProyecto, IdCliente, Dias, Horas, Valor, IdCotizacion) values('$proyect','$cliente', '$dias', '$horas', '$tipop', '$cotiz')";
	$insert=mysql_query($str,$cnn) or die (mysql_error());
    $idevento=mysql_insert_id();
    
    $sqldetalle="INSERT INTO eventos_detalle (IdEvento,Fecha, Codigo,ValorEquipo,Dias) SELECT eventos.IdEvento, now(), cotizacion_detalle.Codigo, cotizacion_detalle.Valor, eventos.Dias FROM eventos INNER JOIN cotizacion_detalle ON eventos.IdCotizacion = cotizacion_detalle.IdCotizacion WHERE eventos.IdEvento=$idevento";
    $cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());

    $sqlconceptos="INSERT INTO eventos_conceptos (IdEvento, IdConcepto, ValorConcepto) SELECT eventos.IdEvento, cotizacion_conceptos.IdConcepto, cotizacion_conceptos.ValorConcepto FROM eventos INNER JOIN cotizacion_conceptos ON eventos.IdCotizacion = cotizacion_conceptos.IdCotizacion WHERE eventos.IdEvento=$idevento";
    $cltconceptos=mysql_query($sqlconceptos,$cnn) or die(mysql_error());   
    
	mysql_close($cnn);
	header("Location: ../rental.php?location=confirmaevn");
}

?>