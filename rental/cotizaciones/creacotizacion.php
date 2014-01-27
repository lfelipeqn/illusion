<?php
	session_start();
	include '../../Connections/cnn.php';
	include '../../funciones.php';

if(isset($_SESSION['usuario'])){	
 $equipos=$_POST['nequipos'];
 //$equipos--;
 $cliente=$_POST['scliente'];
 $precio=$_POST['tipop'];
 $dias=$_POST['tdias'];
 $proyecto=$_POST['sproy'];
 $valorevento=aNumero($_POST['tevento']);
 //$proveedores=$_POST['npersona'];
 $filasadc=$_POST['tfilas'];

 $fecha=date("Y-m-d");
 $usuario=$_SESSION['usuario'];
 $conect=mysql_select_db($rental_cnn,$cnn);
	
 $ncotiz="INSERT INTO cotizacion(Fecha, IdCliente, IdProyecto, IdPrecio, Elementos, Dias, Total, Usuario) VALUES ('".$fecha."','".$cliente."', '".$proyecto."', '".$precio."','".$equipos."','".$dias."', '".$valorevento."', '".$usuario."')";
 $cltcotiz=mysql_query($ncotiz,$cnn) or die(mysql_error());
 $idcotizacion=mysql_insert_id();
	
 for($i=1;$i<=$equipos;$i++){
	$cequip=$_POST['ceq'.$i];
    $vequip=aNumero($_POST['veq'.$i]);
    if(($cequip!="")||($cequip!=0)){
	   $sqldetalle="INSERT INTO cotizacion_detalle (IdCotizacion, Codigo, Valor) VALUES ('".$idcotizacion."', '".$cequip."', '".$vequip."')";
	   $cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
	}
  }
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