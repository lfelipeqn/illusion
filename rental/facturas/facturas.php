<?php
    if(isset($_SESSION['usuario'])){
	   include ('../Connections/cnn.php');
	   $conexion=mysql_select_db($rental_cnn,$cnn);
       echo '<div class="cuerpo">
       <h2><span>Registro de </span> Facturas</h2>
       <p>Por Favor Complete la Informaci&oacute;n requerida para proceder con la generación de la Factura.</p>';
       echo '<form action="facturas/regfactura.php" method="post" id="formfactura" name="formfactura" >';
       echo'    <table>
                    <tr>
                        <td class="estilocontenido">
                            N&uacute;mero de Factura:
                        </td>
                        <td class="estilocontenido">
                            <select id="nevento" name="nevento" style="width:300px;">
                                <option value="0">---- Elija un Proyecto ----</option>';
                            
                            $sqlevento="SELECT proyectos.IdProyecto, proyectos.NombreProyecto FROM proyectos INNER JOIN eventos ON proyectos.IdProyecto = eventos.IdProyecto WHERE eventos.Finalizado = 1 ORDER BY proyectos.IdProyecto ASC";
                            $cltevento=mysql_query($sqlevento,$cnn) or die(mysql_error());
                            while($rsevento=mysql_fetch_assoc($cltevento)){
                                echo '<option value="'.$rsevento['IdProyecto'].'">'.$rsevento['IdProyecto'].' - '.$rsevento['NombreProyecto'].'</option>';
                            }
                            echo '</select>
                        </td>
                    </tr>
                    <tr>
                        <td class="estilocontenido">Fecha de Vencimiento:</td>
                        <td class="estilocontenido"><input type="text" style="width:300px;" id="fvencimiento" name="fvencimiento"/></td>
                    </tr>
                    <tr>
                        <td class="estilocontenido">Observaciones:</td>
                        <td class="estilocontenido">
                            <textarea id="observaciones" name="observaciones" style="width:300px;"></textarea>
                        </td>
                    </tr>
                </table>';
       echo '<hr /><div align="left"><input type="button" class="boton" value="Registrar Factura" id="btfactura" name="btfactura" onclick="validarform(\'formfactura\',\'factura\')" /></div>';
       echo '</form></div>';
       echo '<script>
        $("#fvencimiento").datepicker({dateFormat: \'yy-mm-dd\'});
       </script>';
    }
?>