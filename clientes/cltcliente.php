<?php
if(isset($_SESSION['usuario'])){
	include ('Connections/cnn.php');
	
	$opcion=$_GET['tipo'];
	$valor=$_GET['valor'];
	if($opcion==1){
		$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, tipoempresa.TipoEmpresa, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad
FROM clientes LEFT JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo RIGHT JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON usuarios_unidades.IdUnidad = clientes_unidades.IdUnidad WHERE NombreCliente LIKE '%".$valor."%' AND usuarios_unidades.usuario='".$_SESSION['usuario']."'";
	}else{
		$sql = "SELECT clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, tipoempresa.TipoEmpresa, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad
FROM clientes LEFT JOIN tipoempresa ON clientes.TipoEmpresa = tipoempresa.IdTipo RIGHT JOIN clientes_unidades ON clientes.IdCliente = clientes_unidades.IdCliente INNER JOIN usuarios_unidades ON usuarios_unidades.IdUnidad = clientes_unidades.IdUnidad WHERE usuarios_unidades.usuario = '".$_SESSION['usuario']."'";
	}
	
	if($_SESSION['unidad']!=0){
		$sql.=" AND usuarios_unidades.IdUnidad = '".$_SESSION['unidad']."'";
	}

	$sql.=" GROUP BY clientes.IdCliente, clientes.NombreCliente, clientes.Identificacion, clientes.DV, clientes.PersonaContacto, clientes.TelefonoContacto, clientes.CExtension, clientes.TipoEmpresa, clientes.email, clientes.Direccion, clientes.Fax, clientes.FExtension, clientes.Pais, clientes.Ciudad, tipoempresa.TipoEmpresa ORDER BY clientes.NombreCliente ASC";

	$connect=mysql_select_db($database_cnn,$cnn);
	$consulta=mysql_query($sql,$cnn) or die(mysql_error());
?>
    <div class="cuerpo">
        <h3>Consulta de <span>Clientes</span></h3>
        <br />
		<div align="center">
		<table id="results">
            <thead>
            <tr>
                <th><div align="center"><label>No. Cliente</label></div></th>
                <th><div align="center"><label>Cliente</label></div></th>
                <th><div align="center"><label>Identificaci&oacute;n</label></div></th>
                <th><div align="center"><label>Digito verificaci&oacute;n</label></div></th>
                <th><div align="center"><label>Telefono</label></div></th>
                <th><div align="center"><label>Tipo Empresa</label></div></th>
                <th><div align="center"><label>Correo</label></div></th>
                <th><div align="center"><label>Direcci&oacute;n</label></div></th>
                <th><div align="center"><label>Fax</label></div></th>
            </tr>
            </thead>
            <tbody>
            <?
            while($registros=mysql_fetch_assoc($consulta)){
        		echo '<tr>';
        		echo '<td><div>'.$registros['IdCliente'].'</div></td>';
        		echo '<td><div>'.$registros['NombreCliente'].'</div></td>';
        		echo '<td><div>'.$registros['Identificacion'].'</div></td>';
        		echo '<td><div>'.$registros['DV'].'</div></td>';
        		echo '<td><div>'.$registros['TelefonoContacto'].'</div></td>';
        		echo '<td><div>'.$registros['TipoEmpresa'].'</div></td>';
        		echo '<td><div>'.$registros['email'].'</div></td>';
        		echo '<td><div>'.$registros['Direccion'].'</div></td>';
        		echo '<td><div>'.$registros['Fax'].'</div></td>';
        		echo '</tr>';
	       }
           mysql_close($cnn);
           ?>
           </tbody>
	   </table>
    </div>
    <br />
    <div align="center" id="pageNavPosition"></div>
</div>
    
<?	
}
?>