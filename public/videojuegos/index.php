<?php
    session_start();
    require dirname(__DIR__,2)."/vendor/autoload.php";

    use TiendaVideojuegos\Videojuegos;

    //Leemos todos los videojuegos
    $listaVideojuegos=(new Videojuegos)->readAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Videojuegos</title>
</head>
<body style="background-color:#ffebcd">
    <h3 class="text-center">Videojuegos</h3>
    <div class="container mt-2">
        <!--Aqui va el mensaje juego creado, borrado y actualizado -->
        <?php
            if(isset($_SESSION['mensaje'])){
                echo <<< TXT
                <div class="alert alert-primary" role="alert">
                    {$_SESSION['mensaje']}
                </div>
                TXT;
                unset($_SESSION['mensaje']);
            }
        ?>

        <a href="cvideojuego.php" class="btn btn-info my-2"><i class="fas fa-plus"></i> Añadir videojuego</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha Lanzamiento</th>
                <th scope="col">Caratula</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    while($item=$listaVideojuegos->fetch(PDO::FETCH_OBJ)){
                        $date=new DateTime($item->fecha); //sacamos la fecha para despues cambiarle el formato
                        echo <<< TXT
                        <tr>
                            <th scope="row">{$item->nombre}</th>
                            <td>{$item->descripcion}</td>
                            <td>{$date->format('d-m-Y')}</td>
                            <td><img src='{$item->img}' width='40rem' height='40rem' class='img-thumbnail'></td>
                            <td>
                                <form name='a' method='POST' action='bvideojuego.php'>
                                <input type='hidden' name='id' value='{$item->id}'>
                                <a href='evideojuego.php?id={$item->id}' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                                <button type='submit' class='btn btn-danger' onclick="return confirm('¿Desea borrar el videojuego?')"><i class='fas fa-trash'></i></button>
                                </form>
                            </td>
                        </tr>
                        TXT;
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>