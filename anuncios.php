<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body> 
    
<?php
    
    require './includes/funciones.php';
    incluirTemplate('header');    

    $db= mysqli_connect('localhost', 'root', '', 'bienesraices_crud');
    $consulta="SELECT count(*) FROM propiedades group by id;";
    $data=mysqli_query($db,$consulta);
    if(mysqli_num_rows($data) > 0){
        if ($_SERVER['REQUEST_METHOD']==="POST"){

            $ppp=mysqli_real_escape_string($db,$_POST['anuncios']);
            
    
        }
    }
    
    ?> 
    <form action="" class="paginado">
        <fieldset>
            <legend>Productos por página: </legend>
            <select name="anuncios">
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="6">6</option>
                <option value="10">10</option>
                <option value="20">20</option>
            </select>
            <input type="submit" value="Cambiar" class="boton boton-verde">
        </fieldset>
    </form>

    <main class="contenedor seccion">


        <?php  
            include './includes/templates/anuncios.php';
        ?>
        
        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton-verde">Ver Todas</a>
        </div>
        

        
    </main>
    <?php 
        include './includes/templates/footer.php';
    ?>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>