<?php
if(isset($_SESSION['usuario'])){
	include ('../Connections/cnn.php');
	$conexion=mysql_select_db($rental_cnn,$cnn);
	
	$sqlfact = "SELECT facturas.IdFactura, facturas.IdEvento, facturas.FechaEmision, facturas.FechaVencimiento, facturas.Subtotal, facturas.Impuesto, facturas.Total FROM facturas";

	$connect=mysql_select_db($rental_cnn,$cnn);
	$cltfact=mysql_query($sqlfact,$cnn) or die(mysql_error());

	echo'<div class="cuerpo">
		<h2><span>Consulta de </span>Facturas</h2>
        </br>
		<div align="center">
		<table id="results" class="estilotabla"><tr>';
	echo '<td class="estilocelda"><div align="center"><label>Opciones</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>No. Factura</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>N&uacute;mero Evento</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Fecha Emisi&oacute;n</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Fecha Vencimiento</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Subtotal</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Impuesto</label></div></td>';
	echo '<td class="estilocelda"><div align="center"><label>Total</label></div></td>';

	while($registros=mysql_fetch_assoc($cltfact)){
		echo '<tr>';
            echo '<td class="estilocontenido"><a href="facturas/creafactura.php?&codigo='.$registros['IdFactura'].'"><img src="images/ver.gif" title="Ver Factura"/></a></td>';    	
            echo '<td class="estilocontenido"><div>'.$registros['IdFactura'].'</div></td>';
    		echo '<td class="estilocontenido"><div>'.$registros['IdEvento'].'</div></td>';
    		echo '<td class="estilocontenido"><div>'.NormalFecha($registros['FechaEmision']).'</div></td>';
    		echo '<td class="estilocontenido"><div>'.NormalFecha($registros['FechaVencimiento']).'</div></td>';
    		echo '<td class="estilocontenido"><div>'.aMoneda($registros['Subtotal']).'</div></td>';
    		echo '<td class="estilocontenido"><div>'.aMoneda($registros['Impuesto']).'</div></td>';
    		echo '<td class="estilocontenido"><div>'.aMoneda($registros['Total']).'</div></td>';
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