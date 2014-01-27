<?php
//session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
		<h2><span>Equipo</span> Actualizado</h2>
		<p>la Informaci&oacute;n asociada al elemento seleccionado ha sido actualizada de forma exitosa. Los cambios efectuados ser&aacute;n tenidos en cuenta en todos los procesos del sistema</p>
</div>';
}
?>