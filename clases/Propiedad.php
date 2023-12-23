<?php

namespace App;

class Propiedad extends ActiveRecord {

    // Base DE DATOS
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];
    
    protected static $errores=[];
    protected static $db;
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }
    public static function setDB($database){
        self::$db = $database;
    }

    public function validar() {

        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->precio) {
            self::$errores[] = 'El Precio es Obligatorio';
        }

        if( strlen( $this->descripcion ) < 50 ) {
            self::$errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$this->habitaciones) {
            self::$errores[] = 'El Número de habitaciones es obligatorio';
        }
        
        if(!$this->wc) {
            self::$errores[] = 'El Número de Baños es obligatorio';
        }

        if(!$this->estacionamiento) {
            self::$errores[] = 'El Número de lugares de Estacionamiento es obligatorio';
        }
        
        if(!$this->vendedores_id) {
            self::$errores[] = 'Elige un vendedor';
        }

        if(!$this->imagen ) {
            self::$errores[] = 'La Imagen es Obligatoria';
        }

        return self::$errores;
    }
    public function guardar() {
        if(!is_null($this->id)) {
            // actualizar
            $resultado=$this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado=$this->crear();
        }
        return $resultado;
    }
    public function crear(){
        //Sanitizar los datos
        $atributos=$this->sanitizarAtributos();
        //insertar en la base de datos
       

        $query = "INSERT INTO propiedades (";
        $query.=join(',', array_keys($atributos));
        $query.=") VALUES ('";
        $query.=join("', '",array_values($atributos));
        $query.= " ' ) ";
        // debuguear($query);
         $resultado=self::$db->query($query);
         return $resultado;
       
    }
    //identifica y une los atributos de la bd con sus valores en forma de vector
    public function atributos(){
        $atributos=[];
        foreach(self::$columnasDB as $columna){
            if ($columna==='id') continue;
            $atributos[$columna]=$this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos(){
        $atributos=$this->atributos();
        $sanitizado=[];
        //este vector se recorre como asociativo
        foreach ($atributos as $key=>$value){
            $sanitizado[$key]= self::$db->escape_string($value);
        }
        
        return $sanitizado;
    }
    //Validaciones 
    public static function getErrores(){ return self::$errores; }

    public function setImagen($imagen){
        if ($imagen){
            $this->imagen=$imagen;
            
        }

    }
    public static function all(){
        $query="SELECT * FROM propiedades;";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function consultarSQL($query){
        //Consultar la base de datos
        $resultado=self::$db->query($query);
     

        //iterar los resultados
        $array=[];
        while ($registro=$resultado->fetch_assoc()){
            $array[]=self::crearObjeto($registro);

        }
        //liberar la memoria
        $resultado ->free();
        //devolver resultados
        return $array;
    }
    protected static function crearObjeto($registro){
            $objeto=new self;
            
            foreach ($registro as $key =>$value){
        
                if (property_exists($objeto,$key)){
                    $objeto->$key=$value;
                }
            }
            return $objeto;
    }
    //No funciona
    public function eliminar($id){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ${id};";
        $resultado = self::$db->query($query);

        return $resultado ;
        // debuguear($query);
    }
    public function borrarImagen(){

        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        
        }
    }
     // Busca un registro por su id
     public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id};";

        $resultado = self::consultarSQL($query);

        return array_shift( $resultado ) ;
    }
}