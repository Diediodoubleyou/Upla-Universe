<?php
// Llamo a la conexión
include 'conexion.php';

// Inicializar variables
$rut = "";
$nombre = "";
$apellido = "";
$rutUsuario = "";
$correo = "";
$institucion = "";
$fechaNacimiento = "";
$contrasena = "";
$rango = "";
$actualizacionExitosa = false;

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el Rut ingresado en el campo de búsqueda
    if (isset($_POST["rut"])) {
        $rut = $_POST["rut"];
    }

    // Consulta SQL para buscar el usuario por su Rut
    $sql = "SELECT * FROM usuarios WHERE rut_usuario = '$rut'";
    $result = $conn->query($sql);

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $result->fetch_assoc();
        $nombre = $row["nombre_usuario"];
        $apellido = $row["apellido_usuario"];
        $rutUsuario = $row["rut_usuario"];
        $correo = $row["correo_electronico"];
        $institucion = $row["institucion_usuario"];
        $fechaNacimiento = $row["fnacimiento_usuario"];
        $contrasena = $row["contrasena"];
        $rango = $row["rango"];
    }
}

// Verificar si se envió el formulario de cambio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["rut"]) && isset($_POST["correo"]) && isset($_POST["institucion"]) && isset($_POST["fecha"]) && isset($_POST["contraseña"]) && isset($_POST["rango-register"])) {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $rutUsuario = $_POST["rut"];
    $correo = $_POST["correo"];
    $institucion = $_POST["institucion"];
    $fechaNacimiento = $_POST["fecha"];
    $contrasena = $_POST["contraseña"];
    $rango = $_POST["rango-register"];

    // Consulta SQL para actualizar los datos del usuario
    $sql = "UPDATE usuarios SET nombre_usuario = '$nombre', apellido_usuario = '$apellido', correo_electronico = '$correo', institucion_usuario = '$institucion', fnacimiento_usuario = '$fechaNacimiento', contrasena = '$contrasena', rango = '$rango' WHERE rut_usuario = '$rutUsuario'";

    if ($conn->query($sql) === TRUE) {
        $actualizacionExitosa = true;
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}
?>

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
        <form action="admin-config-user.php" method="POST">        
            <label for="rut">Buscar por Rut:</label>
            <input type="text" id="rut" name="rut" placeholder="Ingrese un rut">
            <a class="btn-login" style="display: block; text-align: center;">
            <button type="submit">Buscar</button>
            </a>
        </form><br><br>

        <?php if ($nombre !== "" && !$actualizacionExitosa) { ?>
        <h1>Editar Usuario</h1>

        <form action="admin-config-user.php" method="POST">
            <label for="name-settings-admin">Nombre</label>
            <input type="text" id="name-settings-admin" name="nombre" value="<?php echo $nombre; ?>">
    
            <!-- Apellido -->
            <label for="lastname-settings-admin">Apellido</label>
            <input type="text" id="lastname-settings-admin" name="apellido" value="<?php echo $apellido; ?>">
    
            <!-- Rut -->
            <label for="rut-settings-admin">Rut</label>
            <input type="text" id="rut-settings-admin" name="rut" value="<?php echo $rutUsuario; ?>">
    
            <!-- Mail -->
            <label for="mail-settings-admin">Correo</label>
            <input type="text" id="mail-settings-admin" name="correo" value="<?php echo $correo; ?>">
    
            <!-- Colegio -->
            <label for="institucion-settings-admin">Institucion</label>
            <input type="text" id="institucion-settings-admin" name="institucion" value="<?php echo $institucion; ?>">
    
            <!-- Fecha de nacimiento -->
            <label for="fecha-settings-admin">Fecha de Nacimiento</label>
            <input type="date" id="fecha-settings-admin" name="fecha" value="<?php echo $fechaNacimiento; ?>">
    
            <!-- Contraseña -->
            <label for="password-settings-admin">Contraseña</label>
            <input type="password" id="password-register-admin" name="contraseña" value="<?php echo $contrasena; ?>"><br>

            <!-- rango -->
            <label for="rango-register">Rango</label><br><br>
            <div class="radio-group">
                <input type="radio" id="opcion1" name="rango-register" value="Galaxia" <?php if ($rango == 'Galaxia') echo 'checked'; ?>>
                <label for="Galaxia">Galaxia</label>
                <input type="radio" id="opcion2" name="rango-register" value="Nebulosa" <?php if ($rango == 'Nebulosa') echo 'checked'; ?>>
                <label for="Nebulosa">Nebulosa</label>
                <input type="radio" id="opcion3" name="rango-register" value="Estrella" <?php if ($rango == 'Estrella') echo 'checked'; ?>>
                <label for="Estrella">Estrella</label>
            </div> <br><br>

            <!-- Button -->
            <a class="btn-register" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
            <button type="submit" onclick="showMessage()">Cambiar</button>
            </a>
        </form>
        <?php } elseif ($actualizacionExitosa) { ?>
        <h1>Actualización exitosa</h1>
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

    <script>
        function showMessage() {
            alert("Datos del usuario actualizados correctamente.");
        }
    </script>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
