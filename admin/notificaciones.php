<?php
    include '../Connections/cnn.php';
    $connect = mysql_select_db($database_cnn,$cnn);
    $sqlusuarios="SELECT usuarios.Usuario, usuarios.ConfirmaPresupuesto, usuarios.ConfirmaNegocio, usuarios.ConfirmaProduccion, usuarios.ApruebaProduccion, usuarios.AlertaValidacion FROM usuarios"; 
    $cltusuarios=mysql_query($sqlusuarios,$cnn) or die(mysql_error());
    
    echo'<form action="updalertas.php" method="post" id="asnotif" name="asnotif">';
    echo '<br /><div align="left"><input type="submit" style="background-color:white; font-weight:bold; font-size:12px; width:250px" value="Aplicar Cambios en Notificaciones" style="width:210px"></div><br />';
    echo '<input type="hidden" name ="filas" id="filas" value="'.mysql_num_rows($cltusuarios).'" />';
    echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="notificaciones">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>ConfirmaPresupuesto</th>
                    <th>ConfirmaNegocio</th>
                    <th>ConfirmaProduccion</th>
                    <th>ApruebaProduccion</th>
                    <th>AlertaValidacion</th>
                </tr>
            </thead>
            <tbody>';
    $i=1;
    while($rsusuarios=mysql_fetch_assoc($cltusuarios)){
        echo'<tr ';
            if ($i%2==0){
                echo 'class="odd gradeU"';
            }else{
                echo 'class="even gradeU"';
            }
        $activado=""; 
        echo'>
            <td><input type="hidden" id="usuario'.$i.'" name="usuario'.$i.'" value="'.$rsusuarios['Usuario'].'" />'.$rsusuarios['Usuario'].'</td>';
            
            $activado=Activar($rsusuarios['ConfirmaPresupuesto']);
            echo '<td><input type="checkbox" id="confirmapresupuesto'.$i.'" name="confirmapresupuesto'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsusuarios['ConfirmaNegocio']);
            echo '<td><input type="checkbox" id="confirmanegocio'.$i.'" name="confirmanegocio'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsusuarios['ConfirmaProduccion']);
            echo '<td><input type="checkbox" id="confirmaproduccion'.$i.'" name="confirmaproduccion'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsusuarios['ApruebaProduccion']);
            echo '<td><input type="checkbox" id="apruebaproduccion'.$i.'" name="apruebaproduccion'.$i.'" '.$activado.'/></td>';
            
            $activado=Activar($rsusuarios['AlertaValidacion']);
            echo '<td><input type="checkbox" id="alertavalidacion'.$i.'" name="alertavalidacion'.$i.'" '.$activado.'/></td>';
            
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