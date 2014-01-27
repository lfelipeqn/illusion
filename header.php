<?php

if(isset($_SESSION['usuario'])){
echo'<div class="header">
		<div class="menu">
			<div class="fright">
				<ul>
					<li><a href="index.php"><em><b>Inicio</b></em></a></li>
					<li><a href="inicio.php?location=procesos"><em><b>Procesos</b></em></a></li>
					 <li><a href="inicio.php?location=report"><em><b>Reportes</b></em></a></li>';
					/*if(($_SESSION['perfil']=='Administrador') || ($_SESSION['perfil']=='Operativo')){
					echo '<li><a href="inicio.php?location=inventario"><em><b>Inventarios</b></em></a></li>';
					}*/

					if(Privilegios($_SESSION['perfil'],'CrearFactura')){
					echo '<li><a href="inicio.php?location=menfact"><em><b>Facturaci&oacute;n</b></em></a></li>';
					}
                    echo '<li><a href="inicio.php?location=manual"><em><b>Manual del Usuario</b></em></a></li>';
                    echo '<li><a href="inicio.php?location=mapa"><em><b>Mapa del Sitio</b></em></a></li>
				</ul>
			</div>
		</div>
</div>';
}

?>