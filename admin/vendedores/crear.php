<?php
    require '../../includes/app.php';
    incluirTemplate('header');

    $auth=estaAutenticado();
    if(!$auth){
        header('Location: /');
    }
    
    $db=conectarDB();

    //Se crea un vector para los errores
    $errores=[];
    //Se inicializan las variables vacias
    $nombre='';
    $apellidos='';
    $telefono='';

    if ($_SERVER['REQUEST_METHOD']==="POST"){
        $nombre=mysqli_real_escape_string($db, $_POST['nombre']);
        $apellidos=mysqli_real_escape_string($db,$_POST['apellidos']);
        $telefono=mysqli_real_escape_string($db,$_POST['telefono']);
        
        //Comprobación de los datos
        if(!$nombre){
            $errores[]="Debes añadir el nombre";
        }
        if(!$apellidos){
            $errores[]="Debes añadir los apellidos";
        }
        if(!$telefono){
            $errores[]="Debes añadir el número de teléfono";
        }
                
        if(empty($errores)){

            $query="INSERT INTO vendedores (nombre, apellidos, telefono) VALUES ('$nombre', '$apellidos', '$telefono')";
            //echo $query;
            $resultado=mysqli_query($db,$query);
            if ($resultado) {
                header('Location:/admin/indexVend.php/?resultado=1');
            }

        }
    }
?>

<main class="contenedor section">
    <h1>Crear Vendedores</h1>

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" placeholder="Nombre vendedor" name="nombre" value="">

            <label for="apellidos">Apellidos: </label>
            <input type="text" id="apellidos" placeholder="Apellidos vendedor" name="apellidos" value="">
            
            <label for="telefono">Teléfono: </label>
            <input type="tel" id="telefono" placeholder="Número de teléfono" name="telefono" value="">
        </fieldset>

        <input type="submit" value="Crear vendedor" class="boton boton-verde">
    </form>

    <a href="/admin/indexVend.php" class="boton boton-verde">Volver</a>
</main>

<?php
    incluirTemplate('footer');
?>