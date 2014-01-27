<?php

if(isset($_SESSION['usuario'])){
?>
<div class="header">
    <div class="menu">
        <div class="fright">
            <ul>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'inicio')"><em><b>Inicio</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'cliente')"><em><b>Clientes</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'proveedor')"><em><b>Proveedores</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'inventario')"><em><b>Inventario</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'proyecto')"><em><b>Proyectos</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'cotizacion')"><em><b>Cotizaciones</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'evento')"><em><b>Eventos</b></em></a></li>
                <li><a href="#" onclick="CambiaEstilo('opciones', 'factura')"><em><b>Factura</b></em></a></li>
            </ul>
        </div>
    </div>	
</div>
<div class="opciones" id="opciones" name="opciones"><ul><li><a href="index.php">Cerrar Sesi&oacute;n</a></li><li><a href="rental.php?location=manual">Manual del Usuario</a></li></ul></div>
<?
}
?>