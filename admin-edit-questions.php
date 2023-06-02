<?php
// Llamo a la conexión
include 'conexion.php';

// Verifico si se proporcionó un id_pregunta en la URL
if (isset($_GET['id_pregunta'])) {
    $idPregunta = $_GET['id_pregunta'];

    // Consulta para obtener los datos de la pregunta por id_pregunta
    $query = "SELECT id_pregunta, texto_pregunta, opcion_1, opcion_2, opcion_3, opcion_4, respuesta_correcta, dificultad, id_categoria FROM preguntas WHERE id_pregunta = $idPregunta";
    $resultado = mysqli_query($conn, $query);

    // Verifico si se encontró la pregunta
    if (mysqli_num_rows($resultado) > 0) {
        $pregunta = mysqli_fetch_assoc($resultado);
    } else {
        // La pregunta no existe, puedes mostrar un mensaje de error o redirigir a otra página
        header('Location: admin-list-questions.php');
        exit();
    }
}

// Variable para almacenar el mensaje de estado
$mensaje = '';

// Verifico si se envió el formulario de edición
if (isset($_POST['guardar'])) {
    // Obtengo los datos del formulario
    $idPregunta = $_POST['id_pregunta'];
    $textoPregunta = $_POST['texto_pregunta'];
    $opcion1 = $_POST['opcion1'];
    $opcion2 = $_POST['opcion2'];
    $opcion3 = $_POST['opcion3'];
    $opcion4 = $_POST['opcion4'];
    $respuestaCorrecta = $_POST['respuesta_correcta'];
    $dificultad = $_POST['dificultad'];
    $idCategoria = $_POST['id_categoria'];

    // Validar si la dificultad es un número entero
    if (!is_numeric($dificultad)) {
        $mensaje = 'Error: La dificultad debe ser un número entero.';
    } else {
        // Obtener el valor de dificultadTexto según el número de dificultad
        if ($dificultad == 1) {
            $dificultadTexto = 'baja';
        } elseif ($dificultad == 2) {
            $dificultadTexto = 'media';
        } elseif ($dificultad == 3) {
            $dificultadTexto = 'alta';
        } else {
            // Valor inválido, mostrar un mensaje de error o realizar alguna acción apropiada
        }

        // Actualizar los datos de la pregunta en la base de datos
        $queryActualizar = "UPDATE preguntas SET texto_pregunta = '$textoPregunta', opcion_1 = '$opcion1', opcion_2 = '$opcion2', opcion_3 = '$opcion3', opcion_4 = '$opcion4', respuesta_correcta = '$respuestaCorrecta', dificultad = $dificultad, id_categoria = '$idCategoria' WHERE id_pregunta = '$idPregunta'";
        if (mysqli_query($conn, $queryActualizar)) {
            $mensaje = 'La pregunta se actualizó correctamente.';
            echo "<script>alert('La pregunta se actualizó correctamente.');</script>";
            echo "<script>window.location.href = 'admin-search-questios.php';</script>";
        } else {
            $mensaje = 'Error al actualizar la pregunta. Por favor, inténtalo nuevamente. Error: ' . mysqli_error($conn);
            echo "<script>alert('Error al actualizar la pregunta. Por favor, inténtalo nuevamente. Error: " . mysqli_error($conn) . "');</script>";
        }
        
    }
}

// Obtener las categorías
$queryCategorias = "SELECT id_categoria, nombre_categoria FROM categorias";
$resultadoCategorias = mysqli_query($conn, $queryCategorias);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://kit.fontawesome.com/7791b6ed55.js" crossorigin="anonymous"></script>
</head>

<body>
    <video autoplay muted loop class="video-fondo">
        <source src="mp4/Fondo mp4.mp4" type="video/mp4">
    </video>

    <!-- Header -->
    <header class="header">
        <!-- logo -->
        <div class="logo-header">
            <a>
                <img src="img/white_logo_game.png" alt="logo-header">
            </a>
        </div>

        <a href="admin-search-questios.php" class="btn-login"><button>VOLVER</button></a>
    </header>
    <div class="box-register">
        <h2>Editar Pregunta</h2><br><br>
        <form method="POST" action="">
            <input type="hidden" name="id_pregunta" value="<?php echo $pregunta['id_pregunta']; ?>">
            <label for="texto_pregunta">Texto de pregunta:</label>
            <input type="text" id="texto_pregunta" name="texto_pregunta" value="<?php echo $pregunta['texto_pregunta']; ?>"><br><br>
            <label for="opcion1">Opción 1:</label>
            <input type="text" id="opcion1" name="opcion1" value="<?php echo $pregunta['opcion_1']; ?>"><br><br>
            <label for="opcion2">Opción 2:</label>
            <input type="text" id="opcion2" name="opcion2" value="<?php echo $pregunta['opcion_2']; ?>"><br><br>
            <label for="opcion3">Opción 3:</label>
            <input type="text" id="opcion3" name="opcion3" value="<?php echo $pregunta['opcion_3']; ?>"><br><br>
            <label for="opcion4">Opción 4:</label>
            <input type="text" id="opcion4" name="opcion4" value="<?php echo $pregunta['opcion_4']; ?>"><br><br>
            <label for="respuesta_correcta">Respuesta correcta:</label><br><br>
            <div class="radio-group">
                <input type="radio" id="opcion1" name="respuesta_correcta" value="opcion1" <?php if ($pregunta['respuesta_correcta'] == 'opcion1') echo 'checked'; ?>>
                <label for="opcion1">Opcion1</label>

                <input type="radio" id="opcion2" name="respuesta_correcta" value="opcion2" <?php if ($pregunta['respuesta_correcta'] == 'opcion2') echo 'checked'; ?>>
                <label for="opcion2">Opcion2</label>

                <input type="radio" id="opcion3" name="respuesta_correcta" value="opcion3" <?php if ($pregunta['respuesta_correcta'] == 'opcion3') echo 'checked'; ?>>
                <label for="opcion3">Opcion3</label>

                <input type="radio" id="opcion4" name="respuesta_correcta" value="opcion4" <?php if ($pregunta['respuesta_correcta'] == 'opcion4') echo 'checked'; ?>>
                <label for="opcion4">Opcion4</label>
            </div><br><br>
            <label for="dificultad">Dificultad:</label>
            <select id="dificultad" name="dificultad">
                <option value="1" <?php if ($pregunta['dificultad'] == 1) echo 'selected'; ?>>Baja</option>
                <option value="2" <?php if ($pregunta['dificultad'] == 2) echo 'selected'; ?>>Media</option>
                <option value="3" <?php if ($pregunta['dificultad'] == 3) echo 'selected'; ?>>Alta</option>
            </select><br><br>
            <label for="id_categoria">ID de categoría:</label>
            <select id="id_categoria" name="id_categoria">
                <?php while ($categoria = mysqli_fetch_assoc($resultadoCategorias)): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>" <?php if ($categoria['id_categoria'] == $pregunta['id_categoria']) echo 'selected'; ?>>
                        <?php echo $categoria['nombre_categoria']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>
            <a class="btn-register"><button type="submit" name="guardar">Actualizar</button></a>
        </form>
    </div>

    <!-- Mostrar mensaje de estado -->
    <?php if ($mensaje !== ''): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

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
