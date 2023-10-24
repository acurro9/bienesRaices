
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
    $cantPropiedades2=$data['contador'];
    //Por defecto los productos por pagina son 6 y la página es 1, si en la url está presente cambia
    $orden = 0;
    if (isset($_GET["orden"])) {
        $orden = $_GET["orden"];
    }
    $ppp = 6;
    if (isset($_GET["anuncios"])) {
        $ppp = $_GET["anuncios"];
    }
    $pagina = 1;
    if (isset($_GET["pagina"])) {
        $pagina = $_GET["pagina"];
    }
    $nombre="";
    if (isset($_GET["titulo"])){
        $nombre = $_GET["titulo"];
    }
    $precioMin="";
    if (isset($_GET["preciomin"])){
        $precioMin = $_GET["preciomin"];
    }
    $precioMax="";
    if (isset($_GET["preciomax"])){
        $precioMax = $_GET["preciomax"];
    }
    $descripcion="";
    if (isset($_GET["descripcion"])){
        $descripcion = $_GET["descripcion"];
    }
    $habitaciones="";
    if (isset($_GET["habitaciones"])){
        $habitaciones = $_GET["habitaciones"];
    }
    $wc="";
    if (isset($_GET["wc"])){
        $wc = $_GET["wc"];
    }
    $estacionamiento="";
    if (isset($_GET["estacionamiento"])){
        $estacionamiento = $_GET["estacionamiento"];
    }
    
    //Se coge el total de páginas redondeando hacia arriba
    $totalPaginas=ceil($cantPropiedades/$ppp);
    //Se calculan el limit y el offset
    $offset=($pagina-1)*$ppp;
    $limit= $ppp;
    //Se realiza la consulta a la base de datos
    if($orden==1){
        $consult="SELECT * FROM propiedades order by precio asc limit $limit offset $offset;";
    } else if($orden==2){
        $consult="SELECT * FROM propiedades order by precio desc limit $limit offset $offset;";
    } else if($orden==3){
        $consult="SELECT * FROM propiedades order by habitaciones asc limit $limit offset $offset;";
    } else{
        $consult="SELECT * FROM propiedades limit $limit offset $offset;";
    }
    $datos=mysqli_query($db,$consult);

    if ($_SERVER['REQUEST_METHOD']==="POST"){

        $nombre=mysqli_real_escape_string($db, $_POST['nombre']);
        $precioMin=mysqli_real_escape_string($db,$_POST['preciomin']);
        $precioMax=mysqli_real_escape_string($db,$_POST['preciomax']);
        $descripcion=mysqli_real_escape_string($db,$_POST['descripcion']);
        $habitaciones= mysqli_real_escape_string($db,$_POST['habitaciones']);
        $wc=mysqli_real_escape_string($db,$_POST['wc']);
        $estacionamiento=mysqli_real_escape_string($db,$_POST['estacionamiento']);

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

        if($orden==1){
            $busqueda="SELECT * from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento order by precio asc";
            $busqCantidad="SELECT count(*) as contador2 from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento order by precio asc";
        } else if($orden==2){
            $busqueda="SELECT * from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento order by precio desc;";
            $busqCantidad="SELECT count(*) as contador2 from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento order by precio desc;";
        } else if($orden==3){
            $busqueda="SELECT * from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento order by habitaciones asc;";
            $busqCantidad="SELECT count(*) as contador2 from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento order by habitaciones asc;";
        } else{
            $busqueda="SELECT * from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento;";
            $busqCantidad="SELECT count(*) as contador2 from propiedades where titulo like '%$nombre%' and precio between $precioMin and $precioMax and descripcion like '%$descripcion%' and habitaciones >= $habitaciones and wc >= $wc and estacionamiento >= $estacionamiento;";
        }
        $datos=mysqli_query($db,$busqueda);

        
        $datos2=mysqli_query($db,$busqCantidad);
        if($datos && $datos2){
            $data=mysqli_fetch_assoc($datos2);
            $cantPropiedades=$data['contador2'];
            $totalPaginas=1;
        }
    }
    function guardarValor($variable){
        if($variable==0 || $variable==1000000000000000000){
            return false;
        } else if (is_string($variable) && $variable != '%' && $variable!=""){
            return true;
        } else{
            return true;
        }
    }
    ?> 
    <link rel="stylesheet" href="build/css/app.css">

    <div class="prop">
        <!--Para la busqueda-->
        <form action="anuncios.php?orden=<?php echo $orden;?>" class="busqueda" method="POST">
            <fieldset class="busqueda">
                <legend>Buscar:</legend>
                <div class="buscar">
                    <label style="color: white;" for="nombre">Título: <?php echo guardarValor($nombre)?"<span>".$nombre."</span>":'';?></label>
                    <input type="text" id="nombre" name="nombre" placeholder="Titulo">
                </div>

                <div class="buscar">
                    <div class="mostrar">
                        <label for="precio">Precio: 
                            <?php echo guardarValor($precioMin)?"<br><span> Min: ".$precioMin."</span>":'';?>
                            <?php echo guardarValor($precioMax)?"<br><span> Max: ".$precioMax."</span>":'';?>
                        </label>
                    </div>
                    <div class="diferenciaPrecio">
                        <input type="number" id="preciomin" placeholder="Min. Precio" name="preciomin">
                        <input type="number" id="preciomax" placeholder="Max. Precio" name="preciomax">
                    </div>
                </div>
                <div class="buscar">
                    <label for="habitaciones">Min. Habitaciones:<?php echo guardarValor($habitaciones)?"<span>".$habitaciones."</span>":'';?> </label>
                    
                    <input type="number" id="habitaciones" placeholder="Min. Habitaciones" name="habitaciones">
                </div>

                <div class="buscar">
                    <label for="wc">Min. WC: <?php echo guardarValor($wc)?"<span>".$wc."</span>":'';?></label>
                    <input type="number" id="wc" placeholder="Min. WC" name="wc">
                </div>

                <div class="buscar">
                    <label for="estacionamiento">Min. Estacionamiento: <?php echo guardarValor($estacionamiento)?"<span>".$estacionamiento."</span>":'';?></label>
                    <input type="number" id="estacionamiento" placeholder="Min. Estacionamientos" name="estacionamiento">
                </div>

                <div class="">
                    <label for="descripcion">Descripción: <?php echo guardarValor($descripcion)?"<span>".$descripcion."</span>":'';?> </label>
                    <input type="text" id="descripcion" name="descripcion" placeholder="Descripción">
                </div>       

                <div class="botones">
                    <input type="submit" value="Buscar Propiedad" class="boton-buscar">
                    <?php 
                        if(guardarValor($nombre) || guardarValor($precioMin) || guardarValor($precioMax) || guardarValor($estacionamiento) || guardarValor($wc) || guardarValor($habitaciones) || guardarValor($descripcion)){
                            echo '<button class="boton-buscar">
                                <a href="./anuncios.php">Vaciar Campos</a>
                                </button>';
                        }
                    ?>
                    
                </div>
            </fieldset>
        </form>

        <!--Se le pide el usuario el orden de las propiedades-->
        <form action>
            <fieldset>
                <legend>Ordenar:</legend>
                <select name="orden" id="orden">
                    <option <?php echo $orden==0?'selected':''; ?> value="0"></option>
                    <option <?php echo $orden==1?'selected':''; ?> value="1">Precio Asc</option>
                    <option <?php echo $orden==2?'selected':''; ?> value="2">Precio Desc</option>
                    <option <?php echo $orden==3?'selected':''; ?> value="3">Nº de Habitaciones</option>

                </select>
                <input type="submit" value="Ordenar" class="boton boton-verde">
                
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
            <a href="anuncios.php?anuncios=<?php echo $cantPropiedades2+1;?>" class="boton-verde">Ver Todas</a>
        </div>
        <!--Para moverse entre las páginas-->
        <div class="pagComplete">
            <?php if($pagina>1){?>
                
            <a class="pag" href="/anuncios.php?anuncios=<?php echo $ppp;?>&pagina=<?php echo $pagina-1?>&orden=<?php echo $orden?>"><</a><?php } ?>
            <?php for($i=0; $i<$totalPaginas; $i++){ ?>
                <a class="pag" href="/anuncios.php?anuncios=<?php echo $ppp;?>&pagina=<?php echo $i+1;?>&orden=<?php echo $orden?>" <?php echo $pagina==$i+1?'style="color: #71B100; font-weight: 800;"':'';?>><?php echo $i+1;?></a>
                <?php } 
                if($pagina<$totalPaginas){
                    ?>
            <a class="pag" href="/anuncios.php?anuncios=<?php echo $ppp;?>&pagina=<?php echo $pagina+1?>&orden=<?php echo $orden?>">></a>
                    <?php } ?>
        </div>

    </main>
    <script src="build/js/bundle.min.js"></script>
</body>
</html>