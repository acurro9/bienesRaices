<!-- Crear viejo -->
<?php
require '../../includes/app.php';
incluirTemplate('header');
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

// Proteger esta ruta.
//estaAutenticado();

$consulta = "SELECT * FROM vendedores";
$result = mysqli_query($db, $consulta);

// Validar 

$errores = Propiedad::getErrores();
$propiedad= new Propiedad();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad=new Propiedad($_POST);

    $carpetaImagenes = '../../imagenes/';

    if (!is_dir($carpetaImagenes)) {
        mkdir($carpetaImagenes);
    }
    $nombreImagen = md5(uniqid(rand(), true)).".jpg";

    if($_FILES['imagen']['tmp_name']){
        //Realiza resize
        $image= Image::make($_FILES['imagen']['tmp_name']);
        $image->fit(800,600);
        $propiedad->setImagen($nombreImagen);
    }


    $errores= $propiedad->validar(); 

    // El array de errores esta vacio
    if (empty($errores)) {
        //Subir la imagen
        $image->save($carpetaImagenes.$nombreImagen);
        //guardar en la bd
        $resultado= $propiedad->guardar();
        
        if ($resultado) {
            header('Location:/admin/index-php?resultado=1');
        }
    }
}
?>
<main class="contenedor section">
    <h1>Crear Propiedades</h1>
    <?php foreach($errores as $error){ ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php } ?>
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear propiedad" class="boton boton-verde">
    </form>

    <a href="/admin/index.php" class="boton boton-verde">Volver</a>
</main>

<?php
    incluirTemplate('footer');
?>

