<?php
	session_destroy();
	include('../Connections/cnn.php');
	$conect=mysql_select_db($database_cnn,$cnn);
?>    
<div class="cuerpo">
<div id="presentacion">
    <form action="creaproveedor.php" method="post" id="formingreso">
        <fieldset>
            <div id="contenedor-form">
            <h2>Registro de <span> Proveedores</span></h2>
            <table>
                <tr>
                    <td colspan="6"></td>
                </tr>
                <tr>
                    <td><label> Persona </label></td>
                    <td>
                    <?
                        $sqlpersona="SELECT tipopersona.IdPersona, tipopersona.Persona FROM tipopersona";
                        $cltpersonas=mysql_query($sqlpersona,$cnn) or die(mysql_error());
                        $x=0;
                        while ($rspersona=mysql_fetch_assoc($cltpersonas)){
                            $x++;
                            echo'<label><input type="radio" id="ntpersona'.$x.'" name="ntpersona" value="'.$rspersona['IdPersona'].'"/>'.$rspersona['Persona'].'</label>';
                        }
                    ?>
                    </td>
                </tr>
                <tr>
                    <td><label> Nombre o Raz&oacute;n Social </label></td>
                    <td>
                        <input id="nproveedor" name="nproveedor" type="text" size="37" />
                    </td>
                    <td><label> Nombre Comercial </label></td>
                    <td><input type="text" id="ncomercial" name="ncomercial" size="37" /></td>
                </tr>
                <tr>
                    <td><label> Tipo Identificacion </label></td>
                    <td>
                        <select id="tipoi" name="tipoi">
                            <option value="0">--- Tipo de Identificaci&oacute;n---</option>
                            <?
                                $sqliden="SELECT tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion FROM tipoidentificacion";
                                $cltiden=mysql_query($sqliden,$cnn) or die(mysql_error());
                                while($rsiden=mysql_fetch_assoc($cltiden)){
                                    echo '<option value="'.$rsiden['IdTipo'].'">'.$rsiden['TipoIdentificacion'].'</option>';
                                }
                            ?>
                        </select>
                    </td>
                    <td><label> Identificacion </label></td>
                    <td>
                        <label><input id="nnit" name="nnit" type="text" size="24" />
                            DV <input id="ndv" name="ndv" type="text" size="3" /></label>
                    </td>
                </tr>
                <tr>
                    <td><label>Ciudad</label></td>
                    <td><input id="nciudad" name="nciudad" type="text" size="37" /></td>
                    <td><label>Pa&iacute;s</label></td>
                    <td><input type="text" id="npais" name="npais" size="37" /></td>
                </tr>
                <tr>
                    <td><label>Direcci&oacute;n</label></td>
                    <td><input id="ndir" name="ndir" type="text" size="37" /></td>
                    <td><label>Fax</label></td>
                    <td><input type="text" id="npfax" name="npfax" size="37" /></td>
                </tr>
                <tr>
                    <td><label>Tel&eacute;fono</label></td>
                    <td><input id="ntel" name="ntel" type="text" size="37" /></td>
                    <td><label>E-Mail</label></td>
                    <td><input type="text" id="ncorreo" name="ncorreo" size="37" /></td>
                </tr>
                <tr>
                    <td><label>Representante Legal</label></td>
                    <td><input id="nrepl" name="nrepl" type="text" size="37" /></td>
                    <td><label>c.c.</label></td>
                    <td><input type="text" id="ncc" name="ncc" size="37" /></td>
                </tr>
                <tr>
                    <td><label><b>Contraseña</b></label></td>
                    <td><input id="pass" name="pass" type="password" size="37" /></td>
                    <td><label><b>Repita Contraseña</b></label></td>
                    <td><input type="password" id="pass1" name="pass1" size="37" /></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div style="padding-top: 10px;">
                            <input style="float:right; font-weight: bold;width: 225px;height: 30px;" type="submit" value="Registrarse como Proveedor"/>
                        </div>    
                    </td>
                </tr>
            </table>
            </div>
			</fieldset>
	    </form>
     </div>
</div>