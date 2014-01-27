<?php
	
if(isset($_SESSION['usuario'])){
	include('Connections/cnn.php');
	$connect=mysql_select_db($database_cnn,$cnn);
	
?>
<div class="cuerpo">
	<h3>Recepci&oacute;n de <span>Ordenes de Compra</span></h3>
	<form action="#" method="post" id="contacts-form">
		<fieldset>
			<table>
				<tr>
					<td><label style="font-size:13px"><b>Orden de Compra:</b></label></td>
					<td colspan="3">
						<div align="right">
						<input type="text" id="nord" name="nord" style="font-weight:bold;width:120px;text-align:right;font-size:13px; color:0000FF;" />
						</div>
					</td>
				</tr>
                <tr>
					<td><label>Nombre del Cliente</label></td>
					<td colspan="3"><input type="text" id="ncliente" name="ncliente" readonly="readonly" style="width:355px; text-align: right;" /></td>
                </tr>
                <tr>
					<td><label>Nombre del Proyecto</label></td>
					<td colspan="3"><input type="text" id="nproy" name="nproy" readonly="readonly" style="width:355px; text-align: right;" /></td>
				</tr>
                <tr>
					<td><label>Valor Orden de Compra</label></td>
					<td colspan="3"><input type="text" id="valorden" name="valorden" readonly="readonly" style="width:355px; text-align: right;" /></td>
				</tr>
                <tr>
                    <td colspan="4"><br /><hr /> <br /></td>
                </tr>
                <tr>
					<td><label style="font-size:13px"><b>No. de Factura:</b></label></td>
					<td colspan="3">
						<div align="right">
						<input type="text" id="nfact" name="nfact" style="font-weight:bold;width:120px;text-align:right;font-size:13px; color:FF0000;" />
						</div>
					</td>
				</tr>
				<tr>
					<td><label>Fecha de Emisi&oacute;n</label></td>
					<td><input type="text" id="femi" name="femi" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
					<td><label>Fecha de Vencimiento</label></td>
					<td><input type="text" id="fven" name="fven" READONLY title="MM/DD/YYYY" onClick="displayCalendar(this);"/></td>
				</tr>
				<tr>
					<td colspan="3"><div align="left"><b><label>SUBTOTAL: </label></b></div></td>
					<td><input type="text" id="subt" name="subt" style="text-align:right; font-weight:bold" /></td>
				</tr>
				<tr>
					<td colspan="3"><div align="left"><b><label>IVA: </label></b></div></td>
					<td><input type="text" id="iva" name="iva" style="text-align:right; font-weight:bold" readonly="readonly" /></td>
				</tr>
				<tr>
					<td colspan="3"><div align="left"><b><label>TOTAL: </label></b></div></td>
					<td><input type="text" id="tot" name="tot" style="text-align:right; font-weight:bold" readonly="readonly"/></td>
				</tr>
			</table>
			<input type="button" id="enviar" style="font-weight:bold;width:495px" value="Radicar Factura del Proveedor" onclick="validarform('contacts-form','factura')"/>
		</fieldset>
	<form>
</div>

<script>
	
    $('#enviar').attr("disabled",true)
    
    $('#nord').blur(function(){
        var orden=$(this).val();
        
        $('#ncliente').val("")
        $('#nproy').val("")
        $('#valorden').val('$ '+FormatoNum(0))
        
        $.ajax({
            type:"post",
            url:"recepcion/ajaxoc.php",
            data:{"orden":orden},
            success: function(response){
                var json = $.parseJSON(response);			
				$.each(json,function(){
                    if(this.IdEstadoOrden==4){
                        alert('Esta Orden de Compra SE ENCUENTRA ANULADA y por tanto no es posible relizar el registro')
                        alert('Esta Orden de Compra SE ENCUENTRA ANULADA y por tanto no es posible relizar el registro')
                        $('#enviar').attr("disabled",true)
                        $('#nord').val("")
                    }else if(this.IdEstadoOrden==2 || this.IdEstadoOrden==3){
                        alert('Esta Orden de Compra YA SE ENCUENTRA radicada')
                        alert('Esta Orden de Compra YA SE ENCUENTRA radicada')
                        $('#nord').val("")
                        $('#enviar').attr("disabled",true)   
                    }else{
                        $('#ncliente').val(this.NombreCliente)
                        $('#nproy').val(this.NombreProyecto)
                        $('#valorden').val('$ '+FormatoNum(this.VrCompra))
                        $('#enviar').attr("disabled",false)
                    }
				})
            }
        })
    }) 
	
    $('#subt').focus(function(){
        $(this).val("")
        $('#iva').val("")
        $('#tot').val("")
    })
    
    $('#subt').blur(function(){
        var subt = '$ '+FormatoNum($(this).val())
        $(this).val(subt)
        $('#iva').val('$ '+FormatoNum(NumNormal($(this).val())*0.16))
        $('#tot').val('$ '+FormatoNum(NumNormal($(this).val())*1.16))
    })
    
    
</script>

<?
}
?>