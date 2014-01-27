<?
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$proveedor=$_SESSION['usuario'];
	$connect=mysql_select_db($database_cnn,$cnn);
	
	$sqlordenes="SELECT
orden_compra.IdOrden,
orden_compra.IdProveedor,
orden_compra.VrCompra,
orden_compra.VrIva,
orden_compra.VrRetencion,
orden_compra.VrNeto,
orden_compra.VrReteIva,
orden_compra.VrReteIca,
orden_compra.VrReteFte,
orden_compra.Observacion,
orden_compra.Usuario,
orden_compra.FechaCreacion,
plazopago.Plazo,
produccion.IdProyecto,
orden_compra_estado.IdEstadoOrden,
orden_compra_estado.EstadoOrden
FROM
orden_compra
INNER JOIN plazopago ON orden_compra.IdPlazo = plazopago.IdPlazo
INNER JOIN produccion ON orden_compra.IdProduccion = produccion.IdProduccion
LEFT JOIN orden_compra_estado ON orden_compra.IdEstadoOrden = orden_compra_estado.IdEstadoOrden 
WHERE orden_compra_estado.IdEstadoOrden>=1 AND orden_compra.IdProveedor =".$proveedor;
    
	$cltordenes=mysql_query($sqlordenes,$cnn) or die(mysql_error());
    
    $sqlproveedores="SELECT proveedores.NombreProveedor, tipoidentificacion.TipoIdentificacion, proveedores.Identificacion, 
    proveedores.DV, proveedores.Ciudad, proveedores.Telefono, proveedores.Correo 
    FROM proveedores
    INNER JOIN tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo 
    WHERE proveedores.Identificacion = ".$proveedor;
    
    $cltproveedores=mysql_query($sqlproveedores,$cnn) or die(mysql_error());
    $rsproveedor=mysql_fetch_assoc($cltproveedores);
    
?>
<div id="presentacion">
    <h2>Ordenes de Compra Asociadas</h2>
    <br />
    <div>
    <table id="proveedor" name="proveedor">
    <thead>
        <tr><th colspan="2"><label>Información del Proveedor</label></th></tr>
    </thead>
    <tbody>
<? 
     echo '<tr><td><label><b>Proveedor:</b></label></td><td style="text-align: right;">'.$rsproveedor['NombreProveedor'].'</td><tr>';
     echo '<tr><td><label><b>Identificacion:</b></label></td><td style="text-align: right;">'.$rsproveedor['TipoIdentificacion'].': '.$rsproveedor['Identificacion'].'</td><tr>';
     echo '<tr><td><label><b>Correo:</b></label></td><td style="text-align: right;">'.$rsproveedor['Correo'].'</td><tr>';
     echo '<tr><td><label><b>Telefono:</b></label></td><td style="text-align: right;">'.$rsproveedor['Telefono'].'</td><tr>';
     echo '<tr><td><label><b>Ciudad:</b></label></td><td style="text-align: right;">'.$rsproveedor['Ciudad'].'</td><tr>';
?>
    </tbody>
    </table>
    </div>
    <br />
    <div align="center">
        <table id="tordenes" name="tordenes">
            <thead>
                <tr>
                    <th>Opciones</th>
                    <th>No. Orden</th>
                    <th>Fecha Creaci&oacute;n</th>
                    <th>No. Evento</th>
                    <th>Plazo Pago</th>
                    <th>Estado Orden Compra</th>
                </tr>
            </thead>
            <tbody>
<?
            while($rsordenes=mysql_fetch_assoc($cltordenes)){
                echo'<tr>';
                $linkorden='ordenes/pdfordencompra.php?norden='.$rsordenes['IdOrden'];
                echo '<td><a href="'.$linkorden.'" ><img src="images/search.png" alt="Ver Orden de Compra"/></a></td>';
                echo '<td>'.$rsordenes['IdOrden'].'</td>';
                echo '<td>'.$rsordenes['FechaCreacion'].'</td>';
                echo '<td>'.$rsordenes['IdProyecto'].'</td>';
                echo '<td>'.$rsordenes['Plazo'].'</td>';
                echo '<td>'.$rsordenes['EstadoOrden'].'</td>';
                echo'</tr>';
            }        
?>                
            </tbody>
        </table>
    </div>
</div>
    <script>
        $(document).ready(function(){
            $('#tordenes').dataTable({
                "bJQueryUI": true,
                "oLanguage": {
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "Nose han encontrado registros",
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "mostranto 0 a 0 de 0 registros",
                    "sInfoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "sSearch": "Filtrar: ",
                    'oPaginate': {
                        'sFirst':    "Primero",
                        'sPrevious': "Anterior",
                        'sNext':     "Siguiente",
                        'sLast':     "Ultimo"
                    }
                }
            })
        })
    </script>
<?

	mysql_close($cnn);
}
?>