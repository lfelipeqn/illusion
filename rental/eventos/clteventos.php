<?php
	//session_start();
if(isset($_SESSION['usuario'])){
	include ('../Connections/cnn.php');
	$conexion=mysql_select_db($rental_cnn,$cnn);
	ListaInventario();
    
    $opcion=$_GET['tipo'];
    $criterio=$_GET['valor'];
    
    switch($opcion){
        case 1:
            $sqlevt = "SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.Ciudades, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones, clientes.Identificacion, clientes.NombreCliente, eventos.IdEvento, eventos.IdCotizacion, eventos.Valor, eventos.Horas, eventos.Finalizado, tipo_precio.TipoPrecio FROM eventos INNER JOIN proyectos ON proyectos.IdProyecto = eventos.IdProyecto INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion INNER JOIN cotizacion ON eventos.IdCotizacion = cotizacion.IdCotizacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio";
            break;
        case 2:
            $sqlevt = "SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.Ciudades, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones, clientes.Identificacion, clientes.NombreCliente, eventos.IdEvento, eventos.IdCotizacion, eventos.Valor, eventos.Horas, eventos.Finalizado, tipo_precio.TipoPrecio FROM eventos INNER JOIN proyectos ON proyectos.IdProyecto = eventos.IdProyecto INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion INNER JOIN cotizacion ON eventos.IdCotizacion = cotizacion.IdCotizacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio WHERE clientes.NombreCliente LIKE '%".$criterio."%'";
            break;
        case 3:
            $sqlevt = "SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.Ciudades, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones, clientes.Identificacion, clientes.NombreCliente, eventos.IdEvento, eventos.IdCotizacion, eventos.Valor, eventos.Horas, eventos.Finalizado, tipo_precio.TipoPrecio FROM eventos INNER JOIN proyectos ON proyectos.IdProyecto = eventos.IdProyecto INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion INNER JOIN cotizacion ON eventos.IdCotizacion = cotizacion.IdCotizacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio WHERE proyectos.NombreProyecto LIKE '%".$criterio."%'";
            break;
        case 4:
            //$sqlevt = "SELECT eventos.IdEvento, eventos.Evento, eventos.LugarEvento, clientes.NombreCliente, eventos.FechaEntrega, eventos.FechaRecogida, eventos.Horas, eventos.Valor, eventos.Finalizado, tipo_precio.TipoPrecio FROM eventos INNER JOIN clientes ON eventos.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON eventos.Valor = tipo_precio.IdPrecio";
            break;
        case 5:
            $sqlevt = "SELECT proyectos.IdProyecto, proyectos.NombreProyecto, proyectos.Ciudades, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje, proyectos.Observaciones, clientes.Identificacion, clientes.NombreCliente, eventos.IdEvento, eventos.IdCotizacion, eventos.Valor, eventos.Horas, eventos.Finalizado, tipo_precio.TipoPrecio FROM eventos INNER JOIN proyectos ON proyectos.IdProyecto = eventos.IdProyecto INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion INNER JOIN cotizacion ON eventos.IdCotizacion = cotizacion.IdCotizacion INNER JOIN tipo_precio ON cotizacion.IdPrecio = tipo_precio.IdPrecio WHERE proyectos.IdProyecto=".$criterio;
            break;
    }
    
	$connect=mysql_select_db($rental_cnn,$cnn);
	$cltevt=mysql_query($sqlevt,$cnn) or die(mysql_error());

	echo'<div class="cuerpo">
		<h2><span>Consulta de </span>Eventos</h2>
        </br>
		<div align="center">
		<table id="results" class="estilotabla"><tr>';
	echo '<td class="estilocelda" colspan="6"><div align="center"><label>Opciones</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>No. Proyecto</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Nombre Proyecto</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Lugar Evento</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Nombre Cliente</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Fecha Salida</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Fecha Retorno</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Horas Evento</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Precio</label></div></td>';

	while($registros=mysql_fetch_assoc($cltevt)){
		echo '<tr>';
		if ($registros['Finalizado']==1){
            echo '<td class="estilocontenido"></td>';
            echo '<td class="estilocontenido"></td>';
            echo '<td class="estilocontenido"></td>';
		}else{
            echo '<td class="estilocontenido"><a href="rental.php?location=detevent&codigo='.$registros['IdEvento'].'&tprec='.$registros['Valor'].'&horas='.$registros['Horas'].'"><img src="images/right.jpg" title="Alistamiento de Equipos"/></a></td>';
            echo '<td class="estilocontenido"><a href="rental.php?location=entequipo&codigo='.$registros['IdEvento'].'&tprec='.$registros['Valor'].'"><img src="images/left.png" title="Ingreso de Equipos"/></a></td>';
            echo '<td class="estilocontenido"><a href="rental.php?location=delevt&codigo='.$registros['IdEvento'].'"><img src="images/elimina.gif" title="Eliminar Evento"/></a></td>';
		}
        
		echo '<td class="estilocontenido"><a href="rental.php?location=ordcomp&codigo='.$registros['IdEvento'].'"><img src="images/compra.png" title="Ordenes de Compra"/></a></td>';
        echo '<td class="estilocontenido"><a href="eventos/creaevento.php?codigo='.$registros['IdEvento'].'"><img src="images/ver.gif" title="Ver Detalle"/></a></td>';
        
        if ($registros['Finalizado']==1){
            echo '<td class="estilocontenido"><img src="images/aprobado.png" title="Evento Aprobado"/></td>';
        }else{
            echo '<td class="estilocontenido"><img src="images/noaprobado.png" title="Evento No Aprobado"/></td>';    
        }	
        echo '<td class="estilocontenido"><div>'.$registros['IdProyecto'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['NombreProyecto'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['LugarEvento'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['NombreCliente'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['FechaMontaje'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['FechaDesmontaje'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['Horas'].'</div></td>';
		echo '<td class="estilocontenido"><div>'.$registros['TipoPrecio'].'</div></td>';
		echo '</tr>';
	}

	echo '</table></div><br /><div align="center" id="pageNavPosition" class="paginador"></div>';
	echo '</div>';
	mysql_close($cnn);
	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 10); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>
	';
}
?>