<?php
	//session_start();
if(isset($_SESSION['usuario'])){
	include ('../Connections/cnn.php');
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];

	if($opcion==1){
		$sql = "SELECT proveedores.NombreProveedor, proveedores.Fecha, proveedores.Identificacion, proveedores.DV, proveedores.NombreComercial, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep FROM proveedores WHERE NombreProveedor LIKE '%".$valor."%' ORDER BY proveedores.NombreProveedor ASC";
	}else{
		$sql = "SELECT proveedores.NombreProveedor, proveedores.Fecha, proveedores.Identificacion, proveedores.DV, proveedores.NombreComercial, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep FROM proveedores ORDER BY proveedores.NombreProveedor ASC";
	}

	$connect=mysql_select_db($rental_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());

	echo'
	<div class="cuerpo">
		<h3>Consulta de <span>Proveedores</span></h3>
		<table id="results" class="estilotabla"><tr>';

	echo '<td class="estilocelda" colspan="3"><div align="center"><label>Opciones</label></div></td>
	<td class="estilocelda"><div align="center"><label>Nombre Proveedor</label></div></td>
	<td class="estilocelda"><div align="center"><label>Fecha Creaci&oacute;n</label></div></td>
	<td class="estilocelda"><div align="center"><label>Identificaci&oacute;n</label></div></td>
	<td class="estilocelda"><div align="center"><label>DV</label></div></td>
	<td class="estilocelda"><div align="center"><label>Nombre Comercial</label></div></td>
	<td class="estilocelda"><div align="center"><label>Direcci&oacute;n</label></div></td>
	<td class="estilocelda"><div align="center"><label>Tel&eacute;fono</label></div></td>
	<td class="estilocelda"><div align="center"><label>Fax</label></div></td>
	<td class="estilocelda"><div align="center"><label>Correo</label></div></td>';
	while($registros=mysql_fetch_assoc($consulta)){
		echo '<tr>
		<td><a href="rental.php?location=verprov&seguimiento='.$registros['Identificacion'].'"><img src="images/ver.gif" /></a></td>
		<td><a href="rental.php?location=editprov&seguimiento='.$registros['Identificacion'].'"><img src="images/editar.png" /></a></td>
		<td><a href="rental.php?location=borrarprov&seguimiento='.$registros['Identificacion'].'"><img src="images/elimina.gif" /></a></td>
		<td class="estilocontenido"><div>'.$registros['NombreProveedor'].'</div></td>
		<td class="estilocontenido"><div>'.ConvFecha($registros['Fecha']).'</div></td>
		<td class="estilocontenido"><div>'.$registros['Identificacion'].'</div></td>
		<td class="estilocontenido"><div>'.$registros['DV'].'</div></td>
		<td class="estilocontenido"><div>'.$registros['NombreComercial'].'</div></td>
		<td class="estilocontenido"><div>'.$registros['Direccion'].'</div></td>
		<td class="estilocontenido"><div>'.$registros['Telefono'].'</div></td>
		<td class="estilocontenido"><div>'.$registros['Fax'].'</div></td>
		<td class="estilocontenido"><div>'.$registros['Correo'].'</div></td>
		</tr>';
	}
	echo '</table><div align="center" id="pageNavPosition" class="paginador"></div>';
	echo '</div>';
	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 10); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>
	';
	mysql_close($cnn);
}
?>