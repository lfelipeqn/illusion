<?php
	include('../Connections/cnn.php');
    include('funciones.php');
    date_default_timezone_set('America/Bogota');
	$conect=mysql_select_db($database_cnn,$cnn);
    
    $tipoprov=$_POST['ntpersona'];
    $nprov=$_POST['nproveedor'];
    $ncomer=$_POST['ncomercial'];
    $tipoi=$_POST['tipoi'];
    $proveedor=$_POST['nnit'];
    $ndv=$_POST['ndv'];
    $ciudad=$_POST['nciudad'];
    $pais=$_POST['npais'];
    $direccion=$_POST['ndir'];
    $fax=$_POST['npfax'];
    $telefono=$_POST['ntel'];
    $correo=$_POST['ncorreo'];
    $repres=$_POST['nrepl'];
    $idrep=$_POST['ncc'];
    $fecha=date('Y-m-d');
    $clave=md5($_POST['pass']);
    
    $sqlproveedor="SELECT proveedores.Identificacion, proveedores.NombreProveedor FROM proveedores WHERE proveedores.Identificacion =".$proveedor;
    $clproveedor=mysql_query($sqlproveedor,$cnn) or die(mysql_error());
    $total=mysql_num_rows($clproveedor);
    if($total>=1){
        $cadproveedor="UPDATE proveedores SET NombreProveedor='$nprov', TipoIdentificacion='$tipoi', clave='$clave', 
        NombreComercial='$ncomer', TipoPersona='$tipoprov', Ciudad='$ciudad', Pais='$pais', Direccion='$direccion', 
        Fax='$fax', Telefono='$telefono', Correo='$correo', Representante='$repres', IdentRep='$idrep' WHERE proveedores.Identificacion=".$proveedor;
    }else{
        $cadproveedor="INSERT INTO proveedores (NombreProveedor, Fecha, TipoIdentificacion, Identificacion, DV, clave, NombreComercial, TipoPersona, Ciudad, Pais, Direccion, Fax, Telefono, Correo, Representante, IdentRep) 
        VALUES ('$nprov', '$fecha', '$tipoi', '$proveedor', '$ndv', '$clave', '$ncomer', '$tipoprov', '$ciudad', '$pais', '$direccion', '$fax', '$telefono', '$correo', '$repres', '$idrep')";
    }
	$rgproveedor=mysql_query($cadproveedor,$cnn) or die(mysql_error());
	mysql_close($cnn);
    
    $mensaje='
    <html>
        <body>
            <p>Estimado Proveedor,</p>
            <br />
            <p>De acuerdo con su solicitud de registro, a continuación nos permitimos remitir sus credenciales de ingreso a nuestro sistema de proveedores, a través del cual, los proveedores registrados, pueden realizar transacciones de forma rápida y amigable.</p>
            <p>Le agradecemos ingresar con sus credenciales y proceder con la actualización de su Información Tributaria, Información para Pagos, e Información sobre su empresa.</p>
            <br />
            <p>Para Ingresar a nuestro portal de proveedores haga click acá: <a href="http://www.proveedores.entretenimientosinlimites.co">Portal Proveedores ESL</a></p>
            <p>Usuario: '.$_POST['nnit'].'</p>
            <p>Clave: '.$_POST['pass'].'</p>
            <br />
            <br />
            <p>Cordial Saludo:</p>
            <p>Entretenimiento Sin Limites LTDA</p>
            <p><b>Por Favor NO responda este mensaje</b></p>
        </body>
    </html>';
    
    Mensaje('Información de Ingreso al Portal de Proveedores ESL',$mensaje,$correo);
	header("Location: index.php");
?>