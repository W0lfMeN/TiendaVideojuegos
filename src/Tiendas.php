<?php

namespace TiendaVideojuegos;

use PDO;
use Faker;
use PDOException;

class Tiendas extends Conexion{
    private $nombre;
    private $videojuego_id;


    public function __construct(){
        parent::__construct();
    }

    //------------------CRUD-------------//
    public function create(){
        $q="insert into tienda (nombre, videojuego_id) values (:n, :vid)";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                'vid'=>$this->videojuego_id
            ]);
        }catch(PDOException $ex){
            die("Error al insertar la tienda: ".$ex->getMessage());
        }
    }

    public function read($id){
        $q="select * from tienda where id=:id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al leer la tienda: ".$ex->getMessage());
        }

        parent::$conexion=null;

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id){
        $q="update tienda set nombre=:n, videojuego_id=:vid where id=:id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':vid'=>$this->videojuego_id,
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al actualizar la tienda: ".$ex->getMessage());
        }

        parent::$conexion=null;
    }

    public function delete($id){
        $q="delete from tienda where id=:id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al borrar la tienda: ".$ex->getMessage());
        }

        parent::$conexion=null;
    }

    //-----------------OTROS METODOS---------//
    //Para comprobar si hay tiendas
    public function hayTiendas(){
        $q="select * from tienda";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al comprobar si hay tiendas: ".$ex->getMessage());
        }

        parent::$conexion=null;

        return ($stmt->rowCount()!=0); //True si es que hay algun videojuego
    }

    public function generarTiendas($cantidad){
        if(!$this->hayTiendas()){ //Si no hay tiendas las genera
            $faker=Faker\Factory::create('es_ES');
            
            $idVideojuegos=(new Videojuegos)->devolverIds();

            for($i=0;$i<$cantidad;$i++){
                $nombre=$faker->sentence(3);
                $videojuego_id=$idVideojuegos[array_rand($idVideojuegos, 1)];

                (new Tiendas)->setNombre($nombre)->setVideojuego_id($videojuego_id)->create();
            }
        }
    }

    //ReadAll
    public function readAll(){
        $q="select * from tienda order by nombre";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al leer todas las tiendas: ".$ex->getMessage());
        }

        parent::$conexion=null;

        return $stmt; //Como contiene mas de un objeto devolvemos la variable tal cual
    }

    /**
     * Set the value of videojuego_id
     *
     * @return  self
     */ 
    public function setVideojuego_id($videojuego_id)
    {
        $this->videojuego_id = $videojuego_id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}