<?php
	//session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
		<h3>Men&uacute; de <span>Facturaci&oacute;n</span></h3>
		<p>Este espacio ha sido dise&ntilde;ado para la administraci&oacute;n de Facturas para los negocios creados. A continuaci&oacute;n se presentan las opciones de Administraci&oacute;n de Facturas</p>
		<ul>
			<li><a style="color:000;font-size:13px" href="inicio.php?location=nfact">Registro Factura</a></li>
			<br />
			<li><a style="color:000;font-size:13px" href="inicio.php?location=clfact">Consulta de Facturas</a></li>
		</ul>
</div>';
}
?>