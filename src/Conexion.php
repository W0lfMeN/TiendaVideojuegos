<?php
namespace TiendaVideojuegos;

use PDO;
use PDOException;

class Conexion{
    protected static $conexion;
    
    public function __construct(){
        if(self::$conexion==null){
            self::crearConexion();
        }
    }

    private static function crearConexion(){
        $fichero=dirname(__DIR__,1)."/.config";
        $opciones=parse_ini_file($fichero);

        $host=$opciones['host'];
        $usuario=$opciones['user'];
        $pass=$opciones['pass'];
        $bbdd=$opciones['dbname'];

        //creamos la dns
        $dns="mysql:host=$host;dbname=$bbdd;charset=utf8mb4";

        //iniciamos la conexion
        try{
            self::$conexion=new PDO($dns, $usuario, $pass);

            //Esta linea si estamos en desarrollo
            //self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            die("Error al conectar a crudpost: ".$ex->getMessage());
        }
    }
}