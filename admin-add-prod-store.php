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
        <h2>Agregar Producto</h2><br><br><br><br>

        <?php
        // Incluir el archivo de conexión
        include 'conexion.php';

        // Verificar si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los valores ingresados en el formulario
            $producto = $_POST["producto"];
            $valor = $_POST["valor"];
            $imagen = $_FILES["imagen"]["name"]; // Nombre del archivo seleccionado por el usuario
            $imagen_temp = $_FILES["imagen"]["tmp_name"]; // Ruta temporal del archivo

            // Ruta de destino para guardar la imagen
            $ruta_destino = "img/img-preguntas/" . $imagen;

            // Mover el archivo a la ruta de destino
            move_uploaded_file($imagen_temp, $ruta_destino);

            // Consulta SQL para insertar los datos en la tabla
            $sql = "INSERT INTO tienda (producto, valor, imagen) VALUES ('$producto', $valor, '$ruta_destino')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Producto agregado exitosamente');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" enctype="multipart/form-data">
            <label for="producto">Producto:</label>
            <input type="text" name="producto" required><br><br><br>

            <label for="valor">Valor:</label>
            <input type="number" name="valor" required><br><br><br>

            <label for="imagen">Imagen Recomendable de (200 x 162):</label><br><br>
            <input type="file" name="imagen" required><br><br><br>

            <input type="submit" value="Agregar Producto">
        </form>
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
