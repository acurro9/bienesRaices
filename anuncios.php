
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
    

    if ($_SERVER['REQUEST_METHOD']==="POST"){

        
        //El usuario nos dice el número de propiedades por página
        $ppp=mysqli_real_escape_string($db,$_POST['anuncios']);

        $totalPaginas=$cantPropiedades/$ppp;
    }
    ?> 
    <link rel="stylesheet" href="build/css/app.css">
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