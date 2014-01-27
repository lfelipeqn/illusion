<?php
if(isset($_SESSION['usuario'])){
include ('Connections/cnn.php');
echo "
<script type=\"text/javascript\">
function BusProy(control){
var nombre
	if (control=='bbusc'){
		nombre =document.getElementById('nombrep').value
		var direccion='inicio.php?location=listproy&tipo=1&valor='+nombre
		window.location=direccion
	}
	if (control=='btodo'){
		nombre=0
		var direccion='inicio.php?location=listproy&tipo=2&valor='+nombre
		window.location=direccion
	}
}
</script>
";
echo'
<div class="cuerpo">
			<h3>Consulta de <span>Proyectos</span></h3>
			<p>Por Favor Elija la Opci&oacute;n Deseada para Consultar los Proyectos Cargados</p>
			<form action="" method="post">
				<table>
    				<tr>
					<td><b><label>El Nombre de Proyecto Contiene: </label></b></td>
					<td colspan="2"><input type="text" id="nombrep" name="nombrep" size="40"></td>
        			</tr>
        			<tr>
					<td></td>
        				<td><input type="button" id="bbusc" name="bbusc" value="Buscar Proyectos" onclick="BusProy(this.id)" /></td>
            				<td><input type="button" id="btodo" name="bbtodo" value="Ver Todos los Proyectos" onclick="BusProy(this.id)" /></td>
        			</tr>
    			</table>
			</form>	
	</div>';
}
?>