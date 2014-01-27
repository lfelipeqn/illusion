<?php
	session_start();
	include '../../Connections/cnn.php';
	include '../../funciones.php';
	date_default_timezone_set("America/Bogota");
if(isset($_SESSION['usuario'])){
	
	$connect=mysql_select_db($rental_cnn,$cnn);
    
	$valorevento=0;
    $evento=$_POST['idevento'];
	$precio=$_POST['tipop'];
	$tequipo=$_POST['nequipos'];
	$tpersona=$_POST['npersona'];
    $tconcepto=$_POST['tfilas'];
	$fecha=date("Y-m-d H:i:s");
	
    $sqldetalle="DELETE FROM eventos_detalle WHERE IdEvento=$evento";
    $cltdetalle=mysql_query($sqldetalle,$cnn) or die(mysql_error());
    $sqlconceptos="DELETE FROM eventos_conceptos WHERE IdEvento=$evento";
    $cltconceptos=mysql_query($sqlconceptos,$cnn) or die(mysql_error());
    $sqlproveedores="DELETE FROM eventos_proveedores WHERE IdEvento=$evento";
    $cltproveedores=mysql_query($sqlproveedores,$cnn) or die(mysql_error());
    
	$sqlevento="SELECT eventos.IdEvento, eventos.Evento, eventos.Dias FROM eventos WHERE eventos.IdEvento=".$evento;
	$cltevento=mysql_query($sqlevento,$cnn) or die(mysql_error());
	$rsevento=mysql_fetch_assoc($cltevento);
	$dias=$rsevento['Dias'];
	
	for($i=1;$i<=$tequipo;$i++){
		$tipomovimiento=1;
		$equipo=$_POST['ceq'.$i];
		$vequipo=aNumero($_POST['veq'.$i]);
		if ($equipo!=''){
			$sqldet="INSERT INTO eventos_detalle (IdEvento, Fecha, Codigo, ValorEquipo, Dias) VALUES ('".$evento."','".$fecha."','".$equipo."','".$vequipo."','".$dias."')";
			$cltdet=mysql_query($sqldet,$cnn) or die(mysql_error());
			
			$sqlhist="INSERT INTO historial (Codigo, IdTipo, Fecha, IdEvento) VALUES ('".$equipo."','".$tipomovimiento."','".$fecha."','".$evento."')";
			$clthist=mysql_query($sqlhist,$cnn) or die(mysql_error());
			$sqlestado="UPDATE inventario SET IdEstado=3 WHERE inventario.Codigo='".$equipo."'";
			$cltestado=mysql_query($sqlestado,$cnn) or die(mysql_error());		
		}
		$valorevento+=$vequipo;
	}
	
    for($k=1;$k<=$tconcepto;$k++){
        $concepto=$_POST['concepto'.$k];
        $valconcepto=aNumero($_POST['valconcepto'.$k]);
        $sqlconcepto="INSERT INTO eventos_conceptos (IdEvento, IdConcepto, ValorConcepto) VALUES ('$evento','$concepto','$valconcepto')";
        $cltconcepto=mysql_query($sqlconcepto,$cnn) or die(mysql_error());
    }
    
	for($j=1;$j<=$tpersona;$j++){
		$proveedor=$_POST['prov'.$j];
        $tipo=$_POST['tipop'.$j];
		$especialidad=$_POST['esp'.$j];
		$valor=aNumero($_POST['val'.$j]);
		$sqlprov="INSERT INTO eventos_proveedores (IdEvento, IdProveedor, IdTipo, IdNivel, Valor) VALUES ('".$evento."','".$proveedor."','".$tipo."','".$especialidad."','".$valor."')";
		$cltprov=mysql_query($sqlprov,$cnn) or die(mysql_error());
	}
	
	$sqlvalev="UPDATE eventos SET CostoEvento='".aNumero($valorevento)."' WHERE IdEvento='".$evento."'";
	$cltvalev=mysql_query($sqlvalev,$cnn) or die(mysql_error());
	header("Location: ../rental.php?location=confsalida");
}
?>