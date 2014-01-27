<?php
include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
echo "
<script type=\"text/javascript\">
function Buscar(control){
var nombre
	if (control=='bbusc'){
		nombre =document.getElementById('nombrep').value
		var direccion='inicio.php?location=listclie&tipo=1&valor='+nombre
		window.location=direccion
	}
	if (control=='btodo'){
		nombre=0
		var direccion='inicio.php?location=listclie&tipo=2&valor='+nombre
		window.location=direccion
	}
}
</script>
";
echo'
<div class="cuerpo">
		<h3>Consulta de <span>Clientes</span></h3>
		<p>Por Favor Elija la Opci&oacute;n Deseada para Consultar los Clientes Cargados</p>
		<form action="" method="post">
			<table>
				<tr>
				<td><b><label>El Nombre del Cliente: </label></b></td>
				<td colspan="2"><input type="text" id="nombrep" name="nombrep" size="40"></td>
				</tr>
				<tr>
				<td></td>
					<td><input type="button" id="bbusc" name="bbusc" value="Buscar Clientes" onclick="Buscar(this.id)" /></td>
						<td><input type="button" id="btodo" name="bbtodo" value="Ver Todos los Clientes" onclick="Buscar(this.id)" /></td>
				</tr>
			</table>
		</form>
</div>';
}
?>