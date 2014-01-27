<?php
     include('../Connections/cnn.php');
     $conecta=mysql_select_db($database_cnn,$cnn);
     
     $usuario=$_POST['user'];
     $nombre=$_POST['nombre'];
     $correo=$_POST['correo'];
     $pass=$_POST['pass'];
     $grupo=$_POST['grupo'];
     
     $sqlnombre="UPDATE usuarios SET Nombre='$nombre' WHERE usuarios.Usuario='".$usuario."'";
     $sqlcorreo="UPDATE usuarios SET Correo='$correo' WHERE usuarios.Usuario='".$usuario."'";
     $sqlpass="UPDATE usuarios SET Password='".md5($pass)."' WHERE usuarios.Usuario='".$usuario."'";
     $sqlgrupo="UPDATE usuarios SET IdPerfil='$grupo' WHERE usuarios.Usuario='".$usuario."'";
     
     $cltnombre=mysql_query($sqlnombre,$cnn);
     $cltcorreo=mysql_query($sqlcorreo,$cnn);
     $cltgrupo=mysql_query($sqlgrupo,$cnn);
     
     if($pass!=""){
        $cltpass=mysql_query($sqlpass,$cnn);
     }
     
     $sqlunidades="DELETE FROM usuarios_unidades WHERE usuarios_unidades.usuario='$usuario'";
     $cltunidades=mysql_query($sqlunidades) or die(mysql_error());
     
     $sqluni="SELECT unidades.IdUnidad, unidades.Unidad FROM unidades";
     $cltuni=mysql_query($sqluni,$cnn) or die(mysql_error());
     while($rsuni=mysql_fetch_assoc($cltuni)){
        if(isset($_POST['unidad_'.$rsuni['IdUnidad']])){
            $sqlpermiso="INSERT INTO usuarios_unidades (usuario, IdUnidad) VALUES ('$usuario','".$rsuni['IdUnidad']."')";
            $cltpermiso=mysql_query($sqlpermiso,$cnn) or die(mysql_error());
        }
     }
     
     
     header("Location: admin.php?location=confedusr")
      
?>