<?php
//session_start();
if(isset($_SESSION['usuario'])){
    $equipo=$_GET['equipo'];
echo '
<div class="cuerpo">
		<h2><span>Nuevo Equipo</span> Registrado</h2>
		<p>Se ha registrado el Nuevo equipo con el C&oacute;digo: <b>'.$equipo.'</b></p>
        <p>Por Favor Proceda con la Impresi&oacute;n del C&oacute;digo de barras correspondiente.</p>
</div>';
}

?>