<?php
    define('FUNCIONES_URL', __DIR__ . "funciones.php");
    define('TEMPLATES_URL', __DIR__ . "/templates");

    function incluirTemplate($nombre, $inicio=false){
        include TEMPLATES_URL."\\${nombre}.php";
    }

    function estaAutenticado() {
        if(!$_SESSION['login']) {
            header ('Location: /');
        } 
    }

    function debuguear($variable){
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        exit;
    }
?>