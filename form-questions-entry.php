<?php
// Llamo a la conexión
include 'conexion.php';

// Variables para almacenar los valores del formulario
$pregunta = '';
$opcion1 = '';
$opcion2 = '';
$opcion3 = '';
$opcion4 = '';
$respuesta_correcta = '';
$dificultad = '';
$categoria = '';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $pregunta = $_POST['registro_pregunta'];
    $opcion1 = $_POST['registro_opcion1'];
    $opcion2 = $_POST['registro_opcion2'];
    $opcion3 = $_POST['registro_opcion3'];
    $opcion4 = $_POST['registro_opcion4'];
    $respuesta_correcta = $_POST['opcion-register'];
    $dificultad = $_POST['registro_dificultad'];
    $categoria = $_POST['registro_Categoria'];

    // Variable para verificar si todos los campos están completos
    $camposCompletos = true;

    // Verificar campos vacíos
    if (empty($pregunta) || empty($opcion1) || empty($opcion2) || empty($opcion3) || empty($opcion4) || empty($respuesta_correcta) || empty($dificultad) || empty($categoria)) {
        $camposCompletos = false;
        echo '<script>alert("Por favor, complete todos los campos.");</script>';
        echo '<script>history.back();</script>';
        exit;
    }

    // Verificar si se ha seleccionado una imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_tamano = $_FILES['imagen']['size'];

        // Validar el tipo de imagen
        $tipos_permitidos = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($imagen_tipo, $tipos_permitidos)) {
            echo '<script>alert("El tipo de archivo no es válido. Solo se permiten imágenes en formato JPEG, PNG o GIF.");</script>';
            echo '<script>history.back();</script>';
            exit;
        }

        // Ruta donde se guardará la imagen
        $ruta_destino = 'img/img-preguntas/' . time() . '_' . $imagen_nombre;

        // Mover la imagen a la carpeta de destino
        if (move_uploaded_file($imagen_tmp, $ruta_destino)) {
            // La imagen se ha cargado correctamente, puedes guardar la ruta en la base de datos o hacer lo que necesites
        } else {
            echo '<script>alert("Error al cargar la imagen.");</script>';
            echo '<script>history.back();</script>';
            exit;
        }
    }

    // Realizar la inserción en la base de datos solo si todos los campos están completos
    if ($camposCompletos) {
        // Consulta SQL sin imagen
        $sql = "INSERT INTO preguntas (texto_pregunta, opcion_1, opcion_2, opcion_3, opcion_4, respuesta_correcta, dificultad, id_categoria";
        
        // Agregar columna de imagen si se ha subido una
        if (!empty($_FILES['imagen']['name'])) {
            $sql .= ", imagen";
        }
        
        $sql .= ") VALUES ('$pregunta', '$opcion1', '$opcion2', '$opcion3', '$opcion4', '$respuesta_correcta', '$dificultad', '$categoria'";
        
        // Agregar valor de imagen si se ha subido una
        if (!empty($_FILES['imagen']['name'])) {
            $sql .= ", '$ruta_destino'";
        }
        
        $sql .= ")";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("La pregunta ha sido registrada exitosamente.");</script>';
        } else {
            echo '<script>alert("Error al registrar la pregunta: ' . $conn->error . '");</script>';
        }
    }
}

// Obtener opciones de categoría desde la base de datos
$sql_categorias = "SELECT * FROM categorias";
$resultado_categorias = $conn->query($sql_categorias);

