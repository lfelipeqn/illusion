<?php
	session_start();
	include ('../../Connections/cnn.php');
	include ('../../funciones.php');
if(isset($_SESSION['usuario'])){
	$concepto=strtolower($_POST['conc']);
    $rconcept=strtoupper(substr($concepto,0,1));
    $rconcept=$rconcept.substr($concepto,1,strlen($concepto)-1);
    
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sql="INSERT INTO conceptos (Concepto) VALUES ('$rconcept')";
	$clt=mysql_query($sql,$cnn) or die(mysql_error());
	header("Location: ../rental.php?location=confconc");
	mysql_close($cnn);
}
?>