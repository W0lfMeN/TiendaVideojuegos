<?php
    session_start();

    require dirname(__DIR__,2)."/vendor/autoload.php";
    use TiendaVideojuegos\Videojuegos;

    $exito=true; //Variable que controla si todos los campos introducidos son correctos

    function comprobarCampos($nombre, $valor){
        global $exito;

        if(strlen($valor)==0){
            $_SESSION[$nombre]="Error, el campo $nombre no puede estar vacío!!";
            $exito=false;
        }
    }

    //Nos dirá si el tipo de archivo es de una imagen o no
    function isImagen($tipoArchivo){
        $tipos = ['image/gif', 'image/png', 'image/jpeg', 'image/bmp', 'image/webp'];
        return in_array($tipoArchivo, $tipos);
    }

    if(isset($_POST['btnCrear'])){
        //Recogemos los datos
        $nombre=trim(ucfirst($_POST['nombre']));
        $descripcion=trim(ucfirst($_POST['descripcion']));
        $fecha=$_POST['fecha'];
        $imagen;

        comprobarCampos("nombre", $nombre);
        comprobarCampos("descripcion", $descripcion);
        comprobarCampos("fecha", $fecha);

        //COMPROBAMOS LA IMAGEN
        //1. Vemos si se ha subido imagen
        if(is_uploaded_file($_FILES['img']['tmp_name'])){
            //Se ha subido algo, vemos si es una imagen
            if(isImagen($_FILES['img']['type'])){
                //He subido una imagen

                $nombreImg=$nombre."_".$fecha."_".$_FILES['img']['name'];

                //Movemos la imagen
                if(move_uploaded_file($_FILES['img']['tmp_name'], dirname(__DIR__, 1)."/img/$nombreImg")){

                    $imagen="../img/$nombreImg";
                    
                    //Si llega aqui es que la imagen se ha movido correctamente

                }else{
                    //No se ha podido mover la imagen
                    $_SESSION['imagen']="No se ha podido mover la imagen!!";
                    $exito=false;
                }
            }else{
                //Lo que se ha subido no es una imagen
                $_SESSION['imagen']="No se ha subido una imagen!!";
                $exito=false;
            }

        }else{
            //No se ha subido nada, guardamos la imagen por defecto
            $RUTA_IMG="../img/default.png";
            $imagen=$RUTA_IMG;
        }

        if($exito==true){
            //Todo está correcto, creamos el videojuego
            (new Videojuegos)->setNombre($nombre)->setDescripcion($descripcion)->setFecha($fecha)->setImg($imagen)->create();

            //Variable de session para el index.php
            $_SESSION['mensaje']="Videojuego creado correctamente";

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
    <title>Crear videojuego</title>
</head>
<body style="background-color:#ffebcd">
    <h3 class="text-center">Nuevo videojuego</h3>
    <div class="container mt-2">
        <div class="bg-success p-4 text-white rounded shadow-lg mx-auto" style="width:48rem">
            <form name="videojuego" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="n" class="form-label">Nombre del videojuego</label>
                    <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre">

                    <?php
                        if(isset($_SESSION['nombre'])){
                            echo "<p class='text-danger' mt-1>{$_SESSION['nombre']}</p>";
                            unset($_SESSION['nombre']);
                        }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="d" class="form-label">Descripcion</label>
                    <textarea class="form-control" id="d" rows="2" name="descripcion" placeholder="Descripcion"></textarea>

                    <?php
                        if(isset($_SESSION['descripcion'])){
                            echo "<p class='text-danger' mt-1>{$_SESSION['descripcion']}</p>";
                            unset($_SESSION['descripcion']);
                        }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="f" class="form-label">Fecha de lanzamiento</label>
                    <input type="date" class="form-control" id="f" name="fecha">

                    <?php
                        if(isset($_SESSION['fecha'])){
                            echo "<p class='text-danger' mt-1>{$_SESSION['fecha']}</p>";
                            unset($_SESSION['fecha']);
                        }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Caratula</label>
                    <input class="form-control" type="file" id="file" name="img">

                    <?php
                        if(isset($_SESSION['imagen'])){
                            echo "<p class='text-danger' mt-1>{$_SESSION['imagen']}</p>";
                            unset($_SESSION['imagen']);
                        }
                    ?>
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