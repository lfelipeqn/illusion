<?php
	include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$conect=mysql_select_db($database_cnn,$cnn);
	
    $proveedor=$_POST['proveedor'];
    $clave=md5($_POST['conf']);
    $actual=md5($_POST['actual']);
    $tipo=$_POST['tipo'];
    $resp='';
    
    if($tipo=='actual'){
        $str="SELECT clave, Identificacion FROM proveedores where (clave = '".$actual."' AND Identificacion='".$proveedor."')";
        $actual=mysql_query($str,$cnn) or die (mysql_error());
        $total=mysql_num_rows($actual);
        if($total>=1){
            $resp = '1';
        }else{
            $resp = '0';    
        }
    }
    
    if($tipo=='cambio'){
        $str="Update proveedores set clave='".$clave."' where (Identificacion='".$proveedor."')";
        $actual=mysql_query($str,$cnn) or die (mysql_error());
        $resp = 'Cambio de Clave Realizado';
    }
    
    mysql_close($cnn);
	echo $resp;
}
?>