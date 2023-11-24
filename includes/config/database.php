<?php
    function conectarDB(): mysqli{
        $db= new mysqli('localhost', 'root', '', 'bienesraices_crud');
        if (!$db){
            echo "Error: no se pudo conectar a la base de datos";
            echo "errno de depurción " . mysqli_connect_error();
            exit;
        }
        return $db;
    }
?>