<?php

    require 'funciones.php';
    require 'config/database.php';
    require __DIR__.'\..\vendor\autoload.php';

    use App\Propiedad;

    $db=conectarDb();
    Propiedad::setDB($db);

?>