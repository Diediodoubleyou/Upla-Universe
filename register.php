<?php
// Llamo a la conexión
include 'conexion.php';

// Obtengo el RUT ingresado.
$registro_ci = $_POST["registro_ci"];

// Verifico si el RUT ya está registrado.
$stmt = $conn->prepare("SELECT rut_usuario FROM usuarios WHERE rut_usuario = ?");
$stmt->bind_param("s", $registro_ci);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('El RUT ya está registrado.');</script>";
    echo "<script>history.back();</script>";
    exit();
}

// Obtengo el correo electrónico ingresado.
$registro_mail = $_POST["registro_mail"];

// Verifico si el correo electrónico ya está registrado.
$stmt = $conn->prepare("SELECT correo_electronico FROM usuarios WHERE correo_electronico = ?");
$stmt->bind_param("s", $registro_mail);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('El correo electrónico ya está registrado.');</script>";
    echo "<script>history.back();</script>";
    exit();
}

// Preparo la consulta SQL con marcadores de posición.
$sql = "INSERT INTO usuarios (nombre_usuario, apellido_usuario, rut_usuario, correo_electronico, institucion_usuario, fnacimiento_usuario, contrasena, rango) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Preparo y enlazo los parámetros.
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $registro_nombre, $registro_apellido, $registro_ci, $registro_mail, $registro_institucion, $registro_fnacimiento, $registro_contrasena, $registro_rango);

// Establezco los valores de los parámetros.
$registro_nombre = $_POST["registro_nombre"];
$registro_apellido = $_POST["registro_apellido"];
$registro_ci = $_POST["registro_ci"];
$registro_mail = $_POST["registro_mail"];
$registro_institucion = $_POST["registro_institucion"];
$registro_fnacimiento = $_POST["registro_fnacimiento"];
$registro_contrasena = $_POST["registro_contrasena"];

// Obtengo el valor seleccionado del botón de radio
$registro_rango = $_POST["rango-register"];

// Validación del formato del correo electrónico.
if (!filter_var($registro_mail, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('El formato del correo electrónico es inválido.');</script>";
    echo "<script>history.back();</script>";
    exit();
}

// Validación del RUT
function validarRut($rut) {
    $rut = preg_replace('/[^k0-9]/i', '', $rut);
    $dv  = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut)-1);
    $i = 2;
    $suma = 0;
    foreach(array_reverse(str_split($numero)) as $v) {
        if($i==8)
            $i = 2;
        $suma += $v * $i;
        ++$i;
    }
    $dvr = 11 - ($suma % 11);
    if($dvr == 11) $dvr = 0;
    if($dvr == 10) $dvr = 'K';
    return strtoupper($dv) == strtoupper($dvr);
}

if (!validarRut($registro_ci)) {
    echo "<script>alert('El RUT ingresado no es válido.');</script>";
    echo "<script>history.back();</script>";
    exit();
}

// Ejecuto la consulta.
$stmt->execute();

// Verifico si la inserción fue exitosa.
if ($stmt->affected_rows > 0) {
    // Redirecciono al index y muestro el mensaje en JavaScript.
    echo "<script>alert('Usuario registrado.');</script>";
    echo "<script>window.location.href = 'profile-admin.html';</script>";
    exit();
} else {
    echo "Error al insertar datos: " . $stmt->error;
}

// Cierro la consulta y la conexión.
$stmt->close();
$conn->close();
?>