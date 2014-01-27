<?php
     include('../Connections/cnn.php');
     $conecta=mysql_select_db($database_cnn,$cnn);
     echo '<form method="post" id="fusuario" name="fusuario" action="creausuario.php">
     <br />
     <h2>Registro de Nuevos Usuarios</h2>
     <hr />';
     echo '
     <table>
            <tr>
                <td>Usuario:</td>
                <td><input type="text" id="idusuario" name="idusuario" style="width:250px;" /></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" id="nusuario" name="nusuario" style="width:250px;" /></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" id="nmail" name="nmail" style="width:250px;" /></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" id="pass" name="pass" style="width:250px;" /></td>
            </tr>
            <tr>
                <td>Confirme Password:</td>
                <td><input type="password" id="cpass" name="cpass" style="width:250px;" /></td>
            </tr>
            <tr>
                <td>Grupo:</td>
                <td>
                    <select id="sgrupo" name="sgrupo" style="width:250px;">
                        <option value="0">---- Elija Grupo del Usuario----</option>';
                        
                    $sqlgrupos="SELECT perfiles.IdPerfil, perfiles.Perfil FROM perfiles";
                    $cltgrupos=mysql_query($sqlgrupos,$cnn) or die(mysql_error());
                    while($rsgrupos=mysql_fetch_assoc($cltgrupos)){
                        echo '<option value="'.$rsgrupos['IdPerfil'].'">'.$rsgrupos['Perfil'].'</option>';
                    }   
                    echo '</select>
                </td>
            </tr>
     </table>
     <br />
     <table>
        <tr>
            <td>Entretenimiento Corporativo</td>
            <td><input type="checkbox" id="corporativo" name="corporativo" /></td>
        </tr>
        <tr>
            <td>Entretenimiento Digital</td>
            <td><input type="checkbox" id="digital" name="digital" /></td>
        </tr>
        <tr>
            <td>Agora</td>
            <td><input type="checkbox" id="agora" name="agora" /></td>
        </tr>
        <tr>
            <td>Saxo</td>
            <td><input type="checkbox" id="saxo" name="saxo" /></td>
        </tr>
        <tr>
            <td>En Vivo</td>
            <td><input type="checkbox" id="envivo" name="envivo" /></td>
        </tr>
     </table>';
     echo '<hr /><div align="left"><input type="button" value="Registrar Nuevo Usuario" onclick="validarform(\'fusuario\',\'usuario\')" style="width:300px;"/></div>';
     echo '</form>'; 
?>