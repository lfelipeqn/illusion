<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$codigo=$_GET['codigo'];
	$tabla=$_GET['tabla'];
	$connect=mysql_select_db($rental_cnn,$cnn);

	$sql="SELECT inventario.Codigo, categorias.Categoria, categorias.Tabla, inventario.Articulo, inventario.Caracteristicas, inventario.Marca, inventario.Modelo, inventario.Serie, inventario.Cantidad, inventario.Compra, inventario.PrecioComercial, inventario.PrecioAlianza, inventario.Imagen FROM categorias INNER JOIN inventario ON inventario.IdCategoria = categorias.IdCategoria WHERE inventario.Codigo='".$codigo."'";

	$cltdet=mysql_query($sql,$cnn) or die(mysql_error());
	$rsdet=mysql_fetch_assoc($cltdet);

	echo'
	<div class="cuerpo">
		<h2><span>Consulta de </span>Elementos</h2>
		<div align="left">
		<table>
			<tr>
				<td>
					<table class="estilotabla">
					  <tr>
						  <td rowspan="9">';
						  if(strlen($rsdet['Imagen'])<1){
							echo 'NO HAY FOTO';
						  }else{
							echo'<img widht="200px" height="200px" src="inventario/verimagen.php?codigo='.$codigo.'&tabla='.$tabla.'" />';  
						  }

						  echo '</td>
						  <td><b>Categoria</b></td>
						  <td><label>'.$rsdet['Categoria'].'</label></td>
					  </tr>
					  <tr>
						  <td><label><b>Nombre del Activo</b></label></td>
						  <td>'.$rsdet['Articulo'].'</td>
					  </tr>
					  <tr>
						  <td><label><b>Codigo Activo</b></label></td>
						  <td>'.$rsdet['Codigo'].'</td>
					  </tr>
					  <tr>
						  <td><label><b>Marca</b></label></td>
						  <td>'.$rsdet['Marca'].'</td>
					  </tr>
					  <tr>
						  <td><label><b>Modelo</b></label></td>
						  <td>'.$rsdet['Modelo'].'</td>
					  </tr>
					  <tr>
						  <td><label><b>Serie</b></label></td>
						  <td>'.$rsdet['Serie'].'</td>
					  </tr>
					  <tr>
						  <td><label><b>Fecha Compra</b></label></td>
						  <td>'.$rsdet['Compra'].'</td>
					  </tr>
					  <tr>
						  <td><label><b>Precio Comercial</b></label></td>
						  <td>'.aMoneda($rsdet['PrecioComercial']).'</td>
					  </tr>
					  <tr>
						  <td><label><b>Precio Alianza</b></label></td>
						  <td>'.aMoneda($rsdet['PrecioAlianza']).'</td>
					  </tr>
				  </table>
				</td>
				<td valign="top">
					<div align="left"><b>HISTORIAL DEL EQUIPO</b></div>';
					$sqlhist="SELECT historial.IdRegistro, historial.Codigo, historial_tipo.IdTipo, historial_tipo.Motivo, 
                    historial.Fecha, eventos.IdEvento, proyectos.IdProyecto, proyectos.NombreProyecto AS Evento 
                    FROM historial 
                    INNER JOIN historial_tipo ON historial.IdTipo = historial_tipo.IdTipo 
                    LEFT JOIN eventos ON historial.IdEvento = eventos.IdEvento 
                    LEFT JOIN proyectos ON eventos.IdProyecto = proyectos.IdProyecto 
                    WHERE historial.Codigo=".$codigo." ORDER BY historial.Fecha";
					
                    $clthist=mysql_query($sqlhist,$cnn) or die(mysql_error());
					echo '<table id="results">
						<tr>
							<td class="estilocelda">Fecha</td>
							<td class="estilocelda">Actividad</td>
							<td class="estilocelda">Evento</td>
						</tr>';
					while($rshist=mysql_fetch_assoc($clthist)){
						echo '<tr>';
						echo '<td>'.ConvFecha($rshist['Fecha']).'</td>';
						echo '<td>'.$rshist['Motivo'].'</td>';
						echo '<td>'.$rshist['Evento'].'</td>';
						echo '</tr>';
					}
					echo '</table><div align="center" id="pageNavPosition" class="paginador"></div>
	</div>';		
			echo'</td>
			</tr>
		</table>
		</div>
	</div>';

	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 12); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>';
		
	mysql_close($cnn);
}

?>