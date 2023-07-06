<?php
// Llamo a la conexión
include 'conexion.php';

// Iniciar sesión
session_start();

// Obtengo los valores ingresados por el usuario
$login_rut = $_POST["login_rut"];
$login_contrasena = $_POST["login_contrasena"];

// Preparo la consulta SQL para verificar las credenciales
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE rut_usuario = ? AND contrasena = ?");
$stmt->bind_param("ss", $login_rut, $login_contrasena);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Las credenciales son correctas
    $stmt->bind_result($id_usuario, $rango, $nombre_usuario, $apellido_usuario, $rut_usuario, $correo_electronico, $institucion_usuario, $fnacimiento_usuario, $contrasena);
    $stmt->fetch();

    // Configurar la sesión del usuario
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['rut_usuario'] = $rut_usuario;
    $_SESSION['nombre_usuario'] = $nombre_usuario;
    $_SESSION['apellido_usuario'] = $apellido_usuario;
    // ... Agrega más datos de sesión según tus necesidades

    // Verificar si el usuario ha seleccionado la opción "Recordar sesión"
    if (isset($_POST['recordar_sesion'])) {
        // Configurar una cookie para recordar la sesión
        $cookie_name = "session_cookie";
        $cookie_value = session_id();
        $cookie_expire = time() + (120 * 60); // Caduca en 2 horas
        setcookie($cookie_name, $cookie_value, $cookie_expire, '/');
    }

    // Redireccionar según el rango
    if ($rango == 'admin') {
        // Redireccionar al perfil del administrador
        header("Location: profile-admin.html");
        exit();
    } else {
        // Redireccionar al perfil de usuario normal
        header("Location: profile.html");
        exit();
    }
} else {
    // Las credenciales son incorrectas, mostrar un mensaje de error
    echo "<script>alert('RUT o Contraseña incorrecta.');</script>";
    echo "<script>history.back();</script>";
    exit();
}

$stmt->close();
$conn->close();
?>
