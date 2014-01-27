<?php
    session_start();
    include('../Connections/cnn.php');
    $conecta=mysql_select_db($database_cnn,$cnn);
    $filas=$_POST['filas'];
    for ($i=1;$i<=$filas;$i+=1){
        $usuario=$_POST['usuario'.$i];
        
        if (isset($_POST['confirmapresupuesto'.$i])){
            $cpresupuesto=1;    
        }else{
            $cpresupuesto=0;
        }
        
        
        if (isset($_POST['confirmanegocio'.$i])){
            $cnegocio=1;    
        }else{
            $cnegocio=0;
        }
        
        if (isset($_POST['confirmaproduccion'.$i])){
            $cproduccion=1;    
        }else{
            $cproduccion=0;
        }
        
        if (isset($_POST['apruebaproduccion'.$i])){
            $aproduccion=1;    
        }else{
            $aproduccion=0;
        }
        
        if (isset($_POST['alertavalidacion'.$i])){
            $avalidacion=1;    
        }else{
            $avalidacion=0;
        }        
        
        
        $sqlusuarios="UPDATE usuarios SET ConfirmaPresupuesto=$cpresupuesto, ConfirmaNegocio=$cnegocio, ConfirmaProduccion=$cproduccion, ApruebaProduccion=$aproduccion, AlertaValidacion=$avalidacion WHERE usuarios.Usuario='$usuario'";
        $cltusuarios=mysql_query($sqlusuarios,$cnn) or die(mysql_error());
        
        header("Location: admin.php?location=confnotif");  
    } 
?>