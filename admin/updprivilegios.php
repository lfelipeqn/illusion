<?php
    session_start();
    include('../Connections/cnn.php');
    $conecta=mysql_select_db($database_cnn,$cnn);
    $filas=$_POST['filas'];
    for ($i=1;$i<=$filas;$i+=1){
        $perfil=$_POST['perfil'.$i];
        
        if (isset($_POST['ingresorental'.$i])){
            $accrental=1;    
        }else{
            $accrental=0;
        }
        
        if (isset($_POST['crearclientes'.$i])){
            $crcliente=1;    
        }else{
            $crcliente=0;
        }
        
        if (isset($_POST['consultarclientes'.$i])){
            $clcliente=1;    
        }else{
            $clcliente=0;
        }
        
        if (isset($_POST['actualizarclientes'.$i])){
            $accliente=1;    
        }else{
            $accliente=0;
        }
        
        if (isset($_POST['crearproveedor'.$i])){
            $crproveedor=1;    
        }else{
            $crproveedor=0;
        }
        
        if (isset($_POST['consultarproveedor'.$i])){
            $clproveedor=1;    
        }else{
            $clproveedor=0;
        }
        
        if (isset($_POST['verproveedor'.$i])){
            $vrproveedor=1;    
        }else{
            $vrproveedor=0;
        }
        
        if (isset($_POST['actualizarproveedor'.$i])){
            $acproveedor=1;    
        }else{
            $acproveedor=0;
        }
        
        if (isset($_POST['eliminarproveedor'.$i])){
            $elproveedor=1;    
        }else{
            $elproveedor=0;
        }
        
        if (isset($_POST['crearproyecto'.$i])){
            $crproyecto=1;    
        }else{
            $crproyecto=0;
        }
        
        if (isset($_POST['consultarproyecto'.$i])){
            $clproyecto=1;    
        }else{
            $clproyecto=0;
        }
        
        if (isset($_POST['actualizarproyecto'.$i])){
            $acproyecto=1;    
        }else{
            $acproyecto=0;
        }
        
        if (isset($_POST['verproyecto'.$i])){
            $verproyecto=1;    
        }else{
            $verproyecto=0;
        }
            
        if (isset($_POST['crearpresupuesto'.$i])){
            $crpresupuesto=1;    
        }else{
            $crpresupuesto=0;
        }
        
        if (isset($_POST['consultarpresupuesto'.$i])){
            $clpresupuesto=1;    
        }else{
            $clpresupuesto=0;
        }
        
        if (isset($_POST['verpresupuesto'.$i])){
            $verpresupuesto=1;    
        }else{
            $verpresupuesto=0;
        }
        
        if (isset($_POST['aprobarpresupuesto'.$i])){
            $appresupuesto=1;    
        }else{
            $appresupuesto=0;
        }
        
        if (isset($_POST['eliminarpresupuesto'.$i])){
            $elpresupuesto=1;    
        }else{
            $elpresupuesto=0;
        }
        
        if (isset($_POST['actualizarpresupuesto'.$i])){
            $acpresupuesto=1;    
        }else{
            $acpresupuesto=0;
        }
        
        if (isset($_POST['confirmapresupuesto'.$i])){
            $cfpresupuesto=1;    
        }else{
            $cfpresupuesto=0;
        }
        
        if (isset($_POST['crearnegocio'.$i])){
            $crnegocio=1;    
        }else{
            $crnegocio=0;
        }
        
        if (isset($_POST['consultarnegocio'.$i])){
            $clnegocio=1;    
        }else{
            $clnegocio=0;
        }
        
        if (isset($_POST['vernegocio'.$i])){
            $vernegocio=1;    
        }else{
            $vernegocio=0;
        }
        
        if (isset($_POST['eliminarnegocio'.$i])){
            $elnegocio=1;    
        }else{
            $elnegocio=0;
        }
        
        if (isset($_POST['confirmanegocio'.$i])){
            $cfnegocio=1;    
        }else{
            $cfnegocio=0;
        }
        
        if (isset($_POST['asignarproduccion'.$i])){
            $asproduccion=1;    
        }else{
            $asproduccion=0;
        }
        
        if (isset($_POST['consultarproduccion'.$i])){
            $clproduccion=1;    
        }else{
            $clproduccion=0;
        }
        
        if (isset($_POST['editarproduccion'.$i])){
            $edproduccion=1;    
        }else{
            $edproduccion=0;
        }
        
        if (isset($_POST['eliminarproduccion'.$i])){
            $elproduccion=1;    
        }else{
            $elproduccion=0;
        }
        
        if (isset($_POST['crearordencompra'.$i])){
            $crcompra=1;    
        }else{
            $crcompra=0;
        }
        
        if (isset($_POST['verproduccion'.$i])){
            $vrproduccion=1;    
        }else{
            $vrproduccion=0;
        }
        
        if (isset($_POST['levantarproduccion'.$i])){
            $lvproduccion=1;    
        }else{
            $lvproduccion=0;
        }
        
        if (isset($_POST['finalizarproduccion'.$i])){
            $fnproduccion=1;    
        }else{
            $fnproduccion=0;
        }
        
        if (isset($_POST['aprobarproduccion'.$i])){
            $approduccion=1;    
        }else{
            $approduccion=0;
        }
        
        
        if (isset($_POST['confirmaproduccion'.$i])){
            $cnproduccion=1;    
        }else{
            $cnproduccion=0;
        }
        
        if (isset($_POST['crearfactura'.$i])){
            $cnfactura=1;    
        }else{
            $cnfactura=0;
        }
        
        if (isset($_POST['verrentabilidad'.$i])){
            $cnrentabilidad=1;    
        }else{
            $cnrentabilidad=0;
        }
        
        
        
        $sqlprivilegios="UPDATE perfiles SET INgresoRental=$accrental, ConfirmaPresupuesto=$cfpresupuesto, ConfirmaNegocio=$cfnegocio, CrearClientes=$crcliente, ConsultarClientes=$clcliente, ActualizarClientes=$accliente, CrearProveedor=$crproveedor, ConsultarProveedor=$clproveedor, VerProveedor=$vrproveedor, ActualizarProveedor=$acproveedor, EliminarProveedor=$elproveedor, CrearProyecto=$crproyecto, ConsultarProyecto=$clproyecto, ActualizarProyecto=$acproyecto, VerProyecto=$verproyecto, CrearPresupuesto=$crpresupuesto, ConsultarPresupuesto=$clpresupuesto, VerPresupuesto=$verpresupuesto, AprobarPresupuesto=$appresupuesto, EliminarPresupuesto=$elpresupuesto, ActualizarPresupuesto=$acpresupuesto, CrearNegocio=$crnegocio, ConsultarNegocio=$clnegocio, VerNegocio=$vernegocio, EliminarNegocio=$elnegocio, AsignarProduccion=$asproduccion, ConsultarProduccion=$clproduccion, EditarProduccion=$edproduccion, EliminarProduccion=$elproduccion, CrearOrdenCompra=$crcompra, VerProduccion=$vrproduccion, LevantarProduccion=$lvproduccion, FinalizarProduccion=$fnproduccion, AprobarProduccion=$approduccion, CrearFactura=$cnfactura, VerRentabilidad=$cnrentabilidad WHERE perfiles.Perfil='$perfil'";
        $cltprivilegios=mysql_query($sqlprivilegios,$cnn) or die(mysql_error());
        
        header("Location: admin.php?location=confpvr");  
    } 
?>