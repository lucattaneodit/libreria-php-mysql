# Librería: conexión e inserción de datos con PHP y MySQL

Prueba práctica: formulario para registrar nuevos libros en la base de datos `libreria` (tabla `libros`).

## Archivos

| Archivo | Qué es |
|---|---|
| `www/inserirLlibre.php` | **Entregable.** Conecta a la BD, recoge los datos por POST, hace el `INSERT INTO`, muestra el resultado y cierra la conexión. |
| `www/index.html` | Formulario (título, número de páginas, precio) que envía los datos a `inserirLlibre.php` por POST. |
| `sql/libreria.sql` | Crea la base de datos `libreria`, la tabla `libros` y el usuario de conexión. |
| `www/buscarLlibre.php` | Extra: lista de libros con buscador por título y página de detalles de cada libro. |
| `www/css/style.css` | Estilos comunes de todas las páginas (barra de navegación, tarjetas, tablas). |
| `sql/libros_datos.sql` | 50 libros de ejemplo para la tabla `libros`. |
| `sql/libros_cdmon.sql` | Solo la tabla `libros`, para importarla en el phpMyAdmin de CDMON. |
| `datosISP.txt` | **Entregable.** Datos de acceso al ISP donde está publicado. |
| `docker-compose.yml`, `Dockerfile` | Entorno local (PHP + Apache, MariaDB y phpMyAdmin), equivalente a XAMPP. |

## Tabla `libros`

| Campo | Tipo | Descripción |
|---|---|---|
| `idLlibre` | INT, PK, AUTO_INCREMENT | Identificador (no se inserta) |
| `titol` | VARCHAR(100) | Título del libro |
| `numPag` | INT | Número de páginas |
| `reu` | DECIMAL(6,2) | Precio |

## Cómo probarlo

### Opción A: con Docker

```bash
docker compose up -d
```

- Formulario: http://localhost:8080
- phpMyAdmin: http://localhost:8082 (usuario `libreria`, contraseña `libreria123`)

Para pararlo: `docker compose down`.

### Opción B: con XAMPP

1. Copia el contenido de `www/` en `htdocs/libreria/`.
2. En phpMyAdmin, importa `sql/libreria.sql`.
3. En `inserirLlibre.php`, cambia `$servidor = 'db';` por `$servidor = 'localhost';`.
4. Abre http://localhost/libreria

## Publicación en el ISP (CDMON)

1. En el panel de CDMON, crea una base de datos MySQL y apunta: servidor, nombre de la BD, usuario y contraseña.
2. En el phpMyAdmin de CDMON, importa `sql/libros_cdmon.sql` (crea la tabla `libros`) y después `sql/libros_datos.sql` (los 50 libros).
3. En `www/inserirLlibre.php` y `www/buscarLlibre.php`, cambia `$servidor`, `$usuario`, `$contrasenha` y `$bd` por los datos de CDMON.
4. Sube el contenido de `www/` por FTP (por ejemplo con FileZilla) a la carpeta pública del hosting.
5. Rellena `datosISP.txt` con el link y los datos de acceso.

## Créditos

Foto de fondo (`www/img/cielo.jpg`): "White Cumulus Clouds against Blue Sky (3)", de Lance Vanlewen, [Wikimedia Commons](https://commons.wikimedia.org/wiki/File:White_Cumulus_Clouds_against_Blue_Sky_(3).jpg), licencia [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
