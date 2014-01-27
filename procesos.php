<?php
if(isset($_SESSION['usuario'])){
echo '
<div class="cuerpo">
		<h3>Procesos Corporativos <span>Illusion</span></h3>
		<p>Opci&oacute;n destinada a la consulta de todos los procesos corporativos de la compa&ntilde;&iacute;a</p>
		<p class="p0">Ac&aacute; se incluye toda la informaci&oacute;n necesaria para adelantar todos los Procesos de la compa&ntilde;&iacute;a de una manera exitosa</p>
        </br>
	    <div><a href="inicio.php?location=comercial" >Proceso Comercial</a></div>
        <div><a href="inicio.php?location=negocios" >Proceso Hoja de Negocios</a></div>
        <div><a href="inicio.php?location=produccion" >Proceso Hoja de Producci&oacute;n</a></div>
        <div><a href="inicio.php?location=cg" >Proceso Orden de Compra y Gastos</a></div>
        <div><a href="inicio.php?location=factura" >Proceso de Facturaci&oacute;n</a></div>
        <div><a href="inicio.php?location=recaudo" >Proceso de Recaudo</a></div>
        <div><a href="inicio.php?location=crm" >Proceso de CRM</a></div>
    </div>
</div>';
}
?>