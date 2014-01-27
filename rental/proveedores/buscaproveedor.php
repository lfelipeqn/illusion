<?php
//session_start();
include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
echo "
<script type=\"text/javascript\">
function Buscar(control){
var nombre
	if (control=='bbusc'){
		nombre =document.getElementById('nombrep').value
		var direccion='rental.php?location=listprov&tipo=1&valor='+nombre
		window.location=direccion
	}
	if (control=='btodo'){
		nombre=0
		var direccion='rental.php?location=listprov&tipo=2&valor='+nombre
		window.location=direccion
	}
}
</script>";

echo'
<div class="cuerpo">
		<h3>Consulta de <span>Proveedores</span></h3>
		<p>Por Favor Elija la Opci&oacute;n Deseada para Consultar los Proveedores Cargados</p>
		<form action="" method="post" class="formulario">
			<table>
				<tr>
				<td><b><label>El Nombre del Proveedor: </label></b></td>
				<td colspan="2"><input type="text" id="nombrep" name="nombrep" size="50" style="width:300px"></td>
				</tr>
				<tr>
				<td></td>
					<td><input class="boton" type="button" id="bbusc" name="bbusc" value="Buscar Proveedores" onclick="Buscar(this.id)"/></td>
					<td><input class="boton" type="button" id="btodo" name="bbtodo" value="Todos los Proveedores" onclick="Buscar(this.id)" /></td>
				</tr>
			</table>
		</form>
</div>';
}
?>