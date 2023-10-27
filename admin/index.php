<?php 
    $resultado=$_GET['resultado'] ?? null;
    require '../includes/funciones.php';
    incluirTemplate('header');

    require '../includes/config/database.php';
    $db=conectarDB();

    $auth=estaAutenticado();
    if(!$auth){
        header('Location: /');
    }

    $consult="SELECT * FROM propiedades;";
    $datos=mysqli_query($db,$consult); 
    ?>
    <script type="text/javascript">
        function confirmEliminado() {
            return window.confirm( '¿Seguro que quiere borrar la propiedad?' );
        }
    </script>
<?php

    if ($_SERVER['REQUEST_METHOD']==='POST'){
        $id=$_POST['id'];

        //validamos que el id sea un entero
        $id=filter_var($id, FILTER_VALIDATE_INT);
        if ($id){
            //eliminar la imagen
            $query="SELECT imagen FROM propiedades WHERE id=${id}";
            $resultado= mysqli_query($db,$query);
            $fila=mysqli_fetch_assoc($resultado);
          
            unlink('../imagenes/'.$fila['imagen']);
  
            //eliminar la propiedad
            $query="DELETE FROM propiedades  WHERE id=${id}";
            $resultado=mysqli_query($db,$query);
            //pasamos un resultado para poder mostrar un mensaje.
            if ($resultado){
                header('location: /admin?resultado=3');
            }
        }
}

?>
<main class="contenedor seccion">
    <h1>Administrador</h1>
    <?php if (intval($resultado)===1){ ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php } else if(intval($resultado)===2){ ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php } else if(intval($resultado)===3){ ?>
        <p class="alerta exito">Anuncio borrado correctamente</p>
    <?php } ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde crear">Nueva propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-verde crear">Nuevo Vendedor</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($fila=mysqli_fetch_assoc($datos)){?>
                <tr>
                    
                    <td><?php echo $fila['id'] ?></td>
                    <td><?php echo $fila['titulo'] ?></td>
                    <td><img src="../imagenes/<?php echo $fila['imagen'] ?>" alt="" class="imagen-tabla"></td>
                    <td><?php echo $fila['precio'] ?></td>
                    <td>
                        <a href="/admin/propiedades/actualizar.php/?id=<?php echo $fila['id']?>" class="boton-amarillo-block">Actualizar propiedad</a>
                        <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()">
                            <input type="hidden" name="id" value=<?php echo $fila['id'];?>>
                            <input type="submit" class="boton-rojo-block" value="Eliminar Propiedad">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>       
    </table>
</main>   

