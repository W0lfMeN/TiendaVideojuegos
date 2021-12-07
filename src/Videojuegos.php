<?php
namespace TiendaVideojuegos;

use PDO;
use Faker;
use PDOException;

class Videojuegos extends Conexion{
    private $nombre;
    private $descripcion;
    private $fecha;
    private $img;

    public function __construct(){
        parent::__construct();
    }

    //------------CRUD--------------//
    public function create(){
        $q="insert into videojuego (nombre, descripcion, fecha, img) values (:n, :d, :f, :img)";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':d'=>$this->descripcion,
                ':f'=>$this->fecha,
                ':img'=>$this->img
            ]);
        }catch(PDOException $ex){
            die("Error al insertar el videojuego: ".$ex->getMessage());
        }

        parent::$conexion=null;
    }

    public function read($id){
        $q="select * from videojuego where id=:id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al leer el videojuego: ".$ex->getMessage());
        }

        parent::$conexion=null;

        return $stmt->fetch(PDO::FETCH_OBJ); //Como contiene un solo objeto lo devuelvo convertido ya
    }

    public function update($id){
        $q="update videojuego set nombre=:n, descripcion=:d, fecha=:f, img=:i where id=$id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':d'=>$this->descripcion,
                ':f'=>$this->fecha,
                ':i'=>$this->img
            ]);
        }catch(PDOException $ex){
            die("Error al actualizar el videojuego: ".$ex->getMessage());
        }

        parent::$conexion=null;
    }

    public function delete($id){
        $q="delete from videojuego where id=:id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al borrar el videojuego: ".$ex->getMessage());
        }

        parent::$conexion=null;
    }

    //-----------OTROS METODOS--------//

    //Para comprobar si hay videojuegos
    public function hayVideojuegos(){
        $q="select * from videojuego";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al comprobar si hay videojuegos: ".$ex->getMessage());
        }

        parent::$conexion=null;

        return ($stmt->rowCount()!=0); //True si es que hay algun videojuego
    }

    public function generarVideojuegos($cantidad){
        if(!$this->hayVideojuegos()){ //Si no hay videojuegos los genera
            $faker=Faker\Factory::create('es_ES');

            $rutaImgDefecto="../img/default.png"; //Puesto que se cargan en la carpeta public/videojuegos, la ruta parte de dicha carpeta
            
            for($i=0;$i<$cantidad;$i++){
                $nombre=$faker->sentence(3);
                $descripcion=$faker->text(30);
                $fecha=$faker->date(); //Genera una fecha con formato yyyy-mm-dd (el que admite mysql)
                $img=$rutaImgDefecto;

                (new Videojuegos)->setNombre($nombre)->setDescripcion($descripcion)->setFecha($fecha)->setImg($img)->create();
            }
        }
    }

    //ReadAll
    public function readAll(){
        $q="select * from videojuego order by nombre";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al leer todos los videojuegos: ".$ex->getMessage());
        }

        parent::$conexion=null;

        return $stmt; //Como contiene mas de un objeto devolvemos la variable tal cual
    }

    //Funcion que devuelve los ids de todos los videojuegos en un array
    public function devolverIds(){
        $q="select * from videojuego";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al devolver todos los ids: ".$ex->getMessage());
        }

        //Ahora metemos todos los ids en un array y lo devolvemos
        
        $ids=[];
        while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
            $ids[]=$fila->id;
        }

        parent::$conexion=null;
        return $ids;
    }

    public function devolverNombreVideojuego($id){
        $q="select * from videojuego where id=:id";
        $stmt=parent::$conexion->prepare($q);

        try{
            $stmt->execute([
                ':id'=>$id
            ]);
        }catch(PDOException $ex){
            die("Error al devolver el nombre del videojuego: ".$ex->getMessage());
        }

        $nombre=$stmt->fetch(PDO::FETCH_OBJ)->nombre; //Como la consulta devuelve una fila, obtenemos el nombre de la misma y lo retornamos
        parent::$conexion=null;
        return $nombre;
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

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */ 
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }
}