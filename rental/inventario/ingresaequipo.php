<?php
	session_start();
	include ('../../Connections/cnn.php');
	include ('../../funciones.php');
if(isset($_SESSION['usuario'])){
	$categoria=$_POST['scateg'];
	$propietario=$_POST['sown'];
    $nombre=strtoupper($_POST['nequ']);
	$marca=strtoupper($_POST['nmarca']);
	$modelo=strtoupper($_POST['nmodel']);
	$serie=strtoupper($_POST['nserie']);
	$fechac=aMySQL($_POST['fechac']);
	$valorc=aNumero($_POST['vcomer']);
	$valora=aNumero($_POST['valianz']);
    $valorpresente=aNumero($_POST['vpres']);
    $peso=$_POST['peso'];
    $amortizacion=aNumero($_POST['amort']);
    $mantenimiento=aNumero($_POST['mant']);
    $intkanual=aNumero($_POST['inter']);
    $seguro=aNumero($_POST['seguro']);
    $reposicion=aNumero($_POST['repos']);
    $costoalquiler=aNumero($_POST['alquiler']);
    $costofreelance=aNumero($_POST['freelance']);
    $costotransporte=aNumero($_POST['transporte']);
    $costooperacion=aNumero($_POST['operacion']);
    $costototal=aNumero($_POST['total']);
    $vrincluidorentabilidad1=aNumero($_POST['rent1']);
    $vrincluidorentabilidad2=aNumero($_POST['rent2']);
    $estado=1;
    $caracteristicas=strtoupper($_POST['caract']);
    
    $imagen=$_FILES['image']['name'];
    $tipo=$_FILES['image']['type'];
    $tamano=$_FILES['image']['size'];
    $tmpname=$_FILES['image']['tmp_name'];
    $error=$_FILES['image']['error'];
 
    
    
     //$data = file_get_contents($_FILES['image']['tmp_name']);
     //$data = mysql_real_escape_string($data);
    
    //if(isset($_POST['image'])&& $tamano>0){
      $fp=fopen($tmpname, 'r');
      $data=fread($fp, filesize($tmpname));
      $data=addslashes($data);
      fclose($fp);  
    //}
    
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sql="INSERT INTO inventario (IdCategoria, IdPropietario, Articulo, Caracteristicas, Marca, Modelo, Serie, FechaCompra, ValorPresente, Peso, Amortizacion, Mantenimiento, IntKAnual, Seguro, Reposicion, CostoAlquiler, CostoFreelance, CostoTransporte, CostoOperacion, CostoTotal, VrIncluidoRentabilidad1, VrIncluidoRentabilidad2, PrecioComercial, PrecioAlianza, IdEstado, Imagen ) VALUES ('$categoria','$propietario','$nombre','$caracteristicas','$marca','$modelo','$serie','$fechac','$valorpresente','$peso','$amortizacion','$mantenimiento','$intkanual','$seguro','$reposicion','$costoalquiler','$costofreelance', '$costotransporte', '$costooperacion','$costototal','$vrincluidorentabilidad1','$vrincluidorentabilidad2','$valorc','$valora','$estado','".$data."')";
	$clt=mysql_query($sql,$cnn) or die(mysql_error());
    $codigoequipo=mysql_insert_id();
	header("Location: ../rental.php?location=confnequip&equipo=".$codigoequipo);
	mysql_close($cnn);
}
?>