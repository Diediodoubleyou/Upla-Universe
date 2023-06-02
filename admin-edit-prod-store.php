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
    <?php
    // Incluir el archivo de conexión
    include 'conexion.php';

    // Variables para almacenar los datos del producto seleccionado
    $id = '';
    $producto = '';
    $valor = '';

    // Verificar si se ha enviado el formulario de búsqueda
    if (isset($_POST['buscar'])) {
        // Obtener el ID del producto seleccionado
        $id = $_POST['producto'];

        // Obtener los datos del producto seleccionado
        $query = "SELECT * FROM tienda WHERE id_tienda = $id";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Mostrar los datos del producto en un formulario de edición
            $row = $result->fetch_assoc();
            $producto = $row['producto'];
            $valor = $row['valor'];
        } else {
            echo "<script>alert('No se encontró el producto seleccionado.');</script>";
        }
    }

    // Verificar si se ha enviado el formulario de actualización
    if (isset($_POST['actualizar'])) {
        // Obtener los nuevos valores del producto
        $id = $_POST['id'];
        $producto = $_POST['producto'];
        $valor = $_POST['valor'];

        // Verificar si se ha subido una nueva imagen
        if ($_FILES['imagen']['tmp_name']) {
            // Ruta de destino para almacenar la imagen subida
            $uploadDir = 'img/img-preguntas/';

            // Generar un nombre único para la imagen utilizando la función uniqid()
            $imageName = uniqid() . '_' . $_FILES['imagen']['name'];

            // Ruta completa del archivo de destino
            $uploadFile = $uploadDir . $imageName;

            // Mover la imagen subida al directorio de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                // La imagen se ha subido correctamente, actualizamos la columna "imagen" en la base de datos
                $query = "UPDATE tienda SET producto = '$producto', valor = '$valor', imagen = '$uploadFile' WHERE id_tienda = $id";

                if ($conn->query($query) === TRUE) {
                    echo "<script>alert('Los datos se han actualizado correctamente.');</script>";
                } else {
                    echo "<script>alert('Error al actualizar los datos: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Error al subir la imagen.');</script>";
            }
        } else {
            // No se ha subido una nueva imagen, actualizamos solo los campos "producto" y "valor"
            $query = "UPDATE tienda SET producto = '$producto', valor = '$valor' WHERE id_tienda = $id";

            if ($conn->query($query) === TRUE) {
                echo "<script>alert('Los datos se han actualizado correctamente.');</script>";
            } else {
                echo "<script>alert('Error al actualizar los datos: " . $conn->error . "');</script>";
            }
        }
    }

    // Obtener la lista de productos de la tabla
    $query = "SELECT id_tienda, producto FROM tienda";
    $result = $conn->query($query);
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Combobox para seleccionar el producto -->
        <label for="producto">Seleccionar producto:</label>
        <select name="producto" id="producto">
            <option value="">Seleccionar</option> <!-- Opción adicional -->
            <?php
            // Mostrar opciones del combobox con los productos
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id_tienda'] . '">' . $row['producto'] . '</option>';
            }
            ?>
        </select>
        <br>

        <!-- Botón de búsqueda -->
        <input type="submit" name="buscar" value="Buscar"><br><br>
    </form>

    <?php
    // Mostrar formulario de edición si hay un producto seleccionado
    if ($id != '') {
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para el ID -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <!-- Campos para editar el producto -->
            <label for="producto">Nombre del producto:</label>
            <input type="text" name="producto" value="<?php echo $producto; ?>"><br>

            <label for="valor">Valor del producto:</label>
            <input type="text" name="valor" value="<?php echo $valor; ?>"><br>

            <label for="imagen">Imagen del producto:</label>
            <input type="file" name="imagen"><br>

            <!-- Botón de actualización -->
            <input type="submit" name="actualizar" value="Actualizar">
        </form>

        <?php
    }

    // Cerrar la conexión
    $conn->close();
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

    <script>
        // Función para mostrar los mensajes de PHP como pop-ups en JavaScript
        function showAlert(message) {
            alert(message);
        }

        // Mostrar mensajes de PHP como pop-ups al cargar la página
        <?php
        if (isset($_POST['buscar']) && $result->num_rows == 0) {
            echo "showAlert('No se encontró el producto seleccionado.');";
        } elseif (isset($_POST['actualizar']) && $conn->query($query) !== TRUE) {
            echo "showAlert('Error al actualizar los datos: " . $conn->error . "');";
        }
        ?>
    </script>
</body>
</html>
