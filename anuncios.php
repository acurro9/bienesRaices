
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

        $nombre="";
        $precioMin="";
        $precioMax="";
        $descripcion="";
        $habitaciones="";
        $wc="";
        $estacionamiento="";

    if ($_SERVER['REQUEST_METHOD']==="POST"){

        $nombre=mysqli_real_escape_string($db, $_POST['nombre']);
        $precioMin=mysqli_real_escape_string($db,$_POST['preciomin']);
        $precioMax=mysqli_real_escape_string($db,$_POST['preciomax']);
        $descripcion=mysqli_real_escape_string($db,$_POST['descripcion']);
        $habitaciones= mysqli_real_escape_string($db,$_POST['habitaciones']);
        $wc=mysqli_real_escape_string($db,$_POST['wc']);
        $estacionamiento=mysqli_real_escape_string($db,$_POST['estacionamiento']);

        //Así se muestran todas las propiedades que contengan esa palabra en una sola página
        // $busqueda="SELECT * from propiedades where titulo like '%$nombre%';";
        // $datos=mysqli_query($db,$busqueda);
        // $totalPaginas=1;
        
        //Así se muestran la cantidad de propiedades ya establecida (6)
        // $busqueda="SELECT * from propiedades where titulo like '%$nombre%' limit $limit offset $offset;";
        // $datos=mysqli_query($db,$busqueda);

        if(!$nombre){
            $nombre='%';
        }
        if(!$precioMin){
            $precioMin=0;
        }
        if(!$precioMax){
            $precioMax=1000000000000000000;
        }
        if(!$descripcion){
            $descripcion='%';
        }
        if(!$habitaciones){
            $habitaciones=0;
        }
        if(!$wc){
            $wc=0;
        }
        if(!$estacionamiento){
            $estacionamiento=0;
        }
        $busqueda="SELECT * from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento limit $limit offset $offset;";
        $datos=mysqli_query($db,$busqueda);

        $busqCantidad="SELECT count(*) as contador2 from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento limit $limit offset $offset;";
        $datos2=mysqli_query($db,$busqCantidad);
        if($datos && $datos2){
            $data=mysqli_fetch_assoc($datos2);
            $cantPropiedades=$data['contador2'];
            $totalPaginas=ceil($cantPropiedades/$ppp);
        }
    }
    function guardarValor($variable){
        if ($variable=='%' || $variable==0 || $variable==1000000000000000000){
            return false;
        } else{
            return true;
        }
    }
    ?> 
    <link rel="stylesheet" href="build/css/app.css">

    <div class="prop">
         
        <!--Para la busqueda-->
        <form action="anuncios.php" class="busqueda" method="POST">
            <fieldset class="busqueda">

                <div class="buscar">
                    <label style="color: white;" for="nombre">Buscar:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Titulo" value="<?php echo guardarValor($nombre)?$nombre:'';?>">
                </div>

                <div class="buscar">
                    <label for="precio">Precio: </label>
                    <div class="diferenciaPrecio">
                        <input type="number" id="preciomin" placeholder="Min. Precio" name="preciomin" value="<?php echo guardarValor($precioMin)?$precioMin:'';?>">
                        <input type="number" id="preciomax" placeholder="Max. Precio" name="preciomax" value="<?php echo guardarValor($precioMax)?$precioMax:'';?>">
                    </div>
                </div>
                <div class="buscar">
                    <label for="habitaciones">Habitaciones: </label>
                    <input type="number" id="habitaciones" placeholder="Min. Habitaciones" name="habitaciones" value="<?php echo guardarValor($habitaciones)?$habitaciones:'';?>">
                </div>

                <div class="buscar">
                    <label for="wc">WC: </label>
                    <input type="number" id="wc" placeholder="Min. WC" name="wc" value="<?php echo guardarValor($wc)?$wc:'';?>">
                </div>

                <div class="buscar">
                    <label for="estacionamiento">Estacionamiento: </label>
                    <input type="number" id="estacionamiento" placeholder="Min. Estacionamientos" name="estacionamiento" value="<?php echo guardarValor($estacionamiento)?$estacionamiento:'';?>">
                </div>

                <div class="">
                    <label for="descripcion">Descripción: </label>
                    <input type="text" id="descripcion" name="descripcion" placeholder="Descripción" value="<?php echo guardarValor($descripcion)?$descripcion:'';?>">
                </div>       


                <input type="submit" value="Buscar Propiedad" class="boton-buscar">
            </fieldset>
        </form>

        <!--Se le pide al usuario el número de productos por página-->
        <form class="paginado">
            <fieldset>
                <legend style="color: white;">Productos por página: </legend>
                <select name="anuncios">
                    <option <?php echo $ppp==3?'selected':''; ?> value=3>3</option>
                    <option <?php echo $ppp==6?'selected':''; ?> value=6>6</option>
                    <option <?php echo $ppp==10?'selected':''; ?> value=10>10</option>
                    <option <?php echo $ppp==20?'selected':''; ?> value=20>20</option>
                </select>
                <input type="submit" value="Cambiar" class="boton boton-verde">
            </fieldset>
        </form>

    </div>

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

                    <a href="anuncio.php/?id=<?php echo $fila['id']?>" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
            <?php } ?>
        </div> <!--.contenedor-anuncios-->
        
        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton-verde">Ver Todas</a>
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
    <script src="build/js/bundle.min.js"></script>
</body>
</html>