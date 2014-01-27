<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($rental_cnn,$cnn);
	echo'
	<div class="cuerpo">
		<h2><span>Consulta de </span>Inventarios</h2>
		<div align="center">
		<table id="results" class="estilotabla">
			<tr>';
		echo '<td class="estilocelda" colspan="4"><div align="center"><label>Opciones</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>C&oacute;digo</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Categoria</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Articulo</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Marca</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Modelo</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Serie</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Compra</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Estado</label></div></td>';
	
		$sql = "SELECT inventario.Codigo, inventario.IdCategoria, categorias.Categoria, inventario.Articulo, inventario.Caracteristicas, inventario.Marca, inventario.Modelo, inventario.Serie, inventario.Cantidad, inventario.Compra, inventario.Imagen, estados.IdEstado, estados.Estado FROM inventario INNER JOIN categorias ON inventario.IdCategoria = categorias.IdCategoria INNER JOIN estados ON inventario.IdEstado = estados.IdEstado ORDER BY inventario.Codigo";

		$consulta=mysql_query($sql,$cnn) or die(mysql_error());
		while($registros=mysql_fetch_assoc($consulta)){
			$link='rental.php?location=elm&tabla=inventario&codigo='.$registros['Codigo'];
            $linkelimina="rental.php?location=invelim&seguimiento=".$registros['Codigo'];
			echo '<tr>';
				echo '<td class="estilocontenido"><a href="rental.php?location=entmant&seguimiento='.$registros['Codigo'].'"><img src="images/engrane.jpg" title="Entrada de mantenimiento"/></a></td>';
				echo '<td class="estilocontenido"><a href="rental.php?location=salmant&seguimiento='.$registros['Codigo'].'"><img src="images/tools.jpg" title="Salida a mantenimiento"/></a></td>';
				echo '<td class="estilocontenido"><a href="rental.php?location=invedit&seguimiento='.$registros['Codigo'].'"><img src="images/editar.png" title="Modificar Equipo"/></a></td>';
				echo '<td class="estilocontenido"><img src="images/elimina.gif" title="Eliminar Equipo" onclick="ValidaAccion(\''.$linkelimina.'\')"/></td>';
				echo '<td class="estilocontenido"><div><a href="'.$link.'">'.$registros['Codigo'].'</a></div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Categoria'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Articulo'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Marca'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Modelo'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Serie'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Compra'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Estado'].'</div></td>';
			echo '</tr>';
		}
	echo '</table></div><br/><div align="center" id="pageNavPosition" class="paginador"></div>
	</div>';
	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 50); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>';
	mysql_close($cnn);
}
?>