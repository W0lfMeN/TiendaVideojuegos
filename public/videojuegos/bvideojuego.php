<?php
session_start();

if(!isset($_POST['id'])){
    header('Location:index.php');
    die();
}

require dirname(__DIR__,2)."/vendor/autoload.php";
use TiendaVideojuegos\Videojuegos;

//Leemos el videojuego haciendo uso de su id
$elVideojuego=(new Videojuegos)->read($_POST['id']);

//Antes de borrar el videojuego, borramos la imagen que tiene en caso de que sea distinta de la default
//Primero vemos si la imagen que tiene es la default
if(str_contains($elVideojuego->img, "default.png")) {
    //Si entra aqui quiere decir que es la imagen por defecto, no hacemos nada
}else{
    //SI entra aqui quiere decir que tiene una imagen diferente, la borramos
    unlink(dirname(__DIR__, 1)."/img/".basename($elVideojuego->img));
    // basename("/home/usuario/doc1.pdf") = doc1.pdf
}

(new Videojuegos)->delete($_POST['id']);
$_SESSION['mensaje']="Videojuego borrado con exito";
header('Location:index.php');

