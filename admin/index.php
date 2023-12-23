<?php 
    $resultado=$_GET['resultado'] ?? null;

    require '../includes/app.php';
    use App\Propiedad;
    
    incluirTemplate('header');

    $propiedades=Propiedad::all();

    // Proteger esta ruta.
    estaAutenticado();

    if ($_SERVER['REQUEST_METHOD']==='POST'){
        $id=$_POST['id_eliminar'];
        $propiedadD=new Propiedad($_POST);
        // echo "<pre>";
        // var_dump($propiedadD);
        // var_dump($id);
        // echo "</pre>";
        $resultado = $propiedadD->eliminar($id);
            //pasamos un resultado para poder mostrar un mensaje.
            if ($resultado){
                header('location: /admin?resultado=3');
        }
    }

?>
<main class="contenedor seccion">
    <h1>Administrador</h1>
    <?php if (intval($resultado)===1){ ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php } else if(intval($resultado)===2){ ?>
        <p class="alerta exito">Anuncio actualizado correctamente</p>
    <?php } else if(intval($resultado)===3){ ?>
        <p class="alerta exito">Anuncio borrado correctamente</p>
    <?php } ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde crear">Nueva propiedad</a>
    <a href="/admin/indexVend.php" class="boton boton-verde crear">Vendedores</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($propiedades as $propiedad):?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td>
                        <img src="/imagenes/<?php echo $propiedad->imagen; ?>" width="100" class="imagen-tabla">
                    </td>
                    <td>$ <?php echo $propiedad->precio; ?></td>
                    <td>
                    <form method="POST" onsubmit="return confirmEliminado()">
                        <input type="hidden" name="id_eliminar" value="<?php echo s($propiedad->id); ?>">
                        <input type="submit" class="boton boton-rojo-block" value="Borrar">
                    </form>
                
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton boton-verde">Actualizar</a>
                    </td>
                </tr>
                
                <?php endforeach; ?>
        </tbody>       
    </table>
</main>   
<script type="text/javascript">
        function confirmEliminado() {
            return window.confirm( '¿Seguro que quiere borrar la propiedad?' );
        }
    </script>
<?php 
    incluirTemplate('footer');
?>

