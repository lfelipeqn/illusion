<?php
include('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
$connect=mysql_select_db($rental_cnn,$cnn);

?>
<div class="cuerpo">
	<h2><span>Registro de </span>Proyectos</h2>
    <br />
    <form action="proyectos/insertaproyecto.php" method="post" class="formulario" id="proyecto" name="proyecto">
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
                            echo '<option value="'.$rscliente['Identificacion'].'">'.$rscliente['NombreCliente'].'</option>';
                        }
                ?>
				    </select>
                </td>
            </tr>
            <tr>
                <td><label id="lproy">Nombre del Proyecto </label></td>
                <td><input type="text" id="nproy" name="nproy"/></td>
                <td><label id="lcont">Nombre del Contacto</label></td>
                <td><input type="text" id="ncontac" name="ncontac" class="validate[required] text-input"/></td>
            </tr>
            <tr>
                <td><label id="ltelcon">Telefono del Contacto</label></td>
                <td><input type="text" id="ntelcontac" name="ntelcontac" class="validate[required] text-input"/></td>
                <td><label id="lmail">Email del Contacto</label></td>
                <td><input type="email" id="nmail" name="nmail" class="validate[required,custom[email]]" /></td>
            </tr>
            <tr>
                <td><label id="lcity">Ciudades</label></td>
                <td><input type="text" id="ncity" name="ncity" class="validate[required] text-input"/></td>
                <td><label id="llugar">Lugar del Evento</label></td>
                <td><input type="text" id="nlugar" name="nlugar" class="validate[required] text-input"/></td>
            </tr>
            <tr>
                <td><label id="lfe">Fecha del Evento</label></td>
                <td><input type="text" id="nfechae" name="nfechae" class="tcal validate[required] text-input datepicker" /></td>
                <td><label id="lfm">Fecha de Montaje</label></td>
                <td><input type="text" id="nfecham" name="nfecham" class="tcal validate[required] text-input" /></td>
            </tr>
            <tr>
                <td><label id="lfd">Fecha de Desmontaje</label></td>
                <td><input type="text" id="nfechad" name="nfechad" class="tcal validate[required] text-input" /></td>
                <td><label>Observaciones</label></td>
                <td>
                    <input type="text" id="nobs" name="nobs" />
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <div align="center">
                        <input type="submit" style="background-color:white; font-weight:bold;width:265px;" id="enviar" name="enviar" value="Crear Nuevo Proyecto" />
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