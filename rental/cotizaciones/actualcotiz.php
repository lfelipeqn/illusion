<?php
	session_start();
	include '../../Connections/cnn.php';
	include '../../funciones.php';

if(isset($_SESSION['usuario'])){
 $equipos=0;   
 $equipos=$_POST['nequipos'];
 $equipos--;
 $cliente=$_POST['ncliente'];
 $precio=$_POST['tipop'];
 $dias=$_POST['tdias'];
 $valorevento=aNumero($_POST['tevento']);
 //$proveedores=$_POST['npersona'];
 $filasadc=$_POST['tfilas'];
 $cotiz=$_POST['ncotizacion'];

 $fecha=date("Y-m-d");
 $usuario=$_SESSION['usuario'];
 $conect=mysql_select_db($rental_cnn,$cnn);
	
 $ncotiz="UPDATE cotizacion SET Fecha='$fecha', IdCliente='$cliente', IdPrecio='$precio', Elementos='$equipos', Dias='$dias', Total='$valorevento', Usuario='$usuario' WHERE cotizacion.IdCotizacion=$cotiz";
 $cltcotiz=mysql_query($ncotiz,$cnn) or die(mysql_error());
 $idcotizacion=$cotiz;

 $del_detalle="DELETE FROM cotizacion_detalle WHERE cotizacion_detalle.IdCotizacion=$idcotizacion";
 $clt_detalle=mysql_query($del_detalle,$cnn) or die(mysql_error());	
 for($i=1;$i<=$equipos;$i++){
	$cequip=$_POST['ceq'.$i];
    $vequip=aNumero($_POST['veq'.$i]);
    if(($cequip!="")||($cequip!=0)){
	   $sqldetalle="INSERT INTO cotizacion_detalle (IdCotizacion, Codigo, Valor) VALUES ('".$idcotizacion."', '".$cequip."', '".$vequip."')";
	   $cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
	}
  }
  
 $del_condeptos="DELETE FROM cotizacion_conceptos WHERE cotizacion_conceptos.IdCotizacion=$idcotizacion";
 $clt_conceptos=mysql_query($del_condeptos,$cnn) or die(mysql_error()); 
 $valadicionales=0;
 for ($j=1;$j<=$filasadc;$j++){
   $tipocon=$_POST['concepto'.$j];
   $valorcon=aNumero($_POST['valconcepto'.$j]);
   $valadicionales+=$valorcon;
   $cltconcepto="INSERT INTO cotizacion_conceptos(IdCotizacion, IdConcepto, ValorConcepto) VALUES ('".$idcotizacion."', '".$tipocon."', '".$valorcon."')";
   $sqlconcepto=mysql_query($cltconcepto,$cnn) or die(mysql_error());   
 }
  
 $sqlupadc="UPDATE cotizacion SET adicionales=".$valadicionales." WHERE cotizacion.IdCotizacion=".$idcotizacion;
 $cltupadc=mysql_query($sqlupadc,$cnn) or die(mysql_error());
    
 mysql_close($cnn);
 header("Location: ../rental.php?location=confcot");
}
?>