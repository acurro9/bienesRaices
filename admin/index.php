<?php 
    $resultado=$_GET['resultado'] ?? null;
    require '../includes/funciones.php';
    incluirTemplate('header', true);

    require '../includes/config/database.php';
    $db=conectarDB();
    $consult="SELECT * FROM propiedades;";
    $datos=mysqli_query($db,$consult);

?>
<link rel="stylesheet" href="./styleTabla.css">
<main class="contenedor seccion">
    <h1>Administrador Propiedades</h1>
    <?php if (intval($resultado)===1){ ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php } else if(intval($resultado)===2){ ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php } else if(intval($resultado)===3){ ?>
        <p class="alerta exito">Anuncio borrado correctamente</p>
    <?php } else if(intval($resultado)===4){ ?>
        <p class="alerta exito">Vendedor añadido correctamente</p>
    <?php } ?>

    <table >
        <tr>
                <td>Imagen</td>
                <td>ID</td>
                <td>Nombre</td>
                <td>Precio</td>
                <!--
                <td>Habitaciones</td>
                <td>Baños</td>
                <td>Estacionamiento</td>
                <td>Descripcion</td>-->
                <td>Operaciones</td>
        </tr>
        <?php
        while ($fila=mysqli_fetch_assoc($datos)){?>
            <tr>
                
                <td><img src="../imagenes/<?php echo $fila['imagen'] ?>" alt=""></td>
                <td><?php echo $fila['id'] ?></td>
                <td><?php echo $fila['titulo'] ?></td>
                <td><?php echo $fila['precio'] ?></td>
                <!--
                <td><?php echo $fila['habitaciones'] ?></td>
                <td><?php echo $fila['wc'] ?></td>
                <td><?php echo $fila['estacionamiento'] ?></td>
                <td><?php echo $fila['descripcion'] ?></td>
                -->  
                <td>
                    <a href="/admin/propiedades/actualizar.php/?id=<?php echo $fila['id']?>" class="boton boton-verde">Actualizar propiedad</a>
                    <a href="/admin/propiedades/borrar.php/?id=<?php echo $fila['id']?>" class="boton boton-amarillo borrar">Borrar propiedad</a>
                </td>
            </tr>
        <?php } ?>
                
    </table>
        

    <a href="/admin/propiedades/crear.php" class="boton boton-verde crear">Nueva propiedad</a>
    <a href="/admin/indexVend.php" class="boton boton-verde crear">Vendedores</a>
    
</main>

