<?php
session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Hoja de Producci&oacute;n <span>Validada</span></h3>
	<p>La Hoja de Producci&oacute;n ha sido validada por los usuarios involucrados</p>
	<p class="p0">La Hoja de producci&oacute;n solo puede ser modificada para inclusi&oacute;n de adicionales, los cambios adicionales deben realizarse bajo la supervisi&oacute;n de un administrador.</p>
</div>';
}
?>