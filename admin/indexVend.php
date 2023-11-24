<?php 
    $resultado=$_GET['resultado'] ?? null;
    require '../includes/app.php';
    incluirTemplate('header');
    use App\Propiedad;

    // Proteger esta ruta.
    estaAutenticado();

    $db=conectarDB();
    $consult="SELECT * FROM vendedores;";
    $datos=mysqli_query($db,$consult);
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        $id=$_POST['id'];

        //validamos que el id sea un entero
        $id=filter_var($id, FILTER_VALIDATE_INT);
        if ($id){          
            //eliminar la propiedad
            $query="DELETE FROM vendedores WHERE id=${id}";
            $resultado=mysqli_query($db,$query);
            //pasamos un resultado para poder mostrar un mensaje.
            if ($resultado){
                header('location: /admin/indexVend.php/?resultado=3');
            } else{
                header('location: /admin/indexVend.php/?resultado=4');
            }
        }
}

?>
    <script type="text/javascript">
        function confirmEliminado() {
            return window.confirm( '¿Seguro que quiere borrar la propiedad?' );
        }
    </script>

<main class="contenedor seccion">
    <h1>Administrador Vendedores</h1>
    <?php if (intval($resultado)===1){ ?>
        <p class="alerta exito">Vendedor creado correctamente</p>
    <?php } else if(intval($resultado)===2){ ?>
        <p class="alerta exito">Vendedor actualizado correctamente</p>
    <?php } else if(intval($resultado)===3){ ?>
        <p class="alerta exito">Vendedor borrado correctamente</p>
    <?php }else if(intval($resultado)===4){ ?>
        <p class="alerta exito">No se puede borrar al vendedor porque tiene propiedades bajo su mando</p>
    <?php } ?>

    <a href="/admin/vendedores/crear.php" class="boton boton-verde crear">Nuevo Vendedor</a>
    <a href="/admin/index.php" class="boton boton-verde crear">Propiedades</a>

    <table class="propiedades">
        <thead>
            <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Nº Telf</th>
                    <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($fila=mysqli_fetch_assoc($datos)){?>
                <tr>
                    
                    <td><?php echo $fila['id'] ?></td>
                    <td><?php echo $fila['nombre'] ?></td>
                    <td><?php echo $fila['apellidos'] ?></td>
                    <td><?php echo $fila['telefono'] ?></td> 
                    <td>
                        <a href="/admin/vendedores/actualizar.php/?id=<?php echo $fila['id']?>" class="boton-amarillo-block">Actualizar vendedor</a>
                        <form action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" method="post" onsubmit="return confirmEliminado()">
                            <input type="hidden" name="id" value=<?php echo $fila['id'];?>>
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>    
</main>