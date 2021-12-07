<?php
session_start();

if(!isset($_POST['id'])){
    header('Location:index.php');
    die();
}

require dirname(__DIR__,2)."/vendor/autoload.php";
use TiendaVideojuegos\Tiendas;

(new Tiendas)->delete($_POST['id']);
$_SESSION['mensaje']="Tienda borrada con exito";
header('Location:index.php');