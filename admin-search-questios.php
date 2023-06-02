<?php
// Llamo a la conexión
include 'conexion.php';

// Variable para almacenar el índice de la pregunta
$indice = 1;

// Variable para almacenar el resultado de la búsqueda por índice
$preguntaEncontrada = null;

// Variables para controlar los filtros
$campoFiltrar = isset($_POST['campo_filtrar']) ? $_POST['campo_filtrar'] : '';
$valorFiltrar = isset($_POST['valor_filtrar']) ? $_POST['valor_filtrar'] : '';

// Variable para controlar el número de filas a mostrar
$numFilasAMostrar = 10;

// Variable para almacenar el número de filas totales en la tabla
$numFilasTotales = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM preguntas"));

// Variable para almacenar el número de páginas
$numPaginas = ceil($numFilasTotales / $numFilasAMostrar);

// Variable para almacenar la página actual
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Verificar si se hizo clic en el botón "Atrás"
$atras = isset($_GET['atras']) ? $_GET['atras'] : 0;
if ($atras) {
    $indiceInicio = ($paginaActual - 2) * $numFilasAMostrar;
    if ($indiceInicio < 0) {
        $indiceInicio = 0;
    }
}

// Calcular el índice de inicio y fin de las filas a mostrar
$indiceInicio = ($paginaActual - 1) * $numFilasAMostrar;
$indiceFin = $indiceInicio + $numFilasAMostrar;

// Construir la consulta SQL con los filtros
$query = "SELECT p.id_pregunta, p.texto_pregunta, p.respuesta_correcta, p.dificultad, c.nombre_categoria
          FROM preguntas p
          INNER JOIN categorias c ON p.id_categoria = c.id_categoria";

if ($campoFiltrar && $valorFiltrar) {
    // Agregar el filtro a la consulta
    $query .= " WHERE $campoFiltrar = '$valorFiltrar'";
}

$query .= " LIMIT $indiceInicio, $numFilasAMostrar";

$resultado = mysqli_query($conn, $query);

// Verifico si se ha enviado un índice por el formulario
if (isset($_POST['indice_buscar'])) {
    $indiceBuscar = $_POST['indice_buscar'];

    // Realizo la consulta para buscar la pregunta por el índice
    $queryBuscar = "SELECT p.id_pregunta, p.texto_pregunta, p.respuesta_correcta, p.dificultad, c.nombre_categoria
                    FROM preguntas p
                    INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                    WHERE p.id_pregunta = $indiceBuscar";
    $resultadoBuscar = mysqli_query($conn, $queryBuscar);

    // Verifico si se encontró la pregunta
    if (mysqli_num_rows($resultadoBuscar) > 0) {
        $preguntaEncontrada = mysqli_fetch_assoc($resultadoBuscar);
    }
}

// Procesar la eliminación de la pregunta si se ha proporcionado un delete_id válido
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Realizar la lógica de eliminación de la pregunta (ejemplo)
    $queryEliminar = "DELETE FROM preguntas WHERE id_pregunta = $delete_id";
    mysqli_query($conn, $queryEliminar);

    // Redirigir a la página actual para actualizar los resultados
    echo "<script>window.location.href = 'admin-search-questios.php';</script>";
    exit;
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
    <style>
        /* Estilos CSS adicionales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: white;
        }

        .contenedor {
            margin: 20px;
        }

        .formulario-buscar {
            margin-bottom: 20px;
        }

        .tabla-preguntas {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-preguntas th,
        .tabla-preguntas td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tabla-preguntas th {
            background-color: #33afe2;
        }

        .paginacion {
            margin-top: 20px;
        }

        .paginacion a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
        }

        .paginacion a.active {
            background-color: #33afe2;
            color: white;
        }

        .paginacion a:hover:not(.active) {
            background-color: #fff;
        }
    </style>
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

        <a href="profile-admin.html" class="btn-login"><button>VOLVER</button></a>
    </header>
    <div class="contenedor">
        <h2>Formulario de preguntas</h2><br><br>
        <form class="formulario-buscar" method="POST" action="">
            <label for="campo_filtrar">Campo a filtrar:</label>
            <select id="campo_filtrar" name="campo_filtrar">
                <option value="">Seleccionar campo</option>
                <option value="id_pregunta">ID de pregunta</option>
                <option value="texto_pregunta">Texto de pregunta</option>
                <option value="respuesta_correcta">Respuesta correcta</option>
                <option value="dificultad">Dificultad</option>
                <option value="id_categoria">ID de categoría</option>
            </select>
            <label for="valor_filtrar">Valor a filtrar:</label>
            <input type="text" id="valor_filtrar" name="valor_filtrar">
            <button type="submit">Filtrar</button>
        </form><br><br>

        <?php if ($preguntaEncontrada) : ?>
            <div class="resultado-busqueda">
                <h3>Resultado de la búsqueda:</h3>
                <p><strong>ID de pregunta:</strong> <?php echo $preguntaEncontrada['id_pregunta']; ?></p>
                <p><strong>Texto de pregunta:</strong> <?php echo $preguntaEncontrada['texto_pregunta']; ?></p>
                <p><strong>Respuesta correcta:</strong> <?php echo $preguntaEncontrada['respuesta_correcta']; ?></p>
                <p><strong>Dificultad:</strong> <?php
                $dificultad = $preguntaEncontrada['dificultad'];
                if ($dificultad == 1) {
                    echo 'baja';
                } elseif ($dificultad == 2) {
                    echo 'media';
                } elseif ($dificultad == 3) {
                    echo 'alta';
                }
                ?></p>
                <p><strong>Categoría:</strong> <?php echo $preguntaEncontrada['nombre_categoria']; ?></p>
            </div>
        <?php endif; ?>

        <table class="tabla-preguntas">
            <tr>
                <th>ID</th>
                <th>Texto de pregunta</th>
                <th>Respuesta correcta</th>
                <th>Dificultad</th>
                <th>ID de categoría</th>
                <th>Acciones</th>
            </tr>
            <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $fila['id_pregunta']; ?></td>
                    <td><?php echo $fila['texto_pregunta']; ?></td>
                    <td><?php echo $fila['respuesta_correcta']; ?></td>
                    <td><?php
                    $dificultad = $fila['dificultad'];
                    if ($dificultad == 1) {
                        echo 'baja';
                    } elseif ($dificultad == 2) {
                        echo 'media';
                    } elseif ($dificultad == 3) {
                        echo 'alta';
                    }
                    ?></td>
                    <td><?php echo $fila['nombre_categoria']; ?></td>
                    <td>
                        <a href="admin-edit-questions.php?id_pregunta=<?php echo $fila['id_pregunta']; ?>">Editar</a>
                        <a href="?delete_id=<?php echo $fila['id_pregunta']; ?>&pagina=<?php echo $paginaActual; ?>" onclick="return confirm('¿Estás seguro de eliminar esta pregunta?')">Eliminar</a>

                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="paginacion">
            <?php if ($paginaActual > 1) : ?>
                <a href="?pagina=<?php echo $paginaActual - 1; ?>">Atrás</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $numPaginas; $i++) : ?>
                <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $paginaActual) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($paginaActual < $numPaginas) : ?>
                <a href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>

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
