<?php

    require './includes/config/database.php';
    $db=conectarDB();

    $consult="SELECT * FROM propiedades;";
    $datos=mysqli_query($db,$consult);


    ?><div class="contenedor-anuncios"> <?php
while ($fila=mysqli_fetch_assoc($datos)){?>

        <div class="anuncio" >
            <picture>
                <source srcset="./imagenes/<?php echo $fila['imagen']; ?>" type="image/jpeg">
                <img loading="lazy" src="./imagenes/<?php echo $fila['imagen']; ?>" alt="anuncio">
            </picture>

            <div class="contenido-anuncio">
                <h3><?php echo $fila['titulo'] ?></h3>
                <div class="desc">
                    <p class="desc"><?php echo $fila['descripcion'] ?></p>
                </div>
                <p class="precio">$<?php echo $fila['precio'] ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $fila['wc'] ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $fila['estacionamiento'] ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $fila['habitaciones'] ?></p>
                    </li>
                </ul>

                <a href="anuncio.php" class="boton-amarillo-block">
                    Ver Propiedad
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->
        <?php } ?>
    </div> <!--.contenedor-anuncios-->
    <?php $db ->close();
?>