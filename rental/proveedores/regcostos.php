<?php
	session_start();
if(isset($_SESSION['usuario'])){
	include('../../Connections/cnn.php');
	include('../../funciones.php');
	$idtipo=$_POST['stipo'];
	$proveedor=$_POST['sprov'];
    $total=$_POST['total'];
	$conect=mysql_select_db($rental_cnn,$cnn);

	for($i=1;$i<=$total;$i++){
	   $str="INSERT INTO proveedores_tipo_nivel (IdTipo, IdNivel, IdentificacionProveedor, MediaJornada, Jornada, JornadaExtendida, HoraAdicional, HoraAdicionalNoche) VALUES ('$idtipo', '".$_POST['nivel'.$i]."', '$proveedor', '".aNumero($_POST['media'.$i])."', '".aNumero($_POST['jornada'.$i])."', '".aNumero($_POST['extendida'.$i])."', '".aNumero($_POST['hora'.$i])."', '".aNumero($_POST['adicnoche'.$i])."')";
       echo $str;
       $insert=mysql_query($str,$cnn) or die (mysql_error());  
	}
	
	mysql_close($cnn);
	header("Location: ../rental.php?location=confvalprov");
}
?>