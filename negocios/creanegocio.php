<?php
	session_start();
	include('../Connections/cnn.php');
	include('../funciones.php');
if(isset($_SESSION['usuario'])){
	$fecha=date('Y-m-d');
	if(isset($_POST['vanticipo'])){
	   $anticipo=aNumero($_POST['vanticipo']);   
	}else{
	   $anticipo=0;
	}
    
    if(isset($_POST['nantic'])){
        $porcantic=aNumero($_POST['nantic'])/100;    
    }else{
        $porcantic=0;
    }
	
	$nombrecliente=$_POST['ncliente'];
	$nombreproyecto=$_POST['pproy'];
	$presupuesto=$_POST['consp'];
	$plazo=$_POST['nplazo'];
	
	$conect=mysql_select_db($database_cnn,$cnn);
	$str="insert into negocios(IdCliente, IdProyecto, IdPresupuesto, FechaCreacion, Anticipo, PorcAnticipo, Observaciones, 
    PorAD, ValAD, PorDG, ValDG, PorBM, ValBM, PorPR, ValPR, IdUnidad) 
    values('".$_POST['ncliente']."', '".$_POST['pproy']."','".$_POST['consp']."', '$fecha', '$anticipo','$porcantic', 
    '".strtoupper($_POST['nobs'])."', 
    '".$_POST['padm']."', '".aNumero($_POST['vadm'])."', 
    '".$_POST['pdg']."', '".aNumero($_POST['vdg'])."', 
    '".$_POST['pbm']."', '".aNumero($_POST['vbm'])."', 
    '".$_POST['ppr']."', '".aNumero($_POST['vpr'])."', 
    '".$_SESSION['unidad']."')";
    
    $insert=mysql_query($str,$cnn) or die (mysql_error());
	if ($insert){
	   $cadinspl="INSERT INTO negocios_plazo(IdNegocio, IdCliente, IdProyecto, IdPresupuesto, plazopago) VALUES('".$rstipon['IdNegocio']."','$nombrecliente','$nombreproyecto','$presupuesto','$plazo')";
       $inspl=mysql_query($cadinspl,$cnn) or die(mysql_error());
    }
    
    $cadcliente="select clientes.IdCliente, clientes.NombreCliente from clientes where clientes.IdCliente='".$nombrecliente."'";
    $cadproyecto="select proyectos.IdProyecto, proyectos.NombreProyecto from proyectos where proyectos.IdProyecto='".$nombreproyecto."'";
    
    $clclie=mysql_query($cadcliente,$cnn) or die(mysql_error());
    $clproy=mysql_query($cadproyecto,$cnn) or die(mysql_error());
    
    $rsnego=mysql_fetch_assoc($clenv);
    $rsclie=mysql_fetch_assoc($clclie);
    $rsproy=mysql_fetch_assoc($clproy);
    
    $mensaje="Se Ha creado un nuevo negocio de ".$rsnego['Unidad']." para el cliente ".strtoupper($rsclie['NombreCliente'])." y el Proyecto ".strtoupper($rsproy['NombreProyecto']);
    Alerta('ConfirmaNegocio','Se ha Creado un Nuevo Negocio',$mensaje,$_SESSION['unidad']);
    
    mysql_close($cnn);
    header("Location: ../inicio.php?location=confnegocio");
}

?>