<?php
    $id=$_GET['id'];

    require '../../includes/app.php';
    incluirTemplate('header');
    use App\Propiedad;
    $db=conectarDB();
    $consult="SELECT nombre, apellidos, telefono FROM vendedores where id=$id;";
    $datos=mysqli_query($db,$consult);

    while ($fila=mysqli_fetch_row($datos)){
            $nombre=$fila[0]; 
            $apellidos=$fila[1];
            $telefono=$fila[2];        
    }

    if ($_SERVER['REQUEST_METHOD']==="POST"){
        $nombre2=mysqli_real_escape_string($db, $_POST['nombre']);
        $apellidos2=mysqli_real_escape_string($db,$_POST['apellidos']);
        $telefono2=mysqli_real_escape_string($db,$_POST['telefono']);
        
            $query="UPDATE vendedores set nombre='$nombre2', apellidos='$apellidos2', telefono='$telefono2' where id=$id;";

            $resultado=mysqli_query($db,$query);
            if ($resultado) {
                header('Location:/admin/indexVend.php/?resultado=2');
            }

    }
?>

<main class="contenedor section">
    <h1>Actualizar Vendedores</h1>
    <form class="formulario" method="POST" action="/admin/vendedores/actualizar.php/?id=<?php echo $id?>" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" placeholder="Nombre vendedor" name="nombre" value="<?php echo $nombre ?>">

            <label for="apellidos">Apellidos: </label>
            <input type="text" id="apellidos" placeholder="Apellidos vendedor" name="apellidos" value="<?php echo $apellidos ?>">
            
            <label for="telefono">Teléfono: </label>
            <input type="tel" id="telefono" placeholder="Número de teléfono" name="telefono" value="<?php echo $telefono ?>">
        </fieldset>
        <input type="submit" value="Actualizar vendedor" class="boton boton-verde">
    </form>
    <a href="/admin/indexVend.php" class="boton boton-verde">Volver</a>
</main>

<?php
    incluirTemplate('footer');
?>