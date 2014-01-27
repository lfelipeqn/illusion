<?php
	session_start();
	include '../../Connections/cnn.php';
	include '../../funciones.php';
	date_default_timezone_set("America/Bogota");
if(isset($_SESSION['usuario'])){
	$valorevento=0;
	$connect=mysql_select_db($rental_cnn,$cnn);
	$evento=$_POST['idevento'];
	$precio=$_POST['tipop'];
	$tequipo=$_POST['nequipos'];
	$fecha=date("Y-m-d H:i:s");
	
	for($i=1;$i<=$tequipo;$i++){
		$equipo=$_POST['ceq'.$i];
		if ($equipo!=''){
			$sqldet="UPDATE eventos_detalle SET Entrada='".$fecha."' WHERE eventos_detalle.IdEvento='".$evento."' AND eventos_detalle.Codigo='".$equipo."'";
			$cltdet=mysql_query($sqldet,$cnn) or die(mysql_error());		
		}
	}
	
	$sqlvalida="SELECT eventos_detalle.IdRegistro, eventos_detalle.IdEvento, eventos_detalle.Fecha, eventos_detalle.Codigo, eventos_detalle.ValorEquipo, eventos_detalle.Dias, eventos_detalle.Entrada FROM eventos_detalle WHERE eventos_detalle.IdEvento=".$evento." AND eventos_detalle.Entrada<=0";
	$cltvalida=mysql_query($sqlvalida,$cnn) or die(mysql_error());
	$faltantes=mysql_num_rows($cltvalida);
	
	if ($faltantes==0){
		for($j=1;$j<=$tequipo;$j++){
			$tipomovimiento=2;
			$equipo=$_POST['ceq'.$j];
			if ($equipo!=''){
				$sqlhist="INSERT INTO historial (Codigo, IdTipo, Fecha, IdEvento) VALUES ('".$equipo."','".$tipomovimiento."','".$fecha."','".$evento."')";
				$clthist=mysql_query($sqlhist,$cnn) or die(mysql_error());
				$sqlestado="UPDATE inventario SET IdEstado=1 WHERE inventario.Codigo='".$equipo."'";
				$cltestado=mysql_query($sqlestado,$cnn) or die(mysql_error());		
			}
		}
        
        $sqlfinaliza="UPDATE eventos SET Finalizado=1 WHERE IdEvento=$evento";
        $cltfinaliza=mysql_query($sqlfinaliza,$cnn) or die(mysql_error());
        
		header("Location: ../rental.php?location=confentrada");
	}else{
		$sqlno="UPDATE eventos_detalle SET Entrada=0 WHERE eventos_detalle.IdEvento=".$evento;
		$cltno=mysql_query($sqlno,$cnn) or die(mysql_error());		
		header("Location: ../rental.php?location=novalida&numero=".$faltantes);
	}
}
?>