<?php
	//session_start();
if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];

	if($opcion==1){
		$sql = "SELECT proveedores.NombreProveedor, proveedores.Fecha, proveedores.Identificacion, proveedores.DV, proveedores.NombreComercial, proveedores.TipoPersona, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep, tipopersona.Persona FROM proveedores
Inner Join tipopersona ON proveedores.TipoPersona = tipopersona.IdPersona WHERE NombreProveedor LIKE '%".$valor."%' ORDER BY proveedores.NombreProveedor ASC";
	}else{
		$sql = "SELECT proveedores.NombreProveedor, proveedores.Fecha, proveedores.Identificacion, proveedores.DV, proveedores.NombreComercial, proveedores.TipoPersona, proveedores.Ciudad, proveedores.Pais, proveedores.Direccion, proveedores.Fax, proveedores.Telefono, proveedores.Correo, proveedores.Actividad, proveedores.Representante, proveedores.IdentRep, tipopersona.Persona FROM proveedores
Inner Join tipopersona ON proveedores.TipoPersona = tipopersona.IdPersona ORDER BY proveedores.NombreProveedor ASC";
	}

	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
?>	
    
	<div class="cuerpo">
		<h3>Consulta de <span>Proveedores</span></h3>
        <br />
		<table id="results"><thead><tr>
	
    <th><div align="center"><label>Opciones</label></div></th>
	<th><div align="center"><label>Nombre Proveedor</label></div></th>
	<th><div align="center"><label>Fecha Creaci&oacute;n</label></div></th>
	<!--<th><div align="center"><label>Identificaci&oacute;n</label></div></th>
	<th><div align="center"><label>DV</label></div></th>
	<th><div align="center"><label>Nombre Comercial</label></div></th>-->
	<th><div align="center"><label>Tipo Persona</label></div></th>
	<th><div align="center"><label>Direcci&oacute;n</label></div></th>
	<th><div align="center"><label>Tel&eacute;fono</label></div></th>
	<!--<th><div align="center"><label>Fax</label></div></th>-->
	<th><div align="center"><label>Correo</label></div></th></thead><tbody>
<?
	while($registros=mysql_fetch_assoc($consulta)){
		echo '<tr>
		<td>
            <table class="tabla-opciones">
                <tr>
                    <td><a href="inicio.php?location=verprov&seguimiento='.$registros['Identificacion'].'"><img src="images/ver.png"  /></a></td>
                    <td><a href="inicio.php?location=editprov&seguimiento='.$registros['Identificacion'].'"><img src="images/editar.png"  /></a></td>
                    <td><a href="inicio.php?location=borrarprov&seguimiento='.$registros['Identificacion'].'"><img src="images/elimina.png"  /></a></td>
                </tr>
            </table>
        </td>
		<td><div>'.$registros['NombreProveedor'].'</div></td>
		<td><div>'.ConvFecha($registros['Fecha']).'</div></td>
		<td><div>'.$registros['Persona'].'</div></td>
		<td><div>'.$registros['Direccion'].'</div></td>
		<td><div>'.$registros['Telefono'].'</div></td>
		<td><div>'.$registros['Correo'].'</div></td>
		</tr>';
	}
    mysql_close($cnn);
?>
	<tbody></table>
	</div>
<?
}
?>
