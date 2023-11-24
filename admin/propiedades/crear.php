<!-- Crear viejo -->
<?php
    require '../../includes/app.php';
    incluirTemplate('header');
    use App\Propiedad;
    
    // Proteger esta ruta.
    estaAutenticado();
    
    $db=conectarDB();
    
    $consulta="SELECT * FROM vendedores;";
    $result=mysqli_query($db,$consulta);

    

    //Se crea un vector para los errores
    $errores=[];
    //Se inicializan las variables vacias
    $titulo='';
    $precio='';
    $descripcion='';
    $vendedores_id='';
    $habitaciones='';
    $wc='';
    $estacionamiento='';
    $imagen='';

    if ($_SERVER['REQUEST_METHOD']==="POST"){
        $titulo=mysqli_real_escape_string($db, $_POST['titulo']);
        $precio=mysqli_real_escape_string($db,$_POST['precio']);
        $descripcion=mysqli_real_escape_string($db,$_POST['descripcion']);
        $habitaciones= mysqli_real_escape_string($db,$_POST['habitaciones']);
        $wc=mysqli_real_escape_string($db,$_POST['wc']);
        $estacionamiento=mysqli_real_escape_string($db,$_POST['estacionamiento']);
        $vendedores_id=mysqli_real_escape_string($db,$_POST['vendedor']);
        
        $imagen=$_FILES['imagen'];
        $creado=date('Y/m/d');


        $medida=1024;
        if (($imagen['size']/1024)>$medida){
            $errores[]="Reduzca el tamaño de la imagen, debe ser menor a". $medida."Kb.";
        }
        
        if(empty($errores)){
            $propiedad=new Propiedad($_POST);

            
            $propiedad->crear();
            //Se crea la carpeta para las imagenes si no existe
            $carpetaImagenes='../../imagenes/';
            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }
            $nombreImagen=md5(uniqid(rand(),true)).".jpg";

                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);

        }

        // if($_SERVER['REQUEST_METHOD']==='POST'){
        //     $propiedad=new Propiedad($_POST);
        //     debuguear($propiedad);
            
        //     $propiedad->crear();
        // }
    }


    //echo "<pre>";
    //var_dump($_SERVER);
    //var_dump($_POST['titulo']);
    //echo "</pre>";
?>
<main class="contenedor section">
    <h1>Crear Propiedades</h1>
    <?php foreach($errores as $error){ ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php } ?>
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título: </label>
            <input type="text" id="titulo" placeholder="Titulo propiedad" name="titulo" value="<?php echo $titulo;?>">

            <label for="precio">Precio: </label>
            <input type="number" id="precio" placeholder="Precio propiedad" name="precio" value="<?php echo $precio;  ?>">
            
            <label for="habitaciones">Habitaciones: </label>
            <input type="number" id="habitaciones" placeholder="Habitaciones propiedad" name="habitaciones" value="<?php echo $habitaciones;  ?>">

            <label for="wc">WC: </label>
            <input type="number" id="wc" placeholder="Wc propiedad" name="wc" value="<?php echo $wc;  ?>">

            <label for="estacionamiento">Estacionamiento: </label>
            <input type="number" id="estacionamiento" placeholder="Estacionamiento propiedad" name="estacionamiento" value="<?php echo $estacionamiento;  ?>">

            <label for="imagen">Imagen: </label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
            
            <label for="descripcion">Descripción: </label>
            <textarea type="text" id="descripcion" placeholder="Descripcion propiedad" name="descripcion" ><?php echo $descripcion;  ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor">
                <option value="">--Seleccione--</option>
                <?php while ($vendedor=mysqli_fetch_assoc($result)){?>
                    <option <?php echo $vendedores_id==$vendedor['id']?'selected':''; ?> value="<?php echo $vendedor['id'];?>">
                        <?php  echo $vendedor['nombre']. " ".$vendedor['apellidos'];  ?>
                    </option>
                <?php } ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>
</main>

<?php
    incluirTemplate('footer');
?>

<!-- Crear nuevo -->
<?php 
    // require '../../includes/app.php';
    // use App\Propiedad;
    // use App\Vendedor;

    // estaAutenticado();

    // // Importar Intervention Image
    // use Intervention\Image\ImageManagerStatic as Image;

    // // Crear el objeto
    // $propiedad = new Propiedad;

    // // Consultar para obtener los vendedores
    // $vendedores = Vendedor::all();

    // // Arreglo con mensajes de errores
    // $errores = Propiedad::getErrores();

    // // Ejecutar el código después de que el usuario envia el formulario
    // if($_SERVER['REQUEST_METHOD'] === 'POST') {

    //     /** Crea una nueva instancia */
    //     $propiedad = new Propiedad($_POST['propiedad']);

    //     // Generar un nombre único
    //     $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

    //     // Setear la imagen
    //     // Realiza un resize a la imagen con intervention
    //     if($_FILES['propiedad']['tmp_name']['imagen']) {
    //         $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
    //         $propiedad->setImagen($nombreImagen);
    //     }
        
    //     // Validar
    //     $errores = $propiedad->validar();

    //     if(empty($errores)) {
        
    //         // Crear la carpeta para subir imagenes
    //         if(!is_dir(CARPETA_IMAGENES)) {
    //             mkdir(CARPETA_IMAGENES);
    //         }

    //         // Guarda la imagen en el servidor
    //         $image->save(CARPETA_IMAGENES . $nombreImagen);

    //         // Guarda en la base de datos
    //         $propiedad->guardar();
    //     }
    // }

    // incluirTemplate('header');
?>

    <!-- <main class="contenedor seccion">
        <h1>Crear</h1>

        

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php //foreach($errores as $error): ?>
        <div class="alerta error">
            <?php //echo $error; ?>
        </div>
        <?php //endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <?php //include '../../includes/templates/formulario_propiedades.php'; ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
        
    </main> -->

<?php 
    // incluirTemplate('footer');
?> 

