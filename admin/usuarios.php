<?php
    include '../Connections/cnn.php';
    $connect = mysql_select_db($database_cnn,$cnn);
    $sqlusuarios="SELECT usuarios.Usuario, usuarios.Nombre, usuarios.Correo, perfiles.Perfil FROM usuarios INNER JOIN perfiles ON usuarios.IdPerfil = perfiles.IdPerfil";
    $cltusuarios=mysql_query($sqlusuarios,$cnn) or die(mysql_error());
    echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="usuarios">
            <thead>
                <tr>
                    <th colspan="3">Opciones</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Perfil</th>
                </tr>
            </thead>
            <tbody>';
    $i=1;
    while($rsusuarios=mysql_fetch_assoc($cltusuarios)){
            echo'<tr>';
            echo'
                <td><img src="images/mas.png" onclick="ValidaAccion(\'admin.php?location=nwusr\')"/></td>
                <td><img src="images/elimina.gif" onclick="ValidaAccion(\'admin.php?location=delusr&usuario='.$rsusuarios['Usuario'].'\')" /></td>
                <td><img src="images/editar.png" onclick="ValidaAccion(\'admin.php?location=updusr&usuario='.$rsusuarios['Usuario'].'\')" /></td>
                <td>'.$rsusuarios['Usuario'].'</td>
                <td>'.$rsusuarios['Nombre'].'</td>
                <td>'.$rsusuarios['Correo'].'</td>
                <td>'.$rsusuarios['Perfil'].'</td>
            </tr>';
            $i++;
    }
    echo '<tbody></table>';
?>