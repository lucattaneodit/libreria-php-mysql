<?php
// Desactivamos las excepciones: comprobamos los errores nosotros con if
mysqli_report(MYSQLI_REPORT_OFF);

// Datos de conexión ($servidor, $usuario, $contrasenha, $bd)
include("variables.php");

// Variables para pintar el resultado en el HTML de abajo
$clase    = 'error';   // 'ok' o 'error' (cambia el color de la tarjeta)
$titulo   = '';
$mensaje  = '';
$conexOk  = false;

// Si alguien abre esta página directamente (sin enviar el formulario)
// no hay datos en $_POST: avisamos en lugar de intentar insertar
if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['ftitol']) || empty($_POST['fnumPag']) || !isset($_POST['freu'])) {
    $titulo  = 'Faltan datos';
    $mensaje = 'Primero tienes que rellenar el formulario con el título, las páginas y el precio del libro.';
} else {

    // 1. Establecer la conexión con la base de datos libreria
    $conexion = mysqli_connect($servidor, $usuario, $contrasenha, $bd);

    // 2. Comprobar si la conexión se ha realizado correctamente
    if (!$conexion) {
        $titulo  = 'Error de conexión';
        $mensaje = 'No se pudo conectar con la base de datos: ' . mysqli_connect_error();
    } else {
        $conexOk = true;   // "Conexión satisfactoria!"

        // 3. Recuperar los datos enviados desde el formulario por POST
        $titol  = $_POST['ftitol'];
        $numPag = $_POST['fnumPag'];
        $reu    = $_POST['freu'];

        // Limpiamos el título para que una comilla (ej: L'Odissea) no rompa la consulta
        $titolSql = mysqli_real_escape_string($conexion, $titol);

        // 4. Consulta INSERT INTO (sin idLlibre porque es autoincremental)
        $sql = "INSERT INTO libros (titol, numPag, reu) VALUES ('$titolSql', '$numPag', '$reu')";

        // 5. Ejecutar la consulta con mysqli_query()
        $resultado = mysqli_query($conexion, $sql);

        // 6. Mensaje según si la inserción ha ido bien o no
        if ($resultado) {
            $clase   = 'ok';
            $titulo  = 'Libro insertado correctamente';
            $mensaje = 'El libro se ha guardado en la base de datos con el id ' . mysqli_insert_id($conexion) . '.';
        } else {
            $titulo  = 'Error al insertar el libro';
            $mensaje = mysqli_error($conexion);
        }

        // 7. Cerrar la conexión
        mysqli_close($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Librería</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="barra">
        <span class="logo">Librería Luce</span>
        <a href="index.html" class="activo">Registrar libro</a>
        <a href="buscarLlibre.php">Ver libros</a>
        <form class="buscador" action="buscarLlibre.php" method="get">
            <input type="search" name="q" placeholder="Buscar por título...">
            <input type="submit" value="Buscar">
        </form>
    </nav>

    <h1>Registrar nuevo libro</h1>

    <div class="tarjeta <?php echo $clase; ?>">

        <?php if ($conexOk) { ?>
            <p class="conexion"> Conexión satisfactoria!</p>
        <?php } ?>

        <h2><?php echo $titulo; ?></h2>
        <p><?php echo htmlspecialchars($mensaje); ?></p>

        <?php if ($clase == 'ok') { ?>
            <!-- Mostramos los datos que se han guardado -->
            <table class="datos">
                <tr><th>Título</th><td><?php echo htmlspecialchars($titol); ?></td></tr>
                <tr><th>Páginas</th><td><?php echo htmlspecialchars($numPag); ?></td></tr>
                <tr><th>Precio</th><td><?php echo htmlspecialchars($reu); ?> €</td></tr>
            </table>
        <?php } ?>

        <a class="boton" href="index.html">
            <?php echo ($clase == 'ok') ? 'Insertar otro libro' : 'Volver al formulario'; ?>
        </a>
    </div>
</body>
</html>
