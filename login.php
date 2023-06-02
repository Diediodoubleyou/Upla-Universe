<?php
// Llamo a la conexión
include 'conexion.php';

// Obtengo los valores ingresados por el usuario.
$login_rut = $_POST["login_rut"];
$login_contrasena = $_POST["login_contrasena"];

// Preparo la consulta SQL para verificar las credenciales.
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE rut_usuario = ? AND contrasena = ?");
$stmt->bind_param("ss", $login_rut, $login_contrasena);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Las credenciales son correctas.
    $stmt->bind_result($id_usuario, $rango, $nombre_usuario, $apellido_usuario, $rut_usuario, $correo_electronico, $institucion_usuario, $fnacimiento_usuario, $contrasena);
    $stmt->fetch();
    
    // Redireccionar según el rango
    if ($rango == 'admin') {
        // Redireccionar al perfil del administrador.
        echo "<script>window.location.href = 'profile-admin.html';</script>";
        exit();
    } else {
        // Redireccionar al perfil de usuario normal.
        echo "<script>window.location.href = 'profile.html';</script>";
        exit();
    }
} else {
    // Las credenciales son incorrectas, mostrar un mensaje de error.
    echo "<script>alert('RUT o Contraseña incorrecta.');</script>";
    echo "<script>history.back();</script>";
    exit();
}

$stmt->close();
$conn->close();
?>