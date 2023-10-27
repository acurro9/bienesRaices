<?php
    require '../../includes/config/database.php';
    require '../../includes/funciones.php';
    incluirTemplate('header');

    $auth=estaAutenticado();
    if(!$auth){
        header('Location: /');
    }
    
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

        //Comprobación de los datos
        if(!$titulo){
            $errores[]="Debes añadir un título";
        }
        if(!$precio){
            $errores[]="Debes añadir un precio";
        }
        if(!$habitaciones){
            $errores[]="Debes añadir un habitaciones";
        }
        if(!$wc){
            $errores[]="Debes añadir un wc";
        }
        if(!$estacionamiento){
            $errores[]="Debes añadir un estacionamiento";
        }
        if(strlen($descripcion)<50){
            $errores[]="Debes añadir un descripcion de mínimo 50 caracteres";
        }
        if(!$vendedores_id){
            $errores[]="Debes añadir un vendedor";
        }
        if (!$imagen['name']) {
            $errores[]="La imagen es obligatoria";
        }

        $medida=1024;
        if (($imagen['size']/1024)>$medida){
            $errores[]="Reduzca el tamaño de la imagen, debe ser menor a". $medida."Kb.";
        }
        
        if(empty($errores)){

            //Se crea la carpeta para las imagenes si no existe
            $carpetaImagenes='../../imagenes/';
            if (!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }
            $nombreImagen=md5(uniqid(rand(),true)).".jpg";

            $query="INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id)   
            VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion','$habitaciones','$wc','$estacionamiento', '$creado', '$vendedores_id')";
            //echo $query;
            $resultado=mysqli_query($db,$query);
            if ($resultado) {
                header('Location:/admin/index-php/?resultado=1');
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes.$nombreImagen);
            }

        }
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