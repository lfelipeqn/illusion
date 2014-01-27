<?php
     include('../Connections/cnn.php');
     $conecta=mysql_select_db($database_cnn,$cnn);
     $idgrupo=$_POST['idgrupo'];
     $nomgrupo=$_POST['nombregrupo'];
     echo $sql;
     $sql="UPDATE perfiles SET Perfil='$nomgrupo' WHERE perfiles.IdPerfil='$idgrupo'";
     $clt=mysql_query($sql,$cnn) or die(mysql_error());
     
     if($clt){
        header("Location: admin.php?location=confedgrupo");   
     }

?>