<?php
    include '../Connections/cnn.php';
    $connect = mysql_select_db($database_cnn,$cnn);
    $sqlperfiles="SELECT perfiles.IdPerfil, perfiles.Perfil, perfiles.ConfirmaPresupuesto, perfiles.ConfirmaNegocio, perfiles.ConfirmaProduccion, perfiles.IngresoRental, perfiles.CrearClientes, perfiles.ConsultarClientes, perfiles.ActualizarClientes, perfiles.CrearProveedor, perfiles.ConsultarProveedor, perfiles.VerProveedor, perfiles.ActualizarProveedor, perfiles.EliminarProveedor, perfiles.CrearProyecto, perfiles.ConsultarProyecto, perfiles.ActualizarProyecto, perfiles.VerProyecto, perfiles.CrearPresupuesto, perfiles.ConsultarPresupuesto, perfiles.VerPresupuesto, perfiles.AprobarPresupuesto, perfiles.EliminarPresupuesto, perfiles.ActualizarPresupuesto, perfiles.CrearNegocio, perfiles.ConsultarNegocio, perfiles.VerNegocio, perfiles.EliminarNegocio, perfiles.AsignarProduccion, perfiles.ConsultarProduccion, perfiles.EditarProduccion, perfiles.EliminarProduccion, perfiles.CrearOrdenCompra, perfiles.VerProduccion, perfiles.LevantarProduccion, perfiles.FinalizarProduccion, perfiles.AprobarProduccion, perfiles.CrearFactura, perfiles.VerRentabilidad FROM perfiles"; 
    $cltperfiles=mysql_query($sqlperfiles,$cnn) or die(mysql_error());
    
    echo'<form action="updprivilegios.php" method="post" id="asprivilegios" name="asprivilegios">';
    echo '<br /><div align="left"><input type="submit" style="background-color:white; font-weight:bold; font-size:12px; width:250px" value="Aplicar Cambios en Privilegios" style="width:210px"></div><br />';
    echo '<input type="hidden" name ="filas" id="filas" value="'.mysql_num_rows($cltperfiles).'" />';
    echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="privilegios">
            <thead>
                <tr>
                    <th>Nombre Perfil</th>
                    <th>IngresoRental</th>
                    <th>CrearClientes</th>
                    <th>ConsultarClientes</th>
                    <th>ActualizarClientes</th>
                    
                    <th>CrearProveedor</th>
                    <th>ConsultarProveedor</th>
                    <th>VerProveedor</th>
                    <th>ActualizarProveedor</th>
                    <th>EliminarProveedor</th>
                    
                    <th>CrearProyecto</th>
                    <th>ConsultarProyecto</th>
                    <th>ActualizarProyecto</th>
                    <th>VerProyecto</th>
                    
                    <th>CrearPresupuesto</th>
                    <th>ConsultarPresupuesto</th>
                    <th>VerPresupuesto</th>
                    <th>AprobarPresupuesto</th>
                    <th>EliminarPresupuesto</th>
                    <th>ActualizarPresupuesto</th>
                    <th>ConfirmaPresupuesto</th>
                    
                    <th>CrearNegocio</th>
                    <th>ConsultarNegocio</th>
                    <th>VerNegocio</th>
                    <th>EliminarNegocio</th>
                    <th>ConfirmaNegocio</th>
                    
                    <th>AsignarProduccion</th>
                    <th>ConsultarProduccion</th>
                    <th>EditarProduccion</th>
                    <th>EliminarProduccion</th>
                    <th>CrearOrdenCompra</th>
                    <th>VerProduccion</th>
                    <th>LevantarProduccion</th>
                    <th>FinalizarProduccion</th>
                    <th>AprobarProduccion</th>
                    <th>ConfirmaProduccion</th>
                    
                    <th>CrearFactura</th>
                    <th>VerRentabilidad</th>
                    
                </tr>
            </thead>
            <tbody>';
    $i=1;
    while($rsperfiles=mysql_fetch_assoc($cltperfiles)){
        echo'<tr ';
            if ($i%2==0){
                echo 'class="odd gradeU"';
            }else{
                echo 'class="even gradeU"';
            }
        $activado=""; 
        echo'>
            <td><input type="hidden" id="perfil'.$i.'" name="perfil'.$i.'" value="'.$rsperfiles['Perfil'].'" />'.$rsperfiles['Perfil'].'</td>';
            
            $activado=Activar($rsperfiles['IngresoRental']);
            echo '<td><input type="checkbox" id="ingresorental'.$i.'" name="ingresorental'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsperfiles['CrearClientes']);
            echo '<td><input type="checkbox" id="crearclientes'.$i.'" name="crearclientes'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConsultarClientes']);
            echo '<td><input type="checkbox" id="consultarclientes'.$i.'" name="consultarclientes'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ActualizarClientes']);
            echo '<td><input type="checkbox" id="actualizarclientes'.$i.'" name="actualizarclientes'.$i.'" '.$activado.'/></td>';
            
            
            
            $activado=Activar($rsperfiles['CrearProveedor']);
            echo '<td><input type="checkbox" id="crearproveedor'.$i.'" name="crearproveedor'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConsultarProveedor']);
            echo '<td><input type="checkbox" id="consultarproveedor'.$i.'" name="consultarproveedor'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['VerProveedor']);
            echo '<td><input type="checkbox" id="verproveedor'.$i.'" name="verproveedor'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ActualizarProveedor']);
            echo '<td><input type="checkbox" id="actualizarproveedor'.$i.'" name="actualizarproveedor'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['EliminarProveedor']);
            echo '<td><input type="checkbox" id="eliminarproveedor'.$i.'" name="eliminarproveedor'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsperfiles['CrearProyecto']);
            echo '<td><input type="checkbox" id="crearproyecto'.$i.'" name="crearproyecto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConsultarProyecto']);
            echo '<td><input type="checkbox" id="consultarproyecto'.$i.'" name="consultarproyecto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ActualizarProyecto']);
            echo '<td><input type="checkbox" id="actualizarproyecto'.$i.'" name="actualizarproyecto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['VerProyecto']);
            echo '<td><input type="checkbox" id="verproyecto'.$i.'" name="verproyecto'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsperfiles['CrearPresupuesto']);
            echo '<td><input type="checkbox" id="crearpresupuesto'.$i.'" name="crearpresupuesto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConsultarPresupuesto']);
            echo '<td><input type="checkbox" id="consultarpresupuesto'.$i.'" name="consultarpresupuesto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['VerPresupuesto']);
            echo '<td><input type="checkbox" id="verpresupuesto'.$i.'" name="verpresupuesto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['AprobarPresupuesto']);
            echo '<td><input type="checkbox" id="aprobarpresupuesto'.$i.'" name="aprobarpresupuesto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['EliminarPresupuesto']);
            echo '<td><input type="checkbox" id="eliminarpresupuesto'.$i.'" name="eliminarpresupuesto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ActualizarPresupuesto']);
            echo '<td><input type="checkbox" id="actualizarpresupuesto'.$i.'" name="actualizarpresupuesto'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConfirmaPresupuesto']);
            echo '<td><input type="checkbox" id="confirmapresupuesto'.$i.'" name="confirmapresupuesto'.$i.'" '.$activado.'/></td>';
                        
            $activado=Activar($rsperfiles['CrearNegocio']);
            echo '<td><input type="checkbox" id="crearnegocio'.$i.'" name="crearnegocio'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConsultarNegocio']);
            echo '<td><input type="checkbox" id="consultarnegocio'.$i.'" name="consultarnegocio'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['VerNegocio']);
            echo '<td><input type="checkbox" id="vernegocio'.$i.'" name="vernegocio'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['EliminarNegocio']);
            echo '<td><input type="checkbox" id="eliminarnegocio'.$i.'" name="eliminarnegocio'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConfirmaNegocio']);
            echo '<td><input type="checkbox" id="confirmanegocio'.$i.'" name="confirmanegocio'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsperfiles['AsignarProduccion']);
            echo '<td><input type="checkbox" id="asignarproduccion'.$i.'" name="asignarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConsultarProduccion']);
            echo '<td><input type="checkbox" id="consultarproduccion'.$i.'" name="consultarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['EditarProduccion']);
            echo '<td><input type="checkbox" id="editarproduccion'.$i.'" name="editarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['EliminarProduccion']);
            echo '<td><input type="checkbox" id="eliminarproduccion'.$i.'" name="eliminarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['CrearOrdenCompra']);
            echo '<td><input type="checkbox" id="crearordencompra'.$i.'" name="crearordencompra'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['VerProduccion']);
            echo '<td><input type="checkbox" id="verproduccion'.$i.'" name="verproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['LevantarProduccion']);
            echo '<td><input type="checkbox" id="levantarproduccion'.$i.'" name="levantarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['FinalizarProduccion']);
            echo '<td><input type="checkbox" id="finalizarproduccion'.$i.'" name="finalizarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['AprobarProduccion']);
            echo '<td><input type="checkbox" id="aprobarproduccion'.$i.'" name="aprobarproduccion'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['ConfirmaProduccion']);
            echo '<td><input type="checkbox" id="confirmaproduccion'.$i.'" name="confirmaproduccion'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsperfiles['CrearFactura']);
            echo '<td><input type="checkbox" id="crearfactura'.$i.'" name="crearfactura'.$i.'" '.$activado.'/></td>';
            $activado=Activar($rsperfiles['VerRentabilidad']);
            echo '<td><input type="checkbox" id="verrentabilidad'.$i.'" name="verrentabilidad'.$i.'" '.$activado.'/></td>';
            
         echo '</tr>';
        $i+=1;
    }
    echo '</tbody></table>';  
    echo '</form>';
    
    function Activar($valor){
        $resultado="";
        if ($valor==1){
            $resultado='value="1" checked="checked"';
        }else{
            $resultado='value="0" ';
        }
        return $resultado;
    }
?>