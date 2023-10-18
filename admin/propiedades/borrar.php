<?php
    $id=$_GET['id'];

    require '../../includes/config/database.php';
    $db=conectarDB();

    $borrarCons="DELETE from propiedades where id=$id;";
    $borrar=mysqli_query($db,$borrarCons);
    header('Location:/admin?resultado=3');
?>
