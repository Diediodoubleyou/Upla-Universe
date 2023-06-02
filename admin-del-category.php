<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <form action="" method="POST">
            <!-- Combo box de categorías -->
            <label for="categoria">Seleccionar categoría:</label><br><br>
            <select name="categoria" id="categoria">
                <option value="" selected disabled>Seleccionar</option>
                <?php
                // Incluir el archivo de conexión a la base de datos
                include 'conexion.php';

                // Obtener las categorías desde la base de datos
                $query = "SELECT id_categoria, nombre_categoria FROM categorias";
                $result = $conn->query($query);

                // Iterar sobre los resultados y mostrar las opciones del combobox
                while ($row = $result->fetch_assoc()) {
                    $idCategoria = $row['id_categoria'];
                    $nombreCategoria = $row['nombre_categoria'];
                    echo '<option value="' . $idCategoria . '">' . $nombreCategoria . '</option>';
                }

                // Cerrar la conexión a la base de datos
                $conn->close();
                ?>
            </select>

            <!-- Botón de borrar -->
            <div class="btn-register" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                <button type="submit" name="borrar" onclick="return confirm('¿Estás seguro de borrar el registro?'); redirectToCurrentPage();">Borrar</button>
            </div>
        </form>
    </div>

    <?php
    // Verificar si se ha enviado el formulario para borrar
    if (isset($_POST['borrar'])) {
        // Verificar si se ha seleccionado una categoría
        if (!empty($_POST['categoria'])) {
            // Incluir el archivo de conexión a la base de datos
            include 'conexion.php';

            // Obtener la categoría seleccionada
            $categoriaSeleccionada = $_POST['categoria'];

            // Realizar la consulta para borrar la categoría
            $queryBorrar = "DELETE FROM categorias WHERE id_categoria = $categoriaSeleccionada";
            $resultadoBorrar = $conn->query($queryBorrar);

            // Verificar si se ha eliminado la categoría
            if ($resultadoBorrar) {
                echo '<script>alert("Categoría eliminada correctamente.");</script>';
                echo "<script>window.location.href = 'admin-del-category.php';</script>";
            } else {
                echo '<script>alert("Error al eliminar la categoría.");</script>';
            }

            // Cerrar la conexión a la base de datos
            $conn->close();
        }
    }
    ?>

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
                <h2>Síguenos</h2>
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
