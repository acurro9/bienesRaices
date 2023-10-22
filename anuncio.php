<body>
<?php
    $id=$_GET['id'];
    require './includes/funciones.php';
    incluirTemplate('header');
    require './includes/config/database.php';

    $id= filter_var($id, FILTER_VALIDATE_INT);
    if (!$id){
        header('Location: /admin');
    } else{
        
        $db=conectarDB();
        $consult="SELECT imagen, titulo, precio, habitaciones, wc, estacionamiento, descripcion FROM propiedades where id=$id;";
        $datos=mysqli_query($db,$consult);
    
        while ($fila=mysqli_fetch_row($datos)){
                $imagen=$fila[0]; 
                $titulo=$fila[1];
                $precio=$fila[2];
                $habitaciones=$fila[3];
                $wc=$fila[4];
                $estacionamiento=$fila[5];
                $descripcion=$fila[6];
            
        }
    }
?> 

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $titulo ?></h1>

        <picture>
            <source srcset="/imagenes/<?php echo $imagen; ?>" type="image/jpeg">
            <img loading="lazy" src="/imagenes/<?php echo $imagen; ?>"alt="imagen de la propiedad">
        </picture>

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $precio ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $wc ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $estacionamiento ?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $habitaciones ?></p>
                </li>
            </ul>

            <p><?php echo $descripcion ?>.</p>
        </div>
    </main>
    <?php 
        include './includes/templates/footer.php';
    ?>
    <script src="build/js/bundle.min.js"></script>
</body>
</html>