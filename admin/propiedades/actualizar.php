<?php
    $id=$_GET['id'];

    require '../../includes/funciones.php';
    incluirTemplate('header');
    require '../../includes/config/database.php';
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

    if ($_SERVER['REQUEST_METHOD']==="POST"){
        $titulo=mysqli_real_escape_string($db, $_POST['titulo']);
        $precio=mysqli_real_escape_string($db,$_POST['precio']);
        $descripcion=mysqli_real_escape_string($db,$_POST['descripcion']);
        $habitaciones= mysqli_real_escape_string($db,$_POST['habitaciones']);
        $wc=mysqli_real_escape_string($db,$_POST['wc']);
        $estacionamiento=mysqli_real_escape_string($db,$_POST['estacionamiento']);
        
            $query="UPDATE propiedades set titulo='$titulo', precio=$precio, descripcion='$descripcion', 
                    habitaciones=$habitaciones, wc=$wc, estacionamiento='$estacionamiento' where id=$id;";
    echo $query;
            $resultado=mysqli_query($db,$query);
            if ($resultado) {
                header('Location:/admin?resultado=2');
            }

    }
?>

<main class="contenedor section">
    <h1>Actualizar</h1>
    <form class="formulario" method="POST" action="/admin/propiedades/actualizar.php/?id=<?php echo $id?>" enctype="multipart/form-data">

        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título: </label>
            <input type="text" id="titulo" placeholder="Titulo propiedad" name="titulo" value="<?php echo $titulo;?>">
            
            <label for="precio">Precio: </label>
            <input type="number" id="precio" placeholder="Precio propiedad" name="precio" value="<?php echo $precio;  ?>">
            
            <label for="imagen">Imagen: </label>
            <img src="../../../imagenes/<?php echo $imagen ?>" alt="">

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