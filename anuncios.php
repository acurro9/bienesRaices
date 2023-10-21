
<body> 
    
<?php
    
    require './includes/funciones.php';
    incluirTemplate('header');    

    //Se realiza la conexión a la base de datos
    $db= mysqli_connect('localhost', 'root', '', 'bienesraices_crud');
    //Se realiza la consulta para tener el nº total de propiedades
    $consulta="SELECT count(*) as contador FROM propiedades;";
    $datos=mysqli_query($db,$consulta);
    $data=mysqli_fetch_assoc($datos);
    $cantPropiedades=$data['contador'];
    //Por defecto los productos por pagina son 6 y la página es 1, si en la url está presente cambia
    $ppp = 6;
    if (isset($_GET["anuncios"])) {
        $ppp = $_GET["anuncios"];
    }
    $pagina = 1;
    if (isset($_GET["pagina"])) {
        $pagina = $_GET["pagina"];
    }
    //Se coge el total de páginas redondeando hacia arriba
    $totalPaginas=ceil($cantPropiedades/$ppp);
    //Se calculan el limit y el offset
    $offset=($pagina-1)*$ppp;
    $limit= $ppp;
    //Se realiza la consulta a la base de datos
    $consult="SELECT * FROM propiedades limit $limit offset $offset;";
    $datos=mysqli_query($db,$consult);

    ?> 
    <link rel="stylesheet" href="build/css/app.css">


    <!--Se le pide al usuario el número de productos por página-->
    <form action="" class="paginado">
        <fieldset>
            <legend>Productos por página: </legend>
            <select name="anuncios">
                <option <?php echo $ppp==3?'selected':''; ?> value=3>3</option>
                <option <?php echo $ppp==6?'selected':''; ?> value=6>6</option>
                <option <?php echo $ppp==10?'selected':''; ?> value=10>10</option>
                <option <?php echo $ppp==20?'selected':''; ?> value=20>20</option>
            </select>
            <input type="submit" value="Cambiar" class="boton boton-verde">
        </fieldset>
    </form>

    <main class="contenedor seccion">

    <?php
    
    ?>
    <div class="contenedor-anuncios"> <?php
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
        
        <div class="alinear-derecha">
            <a href="anuncios.php?anuncios=200" class="boton-verde">Ver Todas</a>
        </div>
        <!--Para moverse entre las páginas-->
        <div class="pagComplete">
            <?php if($pagina>1){?>
                
            <a class="pag" href="/anuncios.php?anuncios=<?php echo $ppp;?>&pagina=<?php echo $pagina-1?>"><</a><?php } ?>
            <?php for($i=0; $i<$totalPaginas; $i++){ ?>
                <a class="pag" href="/anuncios.php?anuncios=<?php echo $ppp;?>&pagina=<?php echo $i+1;?>" <?php echo $pagina==$i+1?'style="color: #71B100; font-weight: 800;"':'';?>><?php echo $i+1;?></a>
                <?php } 
                if($pagina<$totalPaginas){
                    ?>
            <a class="pag" href="/anuncios.php?anuncios=<?php echo $ppp;?>&pagina=<?php echo $pagina+1?>">></a>
                    <?php } ?>
        </div>

    </main>
    <?php 
        include './includes/templates/footer.php';
    ?>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>