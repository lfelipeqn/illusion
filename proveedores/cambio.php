<?   
    if(isset($_SESSION['usuario'])){
        $proveedor=$_SESSION['usuario'];
?>
<div id="contenedor-menu">
    <form action="inicio.php" method="post" id="inicial" name="inicial">
	<div align="center" style="padding-top: 15px;">
	<table>
		<tr>
		  <td rowspan="4" width="35%"><img id="iminicio" name="iminicio" src="images/esl.jpg" /></td>
		  <td colspan="2"><div align="center"><h2>Portal de Proveedores ESL</h2></div></td>
		</tr>		
		<tr>
            <td><label><b>Clave Actual:</b></label></td>
			<td>
                <input type="password" id="actual" name="actual" style="text-align: right;"/>
                <input type="hidden" id="proveedor" name="proveedor" value="<? echo $proveedor;?>" />
            </td>
		</tr>
		<tr>
            <td><label><b>Nueva Clave:</b></label></td>
            <td><input type="password" id="password" name="password" style="text-align: right;"/></td>
		</tr>
        <tr>
            <td><label><b>Confirme Nueva:</b></label></td>
            <td><input type="password" id="conf-password" name="conf-password" style="text-align: right;"/></td>
		</tr>
		<tr>
            <td colspan="3"><div align="center"><input type="button" id="enviar" name="enviar" style="font-weight:bold;width:100%; background-color:white;" value="Actualizar Clave" /></div></td>
        </tr>					
	</table>
	</div>
</div>
<?
}
?>
<script>
    $('#actual').blur(function(){
        var pass = $('#password').val()
        var conf = $('#conf-password').val()
        var actual = $('#actual').val()
        var prov = $('#proveedor').val()
        var tipo ="actual"
        $.ajax({
                type:"post",
                url:"cambioclave.php",
                data:{"tipo":tipo, "conf":conf, "proveedor":prov, "actual": actual},
                success:function(response){
                    if(response=='1'){
                        $('#enviar').removeAttr('disabled');
                    }else{
                        $('#enviar').attr('disabled','disabled')
                        alert('La Clave Actual no es valida');
                    }
                }
        })
    })


    $('#conf-password').blur(function(){
        var pass = $('#password').val()
        var conf = $(this).val()
        var actual = $('#actual').val()
        var prov = $('#proveedor').val()
        if(pass!=conf){
            alert('La Clave Nueva y la Confirmación no Coinciden, por favor verifique')
            $('#enviar').attr('disabled','disabled')
        }else{
            $('#enviar').removeAttr('disabled');
        }
        
    })
    
    $('#enviar').click(function(){
        var pass = $('#password').val()
        var conf = $('#conf-password').val()
        var actual = $('#actual').val()
        var prov = $('#proveedor').val()
        var tipo ="cambio"
        $.ajax({
                type:"post",
                url:"cambioclave.php",
                data:{"tipo":tipo, "conf":conf, "proveedor":prov, "actual": actual},
                success:function(response){
                    alert(response)
                    window.location='inicio.php?location=actualiza';
                }
        })
    })
    
</script>