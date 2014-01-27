<?php
//session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Nueva <span>Factura Creada</span></h3>
	<p>Los Datos de la factura han sido cargados de forma exitosa en el sistema.</p>
</div>';
}
?>