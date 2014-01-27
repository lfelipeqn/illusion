<?php
    include('../Connections/cnn.php');
    $conecta=mysql_select_db($database_cnn,$cnn);

    $target_path = "../images/";
    $target_path = $target_path . basename( $_FILES['imagen']['name']); 

    $imagen=$_FILES['imagen']['name'];
    $tipo=$_FILES['imagen']['type'];
    $tamano=$_FILES['imagen']['size'];
    $tmpname=$_FILES['imagen']['tmp_name'];
    $error=$_FILES['imagen']['error'];
    
    $fp=fopen($tmpname, 'r');
    $data=fread($fp, filesize($tmpname));
    $data=addslashes($data);
    fclose($fp);
    
    if(move_uploaded_file($tmpname, $target_path)) {
        
        $nombre=$_POST['nombre'];
        $sqlunidad="INSERT INTO unidades (Unidad, Logo, RutaLogo) VALUES ('".$nombre."', '".$data."', 'images/".$_FILES['imagen']['name']."')";
        $cltunidad=mysql_query($sqlunidad,$cnn) or die(mysql_error());
        echo "La Unidad nueva unidad de negocio ha sido creada exitosamente, para habilitar el ingreso de usuarios utilice la opci&oacute;n de edici&ocute;n de usuarios.";
    } else{
        echo "Hubo problemas con la carga del archivo, por favor intente nuevamente.";
    }
?>