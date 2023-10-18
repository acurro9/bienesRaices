<?php
    $id=$_GET['id'];

    require '../../includes/config/database.php';
    $db=conectarDB();

    $borrarCons="DELETE from propiedades where id=$id;";
    $nomImg="SELECT * from propiedades where id=$id;";

    $img=mysqli_query($db,$nomImg);

    while ($fila=mysqli_fetch_row($img)){
        $imagen=$fila[3]; 
    
}


    
    $ruta='../../imagenes/'.$imagen;
    $borrar=mysqli_query($db,$borrarCons);
    
    if($borrar){
        unlink($ruta);
        header('Location:/admin/index-php/?resultado=3');
    } else{
        header('Location:/admin/index-php/?resultado=4');
    }



    
?>
