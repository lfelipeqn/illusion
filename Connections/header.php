<?php
if(isset($_SESSION['usuario'])){
echo'<div class="header">
		<div class="menu">
			<div class="fright">
				<ul>
					<li><a href="index.php"><em><b>Inicio</b></em></a></li>
					<li><a href="rental.php?location=invt"><em><b>Inventario</b></em></a></li>
					<li><a href="rental.php?location="><em><b>Alistamiento</b></em></a></li>
					<li><a href="rental.php?location="><em><b>Factura</b></em></a></li>
					<li><a href="rental.php?location="><em><b>Mapa del Sitio</b></em></a></li>
				</ul>
			</div>
		</div>
</div>';
}
?>