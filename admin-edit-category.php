<?php
// Llamo a la conexión
include 'conexion.php';

// Variable para almacenar el nombre de la categoría seleccionada
$nombreCategoriaSeleccionada = "";

// Variable para verificar si se ha realizado la edición exitosamente
$edicionExitosa = false;

// Variable para controlar la visibilidad del formulario de edición
$mostrarFormularioEdicion = false;

// Procesar la búsqueda y edición cuando se envía el formulario
if (isset($_POST['buscar'])) {
    $categoriaSeleccionada = $_POST['categoria'];

    if ($categoriaSeleccionada != "") {
        // Realizar la búsqueda en la base de datos usando la categoría seleccionada
        $query = "SELECT * FROM categorias WHERE id_categoria = $categoriaSeleccionada";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Se encontró la categoría
            $row = mysqli_fetch_assoc($result);
            $nombreCategoriaSeleccionada = $row['nombre_categoria'];
            $mostrarFormularioEdicion = true;
        } else {
            // No se encontró la categoría
            echo '<script>mostrarError("No se encontró la categoría seleccionada.");</script>';
        }
    } else {
        // No se seleccionó ninguna categoría
        echo '<script>mostrarError("Por favor, selecciona una categoría.");</script>';
    }
}

// Procesar la edición cuando se envía el formulario de edición
if (isset($_POST['editar'])) {
    $nuevoNombreCategoria = $_POST['nuevo_nombre_categoria'];
    $categoriaSeleccionada = $_POST['categoria_seleccionada'];

    // Realizar la actualización en la base de datos
    $query = "UPDATE categorias SET nombre_categoria = '$nuevoNombreCategoria' WHERE id_categoria = $categoriaSeleccionada";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // La edición fue exitosa
        echo '<script>mostrarExito("La categoría se ha editado correctamente.");</script>';
    } else {
        // Ocurrió un error durante la edición
        echo '<script>mostrarError("Error al editar la categoría: ' . mysqli_error($conn) . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://kit.fontawesome.com/7791b6ed55.js" crossorigin="anonymous"></script>

    <!-- Agregar SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Función para mostrar mensaje de error
        function mostrarError(mensaje) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: mensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        }

        // Función para mostrar mensaje de éxito
        function mostrarExito(mensaje) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: mensaje,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }
    </script>
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

    <div class="box-register">
        <h1>Editar Categoria</h1> <br><br>

        <!-- Campo de búsqueda -->
        <form action="" method="POST">        
            <label for="categoria">Buscar por categoría:</label>
            <select name="categoria" id="categoria">
                <option value="">Seleccionar categoría</option>
                <?php
                // Obtener las categorías desde la base de datos
                $query = "SELECT id_categoria, nombre_categoria FROM categorias";
                $result = mysqli_query($conn, $query);

                // Iterar sobre los resultados y mostrar las opciones del combo box
                while ($row = mysqli_fetch_assoc($result)) {
                    $idCategoria = $row['id_categoria'];
                    $nombreCategoria = $row['nombre_categoria'];
                    echo '<option value="' . $idCategoria . '">' . $nombreCategoria . '</option>';
                }
                ?>
            </select>
            <a class="btn-register" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
            <button type="submit" name="buscar">Buscar</button>
            </a>
        </form><br><br><br><br><br><br>

        <?php
        // Mostrar el formulario de edición solo si se seleccionó una categoría válida
        if ($mostrarFormularioEdicion) {
            ?>
            <!-- Formulario de edición -->
            <form action="" method="POST">
                <label for="nuevo_nombre_categoria">Nuevo nombre de categoría:</label>
                <input type="text" name="nuevo_nombre_categoria" id="nuevo_nombre_categoria" value="<?php echo $nombreCategoriaSeleccionada; ?>" required>
                <input type="hidden" name="categoria_seleccionada" value="<?php echo $categoriaSeleccionada; ?>">
                <a class="btn-register" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                <button type="submit" name="editar">Cambiar</button>
                </a>
            </form>
            <?php
        }
        ?>

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
