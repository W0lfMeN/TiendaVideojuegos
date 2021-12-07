<?php
    session_start();

    require dirname(__DIR__,2)."/vendor/autoload.php";
    use TiendaVideojuegos\{Tiendas,Videojuegos};

    $exito=true; //Variable que controla si todos los campos introducidos son correctos

    function comprobarCampos($nombre, $valor){
        global $exito;

        if(strlen($valor)==0){
            $_SESSION[$nombre]="Error, el campo $nombre no puede estar vacío!!";
            $exito=false;
        }
    }

    if(isset($_POST['btnCrear'])){
        //Recogemos los datos
        $nombre=trim(ucfirst($_POST['nombre']));
        $vid=$_POST['videojuego_id'];

        comprobarCampos("nombre", $nombre);

        if($exito==true){
            //Todo está correcto, creamos el videojuego
            (new Tiendas)->setNombre($nombre)->setVideojuego_id($vid)->create();

            //Variable de session para el index.php
            $_SESSION['mensaje']="Tienda creada correctamente";

            //Volvemos al index
            header('Location:index.php');
        }else{
            //Recargamos la pagina para ver los errores
            header("Location: ".$_SERVER['PHP_SELF']);
        }
    }else{
        //Mostramos el formulario
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
    <title>Crear tienda</title>
</head>
<body style="background-color:#ffebcd">
    <h3 class="text-center">Nueva Tienda</h3>
    <div class="container mt-2">
        <div class="bg-success p-4 text-white rounded shadow-lg mx-auto" style="width:48rem">
            <form name="videojuego" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                <div class="mb-3">
                    <label for="n" class="form-label">Nombre de la tienda</label>
                    <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre">

                    <?php
                        if(isset($_SESSION['nombre'])){
                            echo "<p class='text-danger' mt-1>{$_SESSION['nombre']}</p>";
                            unset($_SESSION['nombre']);
                        }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="v" class="form-label">Videojuego estrella</label>
                    <select class="form-select" name="videojuego_id" id="v">
                        <?php
                            $videojuegos=(new Videojuegos)->readAll();

                            //Como readAll devuelve el saco $stmt, lo tratamos como un array con fetchAll y lo vamos recorriendo
                            foreach($videojuegos->fetchAll(PDO::FETCH_OBJ) as $item){
                                echo "<option value='{$item->id}'>{$item->nombre}</option>";
                            }
                        ?>
                    </select>
                </div>
                

                <div>
                    <button type="submit" name="btnCrear" class="btn btn-primary"><i class="fas fa-save"></i> Añadir</button>
                    <button type="reset" class="btn btn-warning"><i class="fas fa-broom"></i> Limpiar</button>
                    <a href="index.php" class="btn btn-secondary"><i class="fas fa-home"></i> Volver</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php } ?>