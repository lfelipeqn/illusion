<?php
//session_start();
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
	<h3>Nuevo Presupuesto <span>Creado</span></h3>
	<p>La Informaci&oacute;n Asociada al Presupuesto Creado ha sido Incluida en el Sistema de forma exitosa</p>
	<p class="p0">Si Desea realizar Modificaciones a este presupuesto, por favor ingrese a la opci&oacute;n de Edici&oacute;n de Presupuestos.</p>
</div>';
}
?>