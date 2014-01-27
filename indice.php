<?php

if(isset($_SESSION['usuario'])){
echo '<div class="arrowsidemenu"><div class="contenido">';
if(Privilegios($_SESSION['perfil'],'CrearClientes')){
echo '<div class="menuheaders"><a href="inicio.php?location=clientes" title="RegistroCliente">Registro Clientes</a></div>
	<ul class="menucontents">';
		if ($_SESSION['unidad']!=0){
			echo '<li><a href="inicio.php?location=addcliente">Nuevo Cliente</a></li>';
		}

		echo '<li><a href="inicio.php?location=consultacl">Consultar Clientes</a></li>';
		if ($_SESSION['unidad']!=0){
			echo '<li><a href="inicio.php?location=updcliente">Actualizar Cliente</a></li>';
		}
	echo '</ul>';
}

if(Privilegios($_SESSION['perfil'],'CrearProveedor')){
echo '<div class="menuheaders"><a href="inicio.php?location=proveedores" title="RegistroProveedores">Proveedores</a></div>
	<ul class="menucontents">
		<li><a href="inicio.php?location=addproveedor">Registro Proveedor</a></li>
		<li><a href="inicio.php?location=ctlprv">Consulta Proveedores</a></li>';
        if(Privilegios($_SESSION['perfil'],'EstadoOrdenCompra')){
        echo '<li><a href="inicio.php?location=rgoc">Radicar Orden de Compra</a></li>';    
        }    
	echo '</ul>';
}

if(Privilegios($_SESSION['perfil'],'ConsultarProyecto')){
echo '<div class="menuheaders"><a href="inicio.php?location=proyectos">Proyectos</a></div>
	<ul class="menucontents">';
		if(Privilegios($_SESSION['perfil'],'CrearProyecto')){
			if ($_SESSION['unidad']!=0){
				echo '<li><a href="inicio.php?location=nproy">Nuevo Proyecto</a></li>';
			}
		}
		echo '<li><a href="inicio.php?location=cltproy">Consultar Proyectos</a></li>
	</ul>';
}

if(Privilegios($_SESSION['perfil'],'ConsultarPresupuesto')){
echo '<div class="menuheaders"><a href="inicio.php?location=gnpres" title="Presupuesto">Hoja Presupuesto</a></div>
	<ul class="menucontents">';
		if ($_SESSION['unidad']!=0){
			echo '<li><a href="inicio.php?location=npresup">Nuevo Presupuesto</a></li>';
		}
		echo '<li><a href="inicio.php?location=cltpres">Consultar Presupuestos</a></li>
	</ul>';
}

if(Privilegios($_SESSION['perfil'],'ConsultarNegocio')){
echo '<div class="menuheaders"><a href="inicio.php?location=" title="negocios">Hoja Negocio</a></div>
	<ul class="menucontents">';
	if (Privilegios($_SESSION['perfil'],'CrearNegocio')){
		if ($_SESSION['unidad']!=0){
			echo '<li><a href="inicio.php?location=nnegocio">Nuevo Negocio</a></li>';
		}
	}
		echo '<li><a href="inicio.php?location=cltnego">Consultar Negocios</a></li>
	</ul>';
}

if(Privilegios($_SESSION['perfil'],'ConsultarProduccion')){
echo '<div class="menuheaders"><a href="inicio.php?location=" title="produccion">Hoja Producci&oacute;n</a></div>
	<ul class="menucontents">';
		/*if ($privilegio!=('Administrativo')){
			if ($_SESSION['unidad']!=0){
				echo '<li><a href="inicio.php?location=nprod">Nueva Producci&oacute;n</a></li>';
			}
		}*/
		echo'<li><a href="inicio.php?location=cltpro">Consultar Producciones</a></li>
	</ul>';
}

echo '</div></div>';
}

?>