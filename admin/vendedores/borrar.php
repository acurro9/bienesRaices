<?php
    $id=$_GET['id'];

    require '../../includes/config/database.php';
    $db=conectarDB();

    $borrarCons="DELETE from vendedores where id=$id;";
    $borrar=mysqli_query($db,$borrarCons);
    if($borrar){
        header('Location:/admin/indexVend.php/?resultado=3');
    } else{
        header('Location:/admin/indexVend.php/?resultado=4');
    }
?>
