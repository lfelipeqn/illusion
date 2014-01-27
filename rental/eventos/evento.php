<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
?>
<div class="cuerpo">
    <h2><span>Registro de </span>Eventos</h2>
    <div align="left">
    <form action="eventos/regevento.php" id="fevento" name="fevento" method="post" class="formulario">
        <table>
			<tr>
				<td><label>Cliente</label></td>
				<td colspan="3">
                    <select id="scliente" name="scliente" style="width:380px">
                        <option value="0">------- Elija un Cliente -------</option>
                        <?
				        $connect=mysql_select_db($rental_cnn,$cnn);
				        $sqlclientes="SELECT clientes.Identificacion, clientes.NombreCliente FROM clientes ORDER BY clientes.NombreCliente";
				        $cltcliente=mysql_query($sqlclientes,$cnn) or die(mysql_error());
				        while($rsclientes=mysql_fetch_assoc($cltcliente)){
					       echo '<option value="'.$rsclientes['Identificacion'].'">'.$rsclientes['NombreCliente'].'</option>';
				        }
                        ?>
				    </select>
                </td>
			</tr>
            <tr>
                <td><label>Proyecto Asociado: </label></td>
                <td>
                    <select id="sproy" name="sproy">
                        <option value="">--- Elija un Proyecto ---</option>
                    </select>
                </td>
                <td><label><b>Horas x D&iacute;a</b></label></td>
				<td><input type="text" id="nhoras" name="nhoras"/></td>
            </tr>
			<tr>
				<td colspan="4">
				<div align="center"><input type="button" style="background-color:white; font-weight:bold;width:480px;" id="bbreg" name="bbreg" value="Registrar Nuevo Evento" onclick="validarform('fevento','evento')"/></div></td>
			</tr>
		</table>
    </form>
    </div>
</div>
<script>
    $('#scliente').change(function(){
        $('#sproy option').remove();
        $('#sproy').append('<option value="">--- Elija un Proyecto ---</option>');
        var idcliente = $(this).val();    
        $.ajax({
        method: "get",
        data:{"cliente": idcliente},
        url:"eventos/proydisponibles.php",
        success: function(response){
            var json = $.parseJSON(response);
            var i=0;
            $.each(json,function(){
                $('#sproy').append('<option value="'+this.IdProyecto+'">'+this.NombreProyecto+'</option>')
            })
        }
       });
    })
</script>
<?
}
?>