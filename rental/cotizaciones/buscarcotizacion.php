<?php
include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
echo "
<script type=\"text/javascript\">
function Buscar(){	if((document.getElementById('tipob1').checked==false)&&(document.getElementById('tipob2').checked==false)&&(document.getElementById('tipob5').checked==false)){
		alert('Debe Seleccionar la Opci�n de B�squeda')
	}else{
	var nombre=document.getElementById('nombrep').value
	var opcion
	if(document.getElementById('tipob1').checked) opcion=document.getElementById('tipob1').value
	if(document.getElementById('tipob2').checked) opcion=document.getElementById('tipob2').value
	// if(document.getElementById('tipob3').checked) opcion=document.getElementById('tipob3').value
	// if(document.getElementById('tipob4').checked) opcion=document.getElementById('tipob4').value
	if(document.getElementById('tipob5').checked) opcion=document.getElementById('tipob5').value
	var direccion='rental.php?location=cltcotiz&tipo='+opcion+'&valor='+nombre
	window.location=direccion	
	}
}
</script>";

echo'
<div class="cuerpo">
	<h3>Consulta de <span>Cotizaciones</span></h3>
	<p>Seleccione el Criterio de b&uacute;squeda deseado para Consultar Cotizaciones</p>
	<form action="" method="post" id="fbusc" name="fbusc">
		<table>
			<tr>
			<td><b><label>Criterio de B&uacute;squeda: </label></b></td>
			<td colspan="3"><input type="text" id="nombrep" name="nombrep" size="80"></td>
			</tr>
			<tr>
				<td><label><input type="radio" id="tipob1" name="tipob" value="1" />Todas las Cotizaciones</label></td>
				<td><label><input type="radio" id="tipob2" name="tipob" value="2" />Nombre Cliente</label></td>
				<td><label><input type="radio" id="tipob5" name="tipob" value="5" />N&uacute;mero Proyecto</label></td>
                <td><input type="button" id="bbusc" name="bbusc" style="width:180px; font-weight:bold; background-color:white;" value="Ver Eventos" onclick="Buscar()" /></td>
			</tr>
		</table>
	</form>
</div>';
}
?>