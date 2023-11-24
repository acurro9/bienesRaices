<?php
    $id=$_GET['id'];

    require '../../includes/app.php';
    incluirTemplate('header');
    use App\Propiedad;


        // Proteger esta ruta.
        estaAutenticado();

    $id= filter_var($id, FILTER_VALIDATE_INT);
    if (!$id){
        header('Location: /admin');
    } else{
        
        $db=conectarDB();
        $consult="SELECT imagen, titulo, precio, habitaciones, wc, estacionamiento, descripcion FROM propiedades where id=$id;";
        $datos=mysqli_query($db,$consult);
        $errores=[];
    
        while ($fila=mysqli_fetch_row($datos)){
                $imagen=$fila[0]; 
                $titulo=$fila[1];
                $precio=$fila[2];
                $habitaciones=$fila[3];
                $wc=$fila[4];
                $estacionamiento=$fila[5];
                $descripcion=$fila[6];
            
        }
        if ($_SERVER['REQUEST_METHOD']==="POST"){
            $titulo=mysqli_real_escape_string($db, $_POST['titulo']);
            $precio=mysqli_real_escape_string($db,$_POST['precio']);
            $descripcion=mysqli_real_escape_string($db,$_POST['descripcion']);
            $habitaciones= mysqli_real_escape_string($db,$_POST['habitaciones']);
            $wc=mysqli_real_escape_string($db,$_POST['wc']);
            $estacionamiento=mysqli_real_escape_string($db,$_POST['estacionamiento']);
            $img=$_FILES['img'];
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
    
            $medida=1024;
            if (($img['size']/1024)>$medida){
                $errores[]="Reduzca el tamaño de la imagen, debe ser menor a". $medida."Kb.";
            }
            
            if(empty($errores)){
            
            //Se borra la imagen vieja y se sube la nueva
                if($img['name']){
                    $carpetaImagenes='../../imagenes/';
                    $ruta='../../imagenes/'.$imagen;
                    unlink($ruta);
                    $nombreImagen=md5(uniqid(rand(),true)).".jpg";
                    move_uploaded_file($img['tmp_name'], $carpetaImagenes.$nombreImagen);
                } else{
                    $nombreImagen=$imagen;
                }
                
                $query="UPDATE propiedades set titulo='$titulo', precio=$precio, descripcion='$descripcion', 
                            habitaciones=$habitaciones, wc=$wc, estacionamiento='$estacionamiento', imagen='$nombreImagen' where id=$id;";
                    $resultado=mysqli_query($db,$query);
                    if ($resultado) {
                        header('Location:/admin?resultado=2');
                        
                    }
                }
        }
    }
        ?>
        
        <main class="contenedor section">
            <h1>Actualizar</h1>
            <?php foreach($errores as $error){ ?>
                <div class="alerta error">
                <?php echo $error; ?>
            </div>

    <?php } ?>
            <form class="formulario" method="POST" action="/admin/propiedades/actualizar.php/?id=<?php echo $id?>" enctype="multipart/form-data">
        
                <fieldset>
                    <legend>Información General</legend>
                    <label for="titulo">Título: </label>
                    <input type="text" id="titulo" placeholder="Titulo propiedad" name="titulo" value="<?php echo $titulo;?>">
                    
                    <label for="precio">Precio: </label>
                    <input type="number" id="precio" placeholder="Precio propiedad" name="precio" value="<?php echo $precio;  ?>">
                    
                    <label for="img">Imagen: </label>
                    <img src="../../../imagenes/<?php echo $imagen ?>" alt="">
                    <input type="file" id="img" name="img" accept="image/jpeg, image/png">
        
                </fieldset>
                <fieldset>
                    <legend></legend>
                    <label for="habitaciones">Habitaciones: </label>
                    <input type="number" id="habitaciones" placeholder="Habitaciones propiedad" name="habitaciones" value="<?php echo $habitaciones;  ?>">
                    
                    <label for="wc">WC: </label>
                    <input type="number" id="wc" placeholder="Wc propiedad" name="wc" value="<?php echo $wc;  ?>">
                    
                    <label for="estacionamiento">Estacionamiento: </label>
                    <input type="text" id="estacionamiento" placeholder="Estacionamiento propiedad" name="estacionamiento" value="<?php echo $estacionamiento;  ?>">
                    
                    
                    <label for="descripcion">Descripción: </label>
                    <textarea type="text" id="descripcion" placeholder="Descripcion propiedad" name="descripcion" ><?php echo $descripcion;  ?></textarea>
                </fieldset>
                <input type="submit" value="Actualizar propiedad" class="boton boton-verde">
            </form>
            <a href="/admin/index.php" class="boton boton-verde">Volver</a>
        </main>
        
        <?php
            incluirTemplate('footer');
        ?>