<?php
     include('../Connections/cnn.php');
     $conecta=mysql_select_db($database_cnn,$cnn);
     
     $usuario=$_GET['usuario'];
     
     $sqlusuarios="SELECT usuarios.Usuario, usuarios.Nombre, usuarios.Correo, usuarios.Password, perfiles.IdPerfil, perfiles.Perfil FROM usuarios INNER JOIN perfiles ON usuarios.IdPerfil = perfiles.IdPerfil WHERE usuarios.Usuario='".$usuario."'";
     $cltusuario=mysql_query($sqlusuarios,$cnn);
     $rsusuario=mysql_fetch_assoc($cltusuario);
     
     echo '<form action="edusuario.php" method="post" id="formgrupo" name="formgrupo">
        <table>
            <tr>
                <td style="font-weight:bold;">Usuario: </td>
                <td><input id="user" name="user" style="background-color:silver;" type="text" READONLY value="'.$usuario.'" /></td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Nombre: </td>
                <td><input id="nombre" name="nombre" type="text" value="'.$rsusuario['Nombre'].'" /></td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Correo: </td>
                <td><input id="correo" name="correo" type="text" value="'.$rsusuario['Correo'].'" /></td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Contrase&ntilde;a: </td>
                <td><input id="pass" name="pass" type="password" /></td>
            </tr>    
                <td style="font-weight:bold;">Grupo: </td>
                <td>
                    <select id="grupo" name="grupo">';
                        $sqlgrupos="SELECT perfiles.IdPerfil, perfiles.Perfil FROM perfiles";
                        $cltgrupos=mysql_query($sqlgrupos,$cnn) or die(mysql_error());
                        while($rsgrupos=mysql_fetch_assoc($cltgrupos)){
                            if($rsusuario['IdPerfil']==$rsgrupos['IdPerfil']){
                                echo '<option value="'.$rsgrupos['IdPerfil'].'" selected="selected">'.$rsgrupos['Perfil'].'</option>';
                            }else{
                                echo '<option value="'.$rsgrupos['IdPerfil'].'">'.$rsgrupos['Perfil'].'</option>';
                            }
                        }
                    echo '</select>
                </td>
            </tr>';
            
            $sqlunidades="SELECT unidades.IdUnidad, unidades.Unidad FROM unidades";
            $cltunidades=mysql_query($sqlunidades,$cnn) or die(mysql_error());
            while($rsunidades=mysql_fetch_assoc($cltunidades)){
                $sqlactiva="SELECT usuarios_unidades.usuario, usuarios_unidades.IdUnidad FROM usuarios_unidades WHERE usuarios_unidades.usuario = '$usuario' AND usuarios_unidades.IdUnidad =".$rsunidades['IdUnidad'];
                $cltactiva=mysql_query($sqlactiva,$cnn) or die(mysql_error());
                $total=mysql_num_rows($cltactiva);
                echo '<tr><td style="font-weight:bold;">'.$rsunidades['Unidad'].':</td>';
                if($total>=1){
                    echo '<td><input type="checkbox" id="unidad_'.$rsunidades['IdUnidad'].'" name="unidad_'.$rsunidades['IdUnidad'].'" checked="checked"/></td></tr>';
                }else{
                    echo '<td><input type="checkbox" id="unidad_'.$rsunidades['IdUnidad'].'" name="unidad_'.$rsunidades['IdUnidad'].'" /></td></tr>';
                }
            }
            
     echo '<tr>
                <td colspan="2"><input type="submit" value="Actualizar Usuario" style="width:240px"/></td>
            </tr>
        </table>
    </form>'; 
?>