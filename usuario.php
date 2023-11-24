<?php
//importar la conexión
require './includes/config/database.php';
$db=conectarDB();
//crear un email y un password
$email="admin@gmail.com";
$password= "1234";

//Se hashea el password
$passwordHash=password_hash($password, PASSWORD_DEFAULT);
//query para crear el usuario
$query= "INSERT INTO usuarios (email, password) VALUES ('${email}', '${passwordHash}');";
//agregarlo a la bd
mysqli_query($db, $query);
?>