<?
    error_reporting(0);   
    session_destroy();    
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" >
		<title>Portal de Proveedores</title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.js" ></script>
		<script type="text/javascript" src="scripts/jquery.validate.js" ></script>
        <link href="styles/estilo.css" rel="stylesheet" type="text/css" />	
	</head>
	<body>
    <div id="fondo">
    <div id="contenedor-menu">
	<form action="inicio.php" method="post" id="inicial" name="inicial">
	<div align="center">
	<table>
		<tr>
		  <td rowspan="3" width="35%"><img id="iminicio" name="iminicio" src="images/esl.jpg" /></td>
		  <td colspan="2"><div align="center"><h2>Portal de Proveedores ESL</h2></div></td>
		</tr>		
		<tr>
            <td><label><b>Usuario:</b></label></td>
			<td><input type="text" id="usuario" name="usuario" size="35" maxlength="20" style="text-align: right;"/></td>
		</tr>
		<tr>
            <td><label><b>Password:</b></label></td>
            <td><input type="password" id="password" name="password" size="35" maxlength="20" style="text-align: right;"/></td>
		</tr>
		<tr>
            <td colspan="3"><div align="center"><input type="submit" id="enviar" name="enviar" style="font-weight:bold;width:100%; background-color:white;" value="Ingreso al Sistema" /></div></td>
        </tr>					
	</table>
    <br />
    <div id="registro"><b>Si aun no tiene usuario</b> <a href="inicio.php?location=registro">Registrese Aqui</a></div>
	</div>
    </div>
	</form>
    </div>
	<script>	
	$(document).ready(function() {
	   $('#contenedor-menu').hide();
        $('#inicial').validate({
            onfocusout: false,
	        onkeyup: false,
	        onclick: false,	                
	        rules: {
	           usuario: {required:true, number:true},
	           password: {required:true}
            },
	        messages: {
	           usuario: {required: " Digite su Usuario", number: " El usuario es un numero"},
	           password: {required: " Digite su Contrase&ntilde;a"}
            },
            debug: true,
            submitHandler: function(form){
    	       var user = $('#usuario').val()
               var pass = $('#password').val()
               $.ajax({   
        	       type:"post",
                   url: "ingreso.php",
                   data: {
                    'usuario': user,
                    'password': pass
                    },
                   success: function(response){
                        if(response!='error'){
                            window.location = response
                        }else{
                            alert('Los datos ingresados no son Válidos, por favor intente nuevamente')    
                        }     
                   }
               });
            }
        });
        $('#contenedor-menu').fadeIn('slow');
    });					
    </script>
	</body>
</html>