<?php 
    require './includes/app.php';
    incluirTemplate('header');    
    $db=conectarDB();
    $errores=[];

    //validación del formulario
    if($_SERVER['REQUEST_METHOD']==='POST'){

        //sanitizamos datos
        $email=mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password=mysqli_real_escape_string($db, $_POST['password']);
        //comprobamos errores
        if(!$email){
            $errores[]="El email es obligatorio o no es válido";
        }

        if(!$password){
            $errores[]="El password es obligatorio";
        }
        //en caso de no haber errores
        if(empty($errores)){
            //revisar si el usuario existe
            $query="SELECT * FROM usuarios WHERE  email='${email}'";
            $resultado= mysqli_query($db, $query);
            if ($resultado->num_rows){
                //revisar si el password es correcto
                $usuario=mysqli_fetch_assoc($resultado);
                //nos devolverá true o false en el caso de que el password guardado en la bd sea igual al pasado por post
                $auth=password_verify($password, $usuario["password"]);
                //var_dump($auth);
                if($auth){
                    //el usuario está autentificado
                    session_start();
                    //llenamos los datos de la sesión
                    $_SESSION["usuario"]=$usuario["email"];
                    $_SESSION["login"]=true;
                    header('Location: /admin');
                }else{
                    $errores[]= "El password es incorrecto";
                }            
            }else{
                $errores[]="El usuario no existe";
            }

        }
    }

    foreach($errores as $error){ 
?>

    <div class="alerta error">
        <?php echo $error;?>
    </div>

<?php
    }
?>


<form method="POST" class="formulario" >
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" id="password" required>

        </fieldset>
        <input type="submit" value="Iniciar sesión" class="boton boton-verde">
</form>

<?php
    incluirTemplate("footer");
?>