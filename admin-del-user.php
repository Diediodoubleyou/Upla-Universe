<?php
// Llamo a la conexión
include 'conexion.php';

$nombre = "";
$apellido = "";
$rutUsuario = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se hizo clic en el botón "Buscar"
    if (isset($_POST["buscar"])) {
        // Obtener el rut del formulario
        $rut = $_POST["rut"];

        // Verificar que la conexión esté establecida
        if ($conn) {
            // Consultar la tabla usuarios
            $query = "SELECT * FROM usuarios WHERE rut_usuario = '$rut'";
            $result = mysqli_query($conn, $query);

            // Verificar si se encontró un usuario con el rut dado
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $nombre = $row["nombre_usuario"];
                $apellido = $row["apellido_usuario"];
                $rutUsuario = $row["rut_usuario"];
            }
        }
    }

    // Verificar si se hizo clic en el botón "Borrar"
    if (isset($_POST["borrar"])) {
        // Obtener el rut del formulario
        $rut = $_POST["rut"];

        // Verificar que la conexión esté establecida
        if ($conn) {
            // Eliminar el usuario de la tabla usuarios
            $query = "DELETE FROM usuarios WHERE rut_usuario = '$rut'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Usuario eliminado exitosamente
                echo "<script>alert('Usuario eliminado correctamente');</script>";
            } else {
                // Error al eliminar el usuario
                echo "<script>alert('Error al eliminar el usuario');</script>";
            }
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
        <h1>Buscar Usuario</h1> 

        <!-- Campo de búsqueda -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">        
            <label for="rut">Buscar por Rut:</label>
            <input type="text" id="rut" name="rut" placeholder="Ingrese un rut">
            <a class="btn-login" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
            <button type="submit" name="buscar">Buscar</button>
            </a>
        </form><br><br>

        <!-- Mostrar datos del usuario -->
        <?php if ($nombre !== "") { ?>
            <h1>Datos del Usuario</h1>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="name-settings-admin">Nombre</label>
                <input type="text" id="name-settings-admin" name="nombre" value="<?php echo $nombre; ?>">

                <!-- Apellido -->
                <label for="lastname-settings-admin">Apellido</label>
                <input type="text" id="lastname-settings-admin" name="apellido" value="<?php echo $apellido; ?>">

                <!-- Rut -->
                <label for="rut-settings-admin">Rut</label>
                <input type="text" id="rut-settings-admin" name="rut" value="<?php echo $rutUsuario; ?>">

                <!-- Button -->
                <a class="btn-register" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                <button type="submit" name="borrar" onclick="return confirm('¿Estás seguro de que quieres borrar este usuario?')">Borrar</button>
                </a>
            </form>
        <?php } ?>
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

