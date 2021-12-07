<?php
    session_start();
    require dirname(__DIR__,2)."/vendor/autoload.php";

    use TiendaVideojuegos\{Videojuegos, Tiendas};

    //Generamos las tiendas si no hay
    (new Tiendas)->generarTiendas(20);

    //Leemos todos los videojuegos
    $listaTiendas=(new Tiendas)->readAll();
    
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
    <title>Tiendas</title>
</head>
<body style="background-color:#ffebcd">
    <h3 class="text-center">Tiendas</h3>
    <div class="container mt-2">
        <!--Aqui va el mensaje tienda creada, borrada y actualizada -->
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

        <a href="ctienda.php" class="btn btn-info my-2"><i class="fas fa-plus"></i> Añadir tienda</a>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Videojuego Mas Vendido</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    while($item=$listaTiendas->fetch(PDO::FETCH_OBJ)){
                        $nombreVideojuego=(new Videojuegos)->devolverNombreVideojuego($item->videojuego_id);
                        echo <<< TXT
                        <tr>
                            <th scope="row">{$item->nombre}</th>
                            <td>{$nombreVideojuego}</td>
                            <td>
                                <form name='a' method='POST' action='btienda.php'>
                                <input type='hidden' name='id' value='{$item->id}'>
                                <a href='etienda.php?id={$item->id}' class='btn btn-warning'><i class='fas fa-edit'></i></a>
                                <button type='submit' class='btn btn-danger' onclick="return confirm('¿Desea borrar la tienda?')"><i class='fas fa-trash'></i></button>
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