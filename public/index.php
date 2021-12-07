<?php
    require dirname(__DIR__,1)."/vendor/autoload.php";
    use TiendaVideojuegos\Videojuegos;

    (new Videojuegos)->generarVideojuegos(20);

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
    <title>Tienda Videojuegos</title>
</head>
<body style="background-color:silver">

    <h3 class="text-center">Tiendas de videojuegos</h3>
    <div class="container mt-2">
        <a href="videojuegos/" class="btn btn-info"><i class="fas fa-book"></i> Gestionar Videojuegos</a>
        <a href="tiendas/" class="btn btn-info"><i class="fas fa-users-cog"></i> Gestionar Tiendas</a>
    </div>
</body>
</html>