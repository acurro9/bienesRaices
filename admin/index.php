<?php 
    $resultado=$_GET['resultado'] ?? null;
    require '../includes/funciones.php';
    incluirTemplate('header', true);

    require '../includes/config/database.php';
    $db=conectarDB();
    $consult="SELECT * FROM propiedades;";
    $datos=mysqli_query($db,$consult);

?>
<main class="contenedor seccion">
    <h1>Administrador Propiedades</h1>
    <?php if (intval($resultado)===1){ ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php } else if(intval($resultado)===2){ ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php } else if(intval($resultado)===3){ ?>
        <p class="alerta exito">Anuncio borrado correctamente</p>
    <?php } else if(intval($resultado)===4){ ?>
        <p class="alerta exito">No se puedo borrar el anuncio</p>
    <?php } ?>

    
    <a href="/admin/propiedades/crear.php" class="boton boton-verde crear">Nueva propiedad</a>
    <a href="/admin/indexVend.php" class="boton boton-verde crear">Vendedores</a>
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
                    <!--
                        <td><?php echo $fila['habitaciones'] ?></td>
                        <td><?php echo $fila['wc'] ?></td>
                        <td><?php echo $fila['estacionamiento'] ?></td>
                        <td><?php echo $fila['descripcion'] ?></td>
                    -->  
                    <td>
                        <a href="/admin/propiedades/actualizar.php/?id=<?php echo $fila['id']?>" class="boton-amarillo-block">Actualizar propiedad</a>
                        <a href="/admin/propiedades/borrar.php/?id=<?php echo $fila['id']?>" class="boton-rojo-block">Borrar propiedad</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
                
    </table>
    
</main>

