<?php
	//session_start();
	include ('../Connections/cnn.php');
if(isset($_SESSION['usuario'])){
	$evento=$_GET['codigo'];
	$connect=mysql_select_db($rental_cnn,$cnn);
	
	$sqlpv="SELECT eventos_proveedores.IdEvento, proveedores.Identificacion, proveedores.NombreComercial, proveedores.NombreProveedor, proveedores.Ciudad, tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion, proveedores.Direccion, proveedores.Correo FROM eventos_proveedores INNER JOIN proveedores ON eventos_proveedores.IdProveedor = proveedores.Identificacion INNER JOIN tipoidentificacion ON proveedores.TipoIdentificacion = tipoidentificacion.IdTipo WHERE eventos_proveedores.IdEvento='".$evento."' GROUP BY eventos_proveedores.IdEvento, proveedores.Identificacion, tipoidentificacion.IdTipo, tipoidentificacion.TipoIdentificacion, proveedores.NombreComercial, proveedores.NombreComercial, proveedores.Ciudad, proveedores.Direccion, proveedores.Correo";
	
	$cltprov=mysql_query($sqlpv,$cnn)or die(mysql_error());
	$totalreg=mysql_num_rows($cltprov);
	if($totalreg<1){
		echo'
			<div class="cuerpo">
					<h2><span>Generaci&oacute;n</span> de Ordenes de Compra</h2>
					<p>No Se requiere de la Generaci&oacute;n de &Oacute;rdenes de Compra ya que no se emplean recursos externos</p>
			</div>';
	}else{
		echo'
		<div class="cuerpo">
			<h2><span>Generaci&oacute;n</span> de Ordenes de Compra</h2>
			<p>A Continuaci&oacute;n se Presentan los Proveedores y Personal Seleccionado para el evento seleccionado</p>	
			<table id="results" class="estilotabla"><tr>';
			echo '<td class="estilocelda" ><div align="center"><label>Opciones</label></div></td>';
			echo '<td class="estilocelda"><div align="center"><label>No. Evento</label></div></td>';
			echo '<td class="estilocelda" ><div align="center"><label>Nombre Proveedor</label></div></td>';
			echo '<td class="estilocelda" ><div align="center"><label>Tipo Ident.</label></div></td>';
			echo '<td class="estilocelda" ><div align="center"><label>Identificaci&oacute;n</label></div></td>';
			echo '<td class="estilocelda"><div align="center"><label>Ciudad</label></div></td>';
			echo '<td class="estilocelda"><div align="center"><label>Direcci&oacute;n</label></div></td>';
			echo '<td class="estilocelda"><div align="center"><label>Correo</label></div></td></tr>';
	
			while($rsprov=mysql_fetch_assoc($cltprov)){
				echo '<tr>';
				$proveedor=$rsprov['Identificacion'];
				
				$linkdetalle='rental.php?location=detorden&codigo='.$evento.'&proveedor='.$proveedor;
				echo '<td class="estilocontenido"><a href="'.$linkdetalle.'"><img src="../images/ver.gif"  /></a></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['IdEvento'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['NombreProveedor'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['TipoIdentificacion'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['Identificacion'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['Ciudad'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['Direccion'].'</div></td>';
				echo '<td class="estilocontenido"><div>'.$rsprov['Correo'].'</div></td>';
			}
			echo '</table><div align="center" id="pageNavPosition" class="paginador"></div>
			</div>';
			echo '
			 <script type="text/javascript">
				var pager = new Pager(\'results\', 10); 
				pager.init(); 
				pager.showPageNav(\'pager\', \'pageNavPosition\'); 
				pager.showPage(1);
			</script>';
	}
	mysql_close($cnn);
}

?>