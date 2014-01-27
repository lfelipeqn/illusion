<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($rental_cnn,$cnn);
    
    $opcion=$_GET['tipo'];
    $criterio=$_GET['valor'];
    
    switch($opcion){
        case 1:
            $sql = "SELECT proyectos.IdProyecto, clientes.Identificacion, clientes.NombreCliente, 
    proyectos.NombreProyecto, proyectos.Ciudades, proyectos.NombreContacto, proyectos.TelefonoContacto, 
    proyectos.EmailContacto, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje 
    FROM proyectos 
    INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion";
            break;
        case 2:
            $sql = "SELECT proyectos.IdProyecto, clientes.Identificacion, clientes.NombreCliente, 
    proyectos.NombreProyecto, proyectos.Ciudades, proyectos.NombreContacto, proyectos.TelefonoContacto, 
    proyectos.EmailContacto, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje 
    FROM proyectos 
    INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion WHERE clientes.NombreCliente LIKE '%".$criterio."%'";
            break;
        case 3:
            $sql = "SELECT proyectos.IdProyecto, clientes.Identificacion, clientes.NombreCliente, 
    proyectos.NombreProyecto, proyectos.Ciudades, proyectos.NombreContacto, proyectos.TelefonoContacto, 
    proyectos.EmailContacto, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje 
    FROM proyectos 
    INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion WHERE proyectos.NombreProyecto LIKE '%".$criterio."%'";
            break;
        case 4:
            //$sql = "SELECT eventos.IdEvento, eventos.Evento, eventos.LugarEvento, clientes.NombreCliente, eventos.FechaEntrega, eventos.FechaRecogida, eventos.Horas, eventos.Valor, eventos.Finalizado, tipo_precio.TipoPrecio FROM eventos INNER JOIN clientes ON eventos.IdCliente = clientes.Identificacion INNER JOIN tipo_precio ON eventos.Valor = tipo_precio.IdPrecio";
            break;
        case 5:
            $sql = "SELECT proyectos.IdProyecto, clientes.Identificacion, clientes.NombreCliente, 
    proyectos.NombreProyecto, proyectos.Ciudades, proyectos.NombreContacto, proyectos.TelefonoContacto, 
    proyectos.EmailContacto, proyectos.FechaEvento, proyectos.LugarEvento, proyectos.FechaMontaje, proyectos.FechaDesmontaje 
    FROM proyectos 
    INNER JOIN clientes ON proyectos.IdCliente = clientes.Identificacion WHERE proyectos.IdProyecto=".$criterio;
            break;
    }
            
    
	echo'
	<div class="cuerpo">
		<h2><span>Consulta de </span>Proyectos</h2>
		<div align="center">
		<table id="results" class="estilotabla">
			<tr>';
		echo '<td class="estilocelda"><div align="center"><label>Opciones</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>No. Proyecto</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Nombre Proyecto</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Fecha Evento</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Fecha Montaje</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Fecha Desmontaje</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Ciudad Evento</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Lugar Evento</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Cliente</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Contacto</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Telefono Contacto</label></div></td>';
        echo '<td class="estilocelda"><div align="center"><label>Correo Contacto</label></div></td>';
	
		$consulta=mysql_query($sql,$cnn) or die(mysql_error());
		while($registros=mysql_fetch_assoc($consulta)){
			echo '<tr>';
                //$linkelimina="rental.php?location=delct&seguimiento=".$registros['IdCotizacion'];
                $linkedita="rental.php?location=edpr&seguimiento=".$registros['IdProyecto'];
                echo '<td class="estilocontenido"><img src="images/editar.png" onclick="ValidaAccion(\''.$linkedita.'\')"/></td>';
                //$linkaprueba="rental.php?location=aprct&seguimiento=".$registros['IdProyecto']."&cotizacion=".$registros['IdCotizacion'];
                /*if($registros['estado']==0){
                    
                    echo '<td class="estilocontenido"><img src="images/noaprobado.png" onclick="ValidaAccion(\''.$linkaprueba.'\')"/></td>';   
                }else{
                    echo '<td class="estilocontenido"></td>';
                    echo '<td class="estilocontenido"><img src="images/aprobado.png"/></td>';
                }
				echo '<td class="estilocontenido"><a href="cotizaciones/pdfcotizacion.php?seguimiento='.$registros['IdCotizacion'].'"><img src="images/ver.gif"/></a></td>';
				echo '<td class="estilocontenido"><img src="images/elimina.gif" onclick="ValidaAccion(\''.$linkelimina.'\')"/></td>';*/
				echo '<td class="estilocontenido"><div>'.$registros['IdProyecto'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['NombreProyecto'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['FechaEvento'].'</div></td>';
                echo '<td class="estilocontenido"><div>'.$registros['FechaMontaje'].'</div></td>';
                echo '<td class="estilocontenido"><div>'.$registros['FechaDesmontaje'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Ciudades'].'</div></td>';
                echo '<td class="estilocontenido"><div>'.$registros['LugarEvento'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['NombreCliente'].'</div></td>';
                echo '<td class="estilocontenido"><div>'.$registros['NombreContacto'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['TelefonoContacto'].'</div></td>';
                echo '<td class="estilocontenido"><div>'.$registros['EmailContacto'].'</div></td>';                
			echo '</tr>';
		}
	echo '</table></div><br/><div align="center" id="pageNavPosition" class="paginador"></div>
	</div>';
	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 25); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>';
	mysql_close($cnn);
}
?>