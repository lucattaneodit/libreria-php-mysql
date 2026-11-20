<?php
// Buscador de libros: lista los libros (filtrando por título) y muestra el detalle de uno
mysqli_report(MYSQLI_REPORT_OFF);

// Datos de conexión ($servidor, $usuario, $contrasenha, $bd)
include("variables.php");

// Lo que llega por la URL (GET):
//   buscarLlibre.php?q=quijote  -> busca por título
//   buscarLlibre.php?id=5       -> muestra el detalle del libro 5
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$id       = isset($_GET['id']) ? (int) $_GET['id'] : 0;   // (int) -> siempre será un número

$error   = '';
$libro   = null;     // detalle de un libro
$libros  = [];       // lista de resultados

// Conexión
$conexion = mysqli_connect($servidor, $usuario, $contrasenha, $bd);

if (!$conexion) {
    $error = 'No se pudo conectar con la base de datos: ' . mysqli_connect_error();
} else {

    if ($id > 0) {
        // DETALLE de un libro concreto
        $sql = "SELECT * FROM libros WHERE idLlibre = $id";
        $resultado = mysqli_query($conexion, $sql);
        $libro = mysqli_fetch_assoc($resultado);   // array con titol, numPag, reu... o null
        if (!$libro) {
            $error = 'No existe ningún libro con el id ' . $id . '.';
        }
    } else {
        // LISTA de libros (todos, o los que contienen el texto buscado)
        $textoSql = mysqli_real_escape_string($conexion, $busqueda);
        $sql = "SELECT * FROM libros WHERE titol LIKE '%$textoSql%' ORDER BY titol";
        $resultado = mysqli_query($conexion, $sql);

        // Recorremos los resultados fila a fila
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $libros[] = $fila;
        }
    }

    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar libros - Librería</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="barra">
        <span class="logo">Librería Luce</span>
        <a href="index.html">Registrar libro</a>
        <a href="buscarLlibre.php" class="activo">Ver libros</a>
        <form class="buscador" action="buscarLlibre.php" method="get">
            <input type="search" name="q" placeholder="Buscar por título..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <input type="submit" value="Buscar">
        </form>
    </nav>

    <?php if ($error != '') { ?>
        <!-- Error -->
        <div class="tarjeta error">
            <h2>Error</h2>
            <p><?php echo htmlspecialchars($error); ?></p>
            <a class="boton" href="buscarLlibre.php">Ver todos los libros</a>
        </div>

    <?php } else if ($libro) { ?>
        <!-- Detalle de un libro -->
        <h1>Detalles del libro</h1>
        <div class="tarjeta">
            <h2><?php echo htmlspecialchars($libro['titol']); ?></h2>
            <table class="datos">
                <tr><th>Id</th><td><?php echo $libro['idLlibre']; ?></td></tr>
                <tr><th>Título</th><td><?php echo htmlspecialchars($libro['titol']); ?></td></tr>
                <tr><th>Páginas</th><td><?php echo $libro['numPag']; ?></td></tr>
                <tr><th>Precio</th><td><?php echo number_format($libro['reu'], 2, ',', '.'); ?> €</td></tr>
            </table>
            <a class="boton" href="buscarLlibre.php">Volver a la lista</a>
        </div>

    <?php } else { ?>
        <!-- Lista de libros -->
        <h1><?php echo ($busqueda == '') ? 'Todos los libros' : 'Resultados para "' . htmlspecialchars($busqueda) . '"'; ?></h1>
        <div class="tarjeta ancha">
            <p><?php echo count($libros); ?> libro(s) encontrado(s). Haz clic en un título para ver sus detalles.</p>

            <?php if (count($libros) > 0) { ?>
                <table class="lista">
                    <tr><th>Título</th><th>Páginas</th><th>Precio</th></tr>
                    <?php foreach ($libros as $l) { ?>
                        <tr>
                            <td><a href="buscarLlibre.php?id=<?php echo $l['idLlibre']; ?>"><?php echo htmlspecialchars($l['titol']); ?></a></td>
                            <td><?php echo $l['numPag']; ?></td>
                            <td><?php echo number_format($l['reu'], 2, ',', '.'); ?> €</td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <a class="boton" href="buscarLlibre.php">Ver todos los libros</a>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>