// Generar las opciones de categoría para el combobox
$opciones_categorias = '';
if ($resultado_categorias->num_rows > 0) {
    while ($row = $resultado_categorias->fetch_assoc()) {
        $id_categoria = $row['id_categoria'];
        $nombre_categoria = $row['nombre_categoria'];
        $opciones_categorias .= "<option value=\"$id_categoria\">$nombre_categoria</option>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Preguntas</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://kit.fontawesome.com/7791b6ed55.js" crossorigin="anonymous"></script>
</head>

<body>
    <video autoplay muted loop class="video-fondo">
        <source src="mp4/Fondo mp4.mp4" type="video/mp4">
    </video>

    <!-- Header -->
    <div>
        <header class="header">

            <!-- logo -->
            <div class="logo-header">
                <a>
                    <img src="img/white_logo_game.png" alt="logo-header">
                </a>
            </div>

            <a href="profile-admin.html" class="btn-login"><button>VOLVER</button></a>

        </header>
    </div>

    <div class="box-register">

        <h1>Formulario Preguntas</h1>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validarFormulario()" enctype="multipart/form-data">

            <!-- Nombre -->
            <br><br>
            <label for="name-pregunta">Pregunta</label>
            <input type="text" name="registro_pregunta">

            <label for="name-registro_opcion1">Opcion 1</label>
            <input type="text" name="registro_opcion1">

            <label for="name-registro_opcion2">Opcion 2</label>
            <input type="text" name="registro_opcion2">

            <label for="name-registro_opcion3">Opcion 3</label>
            <input type="text" name="registro_opcion3">

            <label for="name-registro_opcion4">Opcion 4</label>
            <input type="text" name="registro_opcion4">

            <label for="dificultad-register">Dificultad</label><br><br>
            <div class="radio-group">

                <input type="radio" id="opcion1" name="registro_dificultad" value="1" required>
                <label for="baja">Baja</label>

                <input type="radio" id="opcion2" name="registro_dificultad" value="2">
                <label for="media">Media</label>

                <input type="radio" id="opcion3" name="registro_dificultad" value="3">
                <label for="alta">Alta</label>

            </div><br><br>

            <label for="opcion-register">Respuesta Correcta</label><br><br>
            <div class="radio-group">

                <input type="radio" id="opcion1" name="opcion-register" value="opcion1" required>
                <label for="opcion1">Opcion1</label>

                <input type="radio" id="opcion2" name="opcion-register" value="opcion2">
                <label for="opcion2">Opcion2</label>

                <input type="radio" id="opcion3" name="opcion-register" value="opcion3">
                <label for="opcion3">Opcion3</label>

                <input type="radio" id="opcion4" name="opcion-register" value="opcion4">
                <label for="opcion4">Opcion4</label>

            </div><br><br>
            
            <label for="registro_Categoria">Categoría</label>
            <select name="registro_Categoria">
            <option value="">Seleccione una categoría</option>
            <?php echo $opciones_categorias; ?>
            </select><br><br><br><br>
            
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen"><br><br>

            <input class="arrow-button" type="submit" value="">
        </form>

        <!-- Mensaje de éxito -->
        <div id="mensaje-exito" style="display: none;">La pregunta se ha registrado correctamente.</div>

    </div>
</body>

<body>

    <!-- Footer -->
    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box-footer">
                <figure>
                    <a href="https://www.upla.cl/portada/">
                        <img src="img/logoupla.png" alt="logo-footer">
                    </a>
                </figure>
            </div>
            <div class="box-footer">
                    <h2>Sobre Nosotros</h2>
                    <p>Acerca del juego</p>
                    <p>Texto</p>
            </div>
            <div class="box-footer">
                <h2>Siguenos</h2>
                <div class="red-social">
                    <a href="https://www.facebook.com/uplacomunica" class="fa fa-facebook"></a>
                    <a href="https://www.instagram.com/upla_comunica/?hl=es" class="fa fa-instagram"></a>
                    <a href="https://twitter.com/upla_comunica?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" class="fa fa-twitter"></a>
                    <a href="https://www.youtube.com/watch?v=1YDfEqp53yo" class="fa fa-youtube"></a>
                </div>
            </div>
        </div>
        <div class="grupo-2">
                <small>&copy; 2023 <b>Univers</b> Todos los Derechos Reservados.</small>
        </div>

    </footer>
</body>
</html>
