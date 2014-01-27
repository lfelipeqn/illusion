<?php
	session_start();
	include('../Connections/cnn.php');
	$user=$_POST['usuario'];
	$pass=md5($_POST['password']);
	
    $sql="SELECT proveedores.Identificacion, proveedores.clave, proveedores.NombreProveedor 
    FROM proveedores 
    WHERE proveedores.Identificacion = $user AND proveedores.clave = '$pass'";
	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
	$existe=mysql_num_rows($consulta);
	if ($existe>0){
	   $rsusuario=mysql_fetch_assoc($consulta);
	   $_SESSION['usuario']=$user;
       mysql_free_result($consulta);
	   echo 'inicio.php?location=inicio';
	}else{
       echo 'error';
	}
?>