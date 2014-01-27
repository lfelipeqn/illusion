<?php
	session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$connect=mysql_select_db($rental_cnn,$cnn);
	$sql="SELECT categorias.IdCategoria, categorias.Categoria, categorias.Tabla FROM categorias";
	
	$cltcat=mysql_query($sql,$cnn) or die(mysql_error());
	echo'
	<div class="cuerpo">
		<h2><span>Consulta de </span>Inventarios</h2>
		<div align="center">
		<table id="results" class="estilotabla">
			<tr>';
		echo '<td class="estilocelda"><div align="center"><label>C&oacute;digo</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Categoria</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Articulo</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Marca</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Modelo</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Serie</label></div></td>';
		echo '<td class="estilocelda"><div align="center"><label>Compra</label></div></td>';
	
	while($rscat=mysql_fetch_assoc($cltcat)){
		$sql = "SELECT ".$rscat['Tabla'].".Codigo, categorias.Categoria, ".$rscat['Tabla'].".Articulo, ".$rscat['Tabla'].".Marca, ".$rscat['Tabla'].".Modelo, ".$rscat['Tabla'].".Serie, ".$rscat['Tabla'].".Compra FROM ".$rscat['Tabla']." INNER JOIN categorias ON ".$rscat['Tabla'].".IdCategoria = categorias.IdCategoria";
		
		$consulta=mysql_query($sql,$cnn) or die(mysql_error());
		while($registros=mysql_fetch_assoc($consulta)){
			echo '<tr>';		
				echo '<td class="estilocontenido"><div>'.$registros['Codigo'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Categoria'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Articulo'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Marca'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Modelo'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Serie'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$registros['Compra'].'</div></td>';
			echo '</tr>';
		}
	}
	echo '</table></div><br/><div align="center" id="pageNavPosition" class="paginador"></div>
	</div>';
	echo '
	 <script type="text/javascript">
        var pager = new Pager(\'results\', 20); 
        pager.init(); 
        pager.showPageNav(\'pager\', \'pageNavPosition\'); 
        pager.showPage(1);
    </script>
	';
	mysql_close($cnn);
}
?>