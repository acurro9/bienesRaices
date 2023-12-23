<?php 
require 'includes/app.php';
    use App\Propiedad;
    $propiedades=Propiedad::all();
    incluirTemplate('header');
?>
<main class="contenedor seccion">
<div class="contenedor-anuncios">
<?php foreach($propiedades as $propiedad){ ?>
        <div class="anuncio">
                <img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Anuncio casa en el lago">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo; ?></h3>
                <p class="desc"><?php echo $propiedad->descripcion; ?></p>
                <p class="precio">$ <?php echo $propiedad->precio; ?></p>

                <ul class="iconos-caracteristicas">
                    <li>
                        <img src="/build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad->wc; ?></p>
                    </li>
                    <li>
                        <img src="/build/img/icono_estacionamiento.svg" alt="icono autos">
                        <p><?php echo $propiedad->estacionamiento; ?></p>
                    </li>
                    <li>
                        <img src="/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $propiedad->habitaciones; ?></p>
                    </li>
                </ul>


                <a href="anuncio.php?id=<?php echo $propiedad->id; ?>" class="boton boton-amarillo d-block">Ver Propiedad</a>
            </div>
        </div>

<?php }  ?>
    </div>
    </main>
    <?php
incluirTemplate('footer');
?>