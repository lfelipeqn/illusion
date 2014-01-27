<?php
    include '../Connections/cnn.php';
    $connect = mysql_select_db($database_cnn,$cnn);
    $sqlgrupos="SELECT perfiles.IdPerfil, perfiles.Perfil FROM perfiles"; 
    $cltgrupos=mysql_query($sqlgrupos,$cnn) or die(mysql_error());
    
    echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="grupos">
            <thead>
                <tr>
                    <th colspan="2">Opciones</th>
                    <th>Grupo</th>
                </tr>
            </thead>
            <tbody>';
    $i=1;
    while($rsgrupos=mysql_fetch_assoc($cltgrupos)){
        echo'<tr ';
            if ($i%2==0){
                echo 'class="odd gradeU"';
            }else{
                echo 'class="even gradeU"';
            } 
        echo'>
            <td><a href="admin.php?location=ngrupo"><image src="images/mas.png" alt="Nuevo Grupo"></a></td>
            <td>';
            if ($rsgrupos['IdPerfil']!=1){
                echo '<a href="admin.php?location=egrupo&grupo='.$rsgrupos['IdPerfil'].'"><image src="images/editar.png" alt="Cambiar Nombre de Grupo"></a></td>';    
            }
            echo '</td>
            <td>'.$rsgrupos['Perfil'].'</td>';
         echo '</tr>';
        $i+=1;
    }
    echo '</tbody></table>';
?>