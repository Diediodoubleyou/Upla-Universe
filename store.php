<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
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
                <a href="home.html">
                    <img src="img/white_logo_game.png" alt="logo-header">
                </a>
            </div>
        </header>
    </div>

    <?php
    // Incluir el archivo de conexión
    include 'conexion.php';

    // Consulta SQL para obtener los productos de la tienda
    $sql = "SELECT * FROM tienda";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Iterar sobre los resultados y generar los elementos dinámicos
        while ($row = $result->fetch_assoc()) {
            $producto = $row['producto'];
            $valor = $row['valor'];
            $imagen = $row['imagen'];
    ?>
            <div class="box-tienda">
                <!-- Imagen del producto -->
                <div class="icono-cofre">
                    <img src="<?php echo $imagen; ?>" alt="<?php echo $producto; ?>">
                    <h1><?php echo $producto; ?></h1>
                </div>

                <div class="star-icon">
                    <i class="fa-regular fa-star"><?php echo $valor; ?></i>
                </div>

                <div class="comprar">
                    <a class="fa-solid fa-cart-shopping"></a>
                </div>
            </div>
    <?php
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>

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
