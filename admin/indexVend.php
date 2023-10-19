<?php 
    $resultado=$_GET['resultado'] ?? null;
    require '../includes/funciones.php';
    incluirTemplate('header', true);

    require '../includes/config/database.php';
    $db=conectarDB();
    $consult="SELECT * FROM vendedores;";
    $datos=mysqli_query($db,$consult);

?>

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
                        <a href="/admin/vendedores/borrar.php/?id=<?php echo $fila['id']?>" class="boton-rojo-block">Borrar vendedor</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>    
</main>