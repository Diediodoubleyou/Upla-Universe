<?php
// Llamo a la conexión
include 'conexion.php';

if (isset($_POST['registrar'])) {
    $categoria = $_POST['admin-add-categoria'];

    // Verificar si la categoría ya está registrada
    $query = "SELECT * FROM categorias WHERE nombre_categoria = '$categoria'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // La categoría ya está registrada
        echo '<script>alert("La categoría ya está registrada.");</script>';
    } else {
        // Insertar la categoría en la tabla 'categorias'
        $query = "INSERT INTO categorias (nombre_categoria) VALUES ('$categoria')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // La categoría se agregó correctamente
            echo '<script>alert("Categoría agregada exitosamente.");</script>';
        } else {
            // Ocurrió un error al agregar la categoría
            echo '<script>alert("Error al agregar la categoría: ' . mysqli_error($conn) . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuario</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://kit.fontawesome.com/7791b6ed55.js" crossorigin="anonymous"></script>
    <!-- Agregar SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h1>Agregar Categoria</h1> <br><br>

        <!-- Campo de búsqueda -->
        <form action="" method="POST">        
            <label for="rut">Agregar Categoria</label>
            <input type="text" id="add-categoria" name="admin-add-categoria">
            <a class="btn-login" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
            <button type="submit" name="registrar">Agregar Categoria</button>
            </a>
        </form><br><br>
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
