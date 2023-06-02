<?php
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos

$producto_seleccionado = "";
$valor = "";
$mensaje = "";

// Verificar si se ha enviado una opción de producto para borrar
if (isset($_POST['producto_seleccionado'])) {
    $producto_seleccionado = $_POST['producto_seleccionado'];

    // Obtener el valor correspondiente al producto seleccionado
    $sql = "SELECT valor FROM tienda WHERE producto = '$producto_seleccionado'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $valor = $row['valor'];
    } else {
        $mensaje = "No se encontraron registros para el producto seleccionado.";
    }
}

// Eliminar los registros correspondientes al producto seleccionado
if (isset($_POST['borrar_registros'])) {
    $sql = "DELETE FROM tienda WHERE producto = '$producto_seleccionado'";
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Los registros del producto $producto_seleccionado han sido borrados correctamente.";
        $producto_seleccionado = "";
        $valor = "";
    } else {
        $mensaje = "Error al borrar los registros: " . $conn->error;
    }
}

// Obtener los productos existentes en la tabla
$sql = "SELECT producto FROM tienda";
$result = $conn->query($sql);
$opciones_productos = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto = $row['producto'];
        $selected = ($producto == $producto_seleccionado) ? "selected" : "";
        $opciones_productos .= "<option value='$producto' $selected>$producto</option>";
    }
}

$conn->close();
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

        <h2>Borrar registros de la tienda</h2>
        <form action="" method="post">
            <label for="producto">Selecciona un producto:</label>
            <select name="producto_seleccionado" id="producto">
                <option value="">Seleccionar</option>
                <?php echo $opciones_productos; ?>
            </select>
            <input type="submit" value="Buscar"><br><br><br>
        </form>

        <?php if (!empty($producto_seleccionado)) : ?>
            <h3>Datos del producto:</h3>
            <p>Producto: <?php echo $producto_seleccionado; ?></p>
            <p>Valor: <?php echo $valor; ?></p>

            <form action="" method="post">
                <input type="hidden" name="producto_seleccionado" value="<?php echo $producto_seleccionado; ?>"><br><br>
                <input type="submit" name="borrar_registros" value="Borrar Registros">
            </form>
        <?php endif; ?>

        <script>
            // Función para mostrar mensajes emergentes
            function mostrarMensaje(mensaje) {
                alert(mensaje);
            }

            // Mostrar mensaje si existe
            <?php if (!empty($mensaje)) : ?>
                mostrarMensaje("<?php echo $mensaje; ?>");
            <?php endif; ?>
        </script>

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
