<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($rental_cnn,$cnn);
    
    $opcion=$_GET['tipo'];
    $criterio=$_GET['valor'];
    
    switch($opcion){
        case 1:
            $sql = "SELECT cotizacion.IdCotizacion, cotizacion.IdProyecto, cotizacion.Fecha, clientes.Identificacion, clientes.NombreCliente, tipo_precio.IdPrecio, tipo_precio.TipoPrecio, cotizacion.Elementos, cotizacion.Total, cotizacion.Usuario, cotizacion.Dias, cotizacion.estado, cotizacion.descuento FROM cotizacion INNER JOIN clientes ON cotizacion.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio";
            break;
        case 2:
            $sql = "SELECT cotizacion.IdCotizacion, cotizacion.IdProyecto, cotizacion.Fecha, clientes.Identificacion, clientes.NombreCliente, tipo_precio.IdPrecio, tipo_precio.TipoPrecio, cotizacion.Elementos, cotizacion.Total, cotizacion.Usuario, cotizacion.Dias, cotizacion.estado, cotizacion.descuento FROM cotizacion INNER JOIN clientes ON cotizacion.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio WHERE clientes.NombreCliente LIKE '%".$criterio."%'";
            break;
        case 3:
            $sql = "SELECT cotizacion.IdCotizacion, cotizacion.IdProyecto, cotizacion.Fecha, clientes.Identificacion, clientes.NombreCliente, tipo_precio.IdPrecio, tipo_precio.TipoPrecio, cotizacion.Elementos, cotizacion.Total, cotizacion.Usuario, cotizacion.Dias, cotizacion.estado, cotizacion.descuento FROM cotizacion INNER JOIN clientes ON cotizacion.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio";
            break;
        case 4:
            $sql = "SELECT cotizacion.IdCotizacion, cotizacion.IdProyecto, cotizacion.Fecha, clientes.Identificacion, clientes.NombreCliente, tipo_precio.IdPrecio, tipo_precio.TipoPrecio, cotizacion.Elementos, cotizacion.Total, cotizacion.Usuario, cotizacion.Dias, cotizacion.estado, cotizacion.descuento FROM cotizacion INNER JOIN clientes ON cotizacion.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio";
            break;
        case 5:
            $sql = "SELECT cotizacion.IdCotizacion, cotizacion.IdProyecto, cotizacion.Fecha, clientes.Identificacion, clientes.NombreCliente, tipo_precio.IdPrecio, tipo_precio.TipoPrecio, cotizacion.Elementos, cotizacion.Total, cotizacion.Usuario, cotizacion.Dias, cotizacion.estado, cotizacion.descuento FROM cotizacion INNER JOIN clientes ON cotizacion.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio WHERE cotizacion.IdProyecto=".$criterio;
            break;
    }
    
	echo'
	<div class="cuerpo">
		<h2><span>Consulta de </span>Cotizaciones</h2>
		<div align="center">
		<table id="results" class="estilotabla">
			<tr>';
		echo '<td class="estilocelda" colspan="4"><div align="center"><label>Opciones</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Proyecto</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Cliente</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Elementos</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Subtotal</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Dias</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Total</label></div></td>';
        echo '<td class="estilocelda" colspan="2"><div align="center"><label>Descuento</label></div></td>';
	
		
		$consulta=mysql_query($sql,$cnn) or die(mysql_error());
		while($registros=mysql_fetch_assoc($consulta)){
			echo '<tr>';
                $linkelimina="rental.php?location=delct&seguimiento=".$registros['IdCotizacion'];
                $linkedita="rental.php?location=edct&seguimiento=".$registros['IdCotizacion'];
                $linkaprueba="rental.php?location=aprct&seguimiento=".$registros['IdProyecto']."&cotizacion=".$registros['IdCotizacion'];
                if($registros['estado']==0){
                    echo '<td class="estilocontenido"><img src="images/editar.png" onclick="ValidaAccion(\''.$linkedita.'\')"/></td>';
                    echo '<td class="estilocontenido"><img src="images/noaprobado.png" onclick="ValidaAccion(\''.$linkaprueba.'\')"/></td>';   
                }else{
                    echo '<td class="estilocontenido"></td>';
                    echo '<td class="estilocontenido"><img src="images/aprobado.png"/></td>';
                }
				echo '<td class="estilocontenido"><a href="cotizaciones/pdfcotizacion.php?seguimiento='.$registros['IdCotizacion'].'"><img src="images/ver.gif"/></a></td>';
				echo '<td class="estilocontenido"><img src="images/elimina.gif" onclick="ValidaAccion(\''.$linkelimina.'\')"/></td>';
				echo '<td class="estilocontenido"><div>'.$registros['IdProyecto'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['NombreCliente'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Elementos'].'</div></td>';
                echo '<td class="estilocontenido"><div>'.aMoneda($registros['Total']).'</div></td>';
                echo '<td class="estilocontenido"><div>'.$registros['Dias'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.aMoneda($registros['Total']*$registros['Dias']).'</div></td>';
                if($registros['estado']==1){
                    echo '<td class="estilocontenido" colspan="2"><div align="center"><b>'.($registros['descuento']*100).' %</b></div></td>';
                }else{
                    echo '<td class="estilocontenido"><div><select id="sdesc'.$registros['IdCotizacion'].'" name="sdesc'.$registros['IdCotizacion'].'">';
                    $sqldescuento="SELECT descuento.IdRegistro, descuento.cndescuento, descuento.descuento FROM descuento";
                    $cltdescuento=mysql_query($sqldescuento,$cnn) or die(mysql_error());
                    while($rsdescuento=mysql_fetch_assoc($cltdescuento)){
                        if($rsdescuento['cndescuento']==$registros['descuento']){
                            echo '<option value="'.$rsdescuento['cndescuento'].'" selected="selected">'.$rsdescuento['descuento'].'</option>';
                        }else{
                            echo '<option value="'.$rsdescuento['cndescuento'].'">'.$rsdescuento['descuento'].'</option>';    
                        }
                    }
                    echo '</select></div></td>';
                    echo '<td class="estilocontenido"><div><a id="desc'.$registros['IdCotizacion'].'" href="cotizaciones/aplicadescuento.php?seguimiento='.$registros['IdCotizacion'].'"><img src="images/left.png" onclick="ValDescuento(\''.$registros['IdCotizacion'].'\')"/></a></div></td>';    
                }                
			echo '</tr>';
		}
	echo '</table></div><br/><div align="center" id="pageNavPosition" class="paginador"></div>
	</div>';
	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 20); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>';
	mysql_close($cnn);
}
?>