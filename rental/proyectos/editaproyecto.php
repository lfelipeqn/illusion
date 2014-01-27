<?php
include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
$connect=mysql_select_db($rental_cnn,$cnn);

$proyecto=$_GET['seguimiento'];

$sql="SELECT proyectos.IdProyecto, proyectos.IdCliente, proyectos.NombreProyecto, proyectos.Ciudades, 
proyectos.TelefonoContacto, proyectos.NombreContacto, proyectos.EmailContacto, proyectos.FechaEvento, 
proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones 
FROM proyectos WHERE IdProyecto=".$proyecto;

$clproy=mysql_query($sql,$cnn) or die(mysql_error());
$rsproy=mysql_fetch_assoc($clproy);

?>
<div class="cuerpo">
	<h2><span>Actualización de </span>Proyectos</h2>
    <br />
    <form action="proyectos/actualizaproyecto.php" method="post" class="formulario" id="proyecto" name="proyecto">
    <fieldset>
        <div align="right"><img src="images/warning.png" title="Ocultar Advertencias"/></div>
        <table>
            <tr>
                <td><label id="lcliente"> Elija el Cliente: </label></td>
                <td colspan="3">
                <?
                    $sql = "SELECT clientes.Identificacion, clientes.NombreCliente, clientes.Digito, clientes.Telefono, clientes.Extension, clientes.Email, clientes.Direccion, clientes.Fax, clientes.ExtensionFax FROM clientes";
                ?>
						
				    <select id="scliente" name="scliente" style="width: 430px;" class="validate[required] text-input">
                        <option value="">---- Elija el Cliente a Consultar ----</option>
                <?
                        $clcliente=mysql_query($sql);
                        while($rscliente=mysql_fetch_assoc($clcliente)){
                            if($rscliente['Identificacion']==$rsproy['IdCliente']){
                                echo '<option value="'.$rscliente['Identificacion'].'" selected="selected">'.$rscliente['NombreCliente'].'</option>';
                            }else{
                                echo '<option value="'.$rscliente['Identificacion'].'">'.$rscliente['NombreCliente'].'</option>';   
                            }
                        }
                ?>
				    </select>
                </td>
            </tr>
            <tr>
                <td><label id="lproy">Nombre del Proyecto </label></td>
                <td>
                    <input type="hidden" id="idproy" name="idproy" value="<? echo $rsproy['IdProyecto']; ?>" />
                    <input type="text" id="nproy" name="nproy" value="<? echo $rsproy['NombreProyecto']; ?>" />
                </td>
                <td><label id="lcont">Nombre del Contacto</label></td>
                <td><input type="text" id="ncontac" name="ncontac" class="validate[required] text-input" value="<? echo $rsproy['NombreContacto']; ?>"/></td>
            </tr>
            <tr>
                <td><label id="ltelcon">Telefono del Contacto</label></td>
                <td><input type="text" id="ntelcontac" name="ntelcontac" class="validate[required] text-input" value="<? echo $rsproy['TelefonoContacto']; ?>"/></td>
                <td><label id="lmail">Email del Contacto</label></td>
                <td><input type="email" id="nmail" name="nmail" class="validate[required,custom[email]]" value="<? echo $rsproy['EmailContacto']; ?>" /></td>
            </tr>
            <tr>
                <td><label id="lcity">Ciudades</label></td>
                <td><input type="text" id="ncity" name="ncity" class="validate[required] text-input" value="<? echo $rsproy['Ciudades']; ?>"/></td>
                <td><label id="llugar">Lugar del Evento</label></td>
                <td><input type="text" id="nlugar" name="nlugar" class="validate[required] text-input" value="<? echo $rsproy['LugarEvento']; ?>"/></td>
            </tr>
            <tr>
                <td><label id="lfe">Fecha del Evento</label></td>
                <td><input type="text" id="nfechae" name="nfechae" class="tcal validate[required] text-input datepicker" value="<? echo $rsproy['FechaEvento']; ?>" /></td>
                <td><label id="lfm">Fecha de Montaje</label></td>
                <td><input type="text" id="nfecham" name="nfecham" class="tcal validate[required] text-input" value="<? echo $rsproy['FechaMontaje']; ?>" /></td>
            </tr>
            <tr>
                <td><label id="lfd">Fecha de Desmontaje</label></td>
                <td><input type="text" id="nfechad" name="nfechad" class="tcal validate[required] text-input" value="<? echo $rsproy['FechaDesmontaje']; ?>" /></td>
                <td><label>Observaciones</label></td>
                <td>
                    <input type="text" id="nobs" name="nobs" value="<? echo $rsproy['Observaciones']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div align="center">
                        <input type="submit" style="background-color:white; font-weight:bold;width:265px;" id="enviar" name="enviar" value="Actualizar Proyecto" />
                    </div>
                </td>
            </tr>
        </table>
      </fieldset>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("img:first").hide();
        $("#proyecto").validationEngine();
    })
    $("img:first").click(function(){
        $("#proyecto").validationEngine('hideAll');
        $(this).hide("slow")
    })	
    
    $("input:submit").click(function(){
        $("img:first").fadeIn("slow")
    })
    
</script>

<?
}
?>