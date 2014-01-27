<?php
	//session_start();
	include ('Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$produccion=$_GET['seguimiento'];
	$privilegio=$_SESSION['perfil'];
    $estado=$_GET['estado'];
	$connect=mysql_select_db($database_cnn,$cnn);
	
	$sqlborrado="DELETE FROM produccion_proveedores";
	$cltborrar=mysql_query($sqlborrado,$cnn) or die(mysql_error());
	
	for($i=1;$i<=4;$i++){
		switch($i){
			case 1:
				$sqlec="SELECT produccion_ec.IdProduccion, produccion_ec.IdProveedor, produccion_ec.Categoria FROM produccion_ec WHERE produccion_ec.IdProveedor > 0";
				break;
			case 2:
				$sqlec="SELECT produccion_esl.IdProduccion, produccion_esl.IdProveedor, produccion_esl.Categoria FROM produccion_esl WHERE produccion_esl.IdProveedor > 0";			
				break;
			case 3:
				$sqlec="SELECT produccion_nt.IdProduccion, produccion_nt.IdProveedor, produccion_nt.Categoria FROM produccion_nt WHERE produccion_nt.IdProveedor > 0";
				break;
			case 4:
				$sqlec="SELECT produccion_im.IdProduccion, produccion_im.IdProveedor, produccion_im.Categoria FROM produccion_im WHERE produccion_im.IdProveedor > 0";
				break;
		}
		$cltprov=mysql_query($sqlec,$cnn)or die(mysql_error());
		$filas=mysql_num_rows($cltprov);
		if($filas>=1){
			while($rsprov=mysql_fetch_assoc($cltprov)){
				$sqlinserta="INSERT INTO produccion_proveedores(IdProduccion, IdProveedor, Categoria) VALUES ('".$rsprov['IdProduccion']."','".$rsprov['IdProveedor']."','".$rsprov['Categoria']."')";
				$cltinserta=mysql_query($sqlinserta,$cnn) or die(mysql_error());			
			}
		}
	}
	
    $sqldet="SELECT
proveedores.NombreProveedor,
proveedores.Identificacion,
proveedores.DV,
proveedores.Ciudad,
proveedores.Direccion,
proveedores.Telefono,
proveedores.Correo,
proveedores.Fax,
produccion.IdProyecto,
tipoidentificacion.TipoIdentificacion,
tipoidentificacion.IdTipo,
orden_compra.IdOrden,
orden_compra_estado.IdEstadoOrden,
orden_compra_estado.EstadoOrden
FROM
proveedores
INNER JOIN produccion_proveedores ON proveedores.Identificacion = produccion_proveedores.IdProveedor
INNER JOIN produccion ON produccion.IdProduccion = produccion_proveedores.IdProduccion
INNER JOIN tipoidentificacion ON tipoidentificacion.IdTipo = proveedores.TipoIdentificacion
LEFT JOIN orden_compra ON produccion_proveedores.IdProduccion = orden_compra.IdProduccion AND produccion_proveedores.IdProveedor = orden_compra.IdProveedor
LEFT JOIN orden_compra_estado ON orden_compra.IdEstadoOrden = orden_compra_estado.IdEstadoOrden  
    WHERE produccion_proveedores.IdProduccion='$produccion' 
    GROUP BY  produccion.IdProyecto, proveedores.NombreProveedor, proveedores.Ciudad, proveedores.Telefono, proveedores.Correo, orden_compra.IdOrden
    ORDER BY proveedores.NombreProveedor, orden_compra.IdOrden";
    
	$consulta=mysql_query($sqldet,$cnn) or die(mysql_error());
	$totalreg=mysql_num_rows($consulta);
	if($totalreg<1){
 ?>
        <div class="cuerpo">
            <h3>Generaci&oacute;n de Ordenes de <span>Compra</span></h3>
            <br />
            <p>La Hoja de Producci&oacute;n Seleccionada No Requiere Generaci&oacute;n de &oacute;rden de compra ya que no utiliza recursos de terceros</p>
        </div>
 <?
	}else{
 ?>
		<div class="cuerpo">
            <h3>Generaci&oacute;n de Ordenes de <span>Compra</span></h3>
            <br />
			<p>A Continuaci&oacute;n se Presentan los Proveedores Seleccionados en la Hoja de Producci&oacute;n.</p>	
			<table id="results">
                <thead>
                <tr>
                    <td><div align="center"><label>Opciones</label></div></td>
                    <td><div align="center"><label>No. Negocio</label></div></td>
        			<td><div align="center"><label>Nombre Proveedor</label></div></td>
        			<td><div align="center"><label>Ciudad</label></div></td>
        			<td><div align="center"><label>Tel&eacute;fono</label></div></td>
        			<td><div align="center"><label>Correo</label></div></td>
                    <td><div align="center"><label>No. Orden</label></div></td>
                    <td><div align="center"><label>Estado Orden</label></div></td>
                </tr>
                </thead>
                <tbody>
<?
                while($rsprov=mysql_fetch_assoc($consulta)){
				    echo '<tr>
                            <td>
                                <table>
                                    <tr>';
                                        if(($rsprov['IdEstadoOrden']==4) || ($rsprov['IdEstadoOrden']==0 && $rsprov['IdOrden']==null) && ($estado!=1)){
                                            
                                            $sqlvalida="SELECT orden_compra.IdEstadoOrden, orden_compra.IdProduccion, orden_compra.IdProveedor 
                                            FROM orden_compra 
                                            WHERE ((orden_compra.IdEstadoOrden = 2 OR orden_compra.IdEstadoOrden = 3) 
                                            AND orden_compra.IdProduccion='$produccion' AND orden_compra.IdProveedor='".$rsprov['Identificacion']."')";
                                            $cltvalida=mysql_query($sqlvalida, $cnn) or die(mysql_error());
                                            $total=mysql_num_rows($cltvalida);
                                            if ($total<1){
                                                echo '<td><a href="inicio.php?location=detalleorden&seguimiento='.$produccion.'&proveedor='.$rsprov['Identificacion'].'"><img src="images/compra.png"  /></a></td>';   
                                            }   
                                        }else{
                                            if(($rsprov['IdEstadoOrden']==1)&& ($estado!=1)){
                                                echo '<td><a href="inicio.php?location=elmorden&seguimiento='.$rsprov['IdOrden'].'&proveedor='.$rsprov['Identificacion'].'"><img src="images/elimina.png"  /></a></td>';   
                                            }   
                                        }
                                        if($rsprov['IdEstadoOrden']!=null){
                                            $linkcompra='inicio.php?location=cltcompra&seguimiento='.$rsprov['IdOrden'].'&proveedor='.$rsprov['Identificacion'];
                                            echo '<td><a href="'.$linkcompra.'"><img src="images/ver.png"  /></a></td>';    
                                        }
                               echo '</tr>
                               </table>
                            </td>';
            				echo '<td><div>'.$rsprov['IdProyecto'].'</div></td>';
            				echo '<td><div>'.$rsprov['NombreProveedor'].'</div></td>';
            				echo '<td><div>'.$rsprov['Ciudad'].'</div></td>';
            				echo '<td><div>'.$rsprov['Telefono'].'</div></td>';
            				echo '<td><div>'.$rsprov['Correo'].'</div></td>';
                            if($rsprov['IdEstadoOrden']==4){
                                echo '<td><div class="anulada">'.$rsprov['IdOrden'].'</div></td>';
                                echo '<td><div class="anulada">'.$rsprov['EstadoOrden'].'</div></td>';
                            }else{
                                echo '<td><div>'.$rsprov['IdOrden'].'</div></td>';
                                echo '<td><div>'.$rsprov['EstadoOrden'].'</div></td>';   
                            }
			         }
                     mysql_close($cnn);
                     ?>
                </tbody>
            </table>
        </div>	
<?
    }
}
?>