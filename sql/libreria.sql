-- Base de datos libreria y tabla libros
-- (este mismo script sirve para importarlo en phpMyAdmin del ISP)

CREATE DATABASE IF NOT EXISTS libreria CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE libreria;

CREATE TABLE IF NOT EXISTS libros (
    idLlibre INT AUTO_INCREMENT PRIMARY KEY,  -- autoincremental, NO se inserta
    titol    VARCHAR(100) NOT NULL,           -- título del libro
    numPag   INT NOT NULL,                    -- número de páginas
    reu      DECIMAL(6,2) NOT NULL            -- precio del libro
);

-- Usuario para conectarnos desde PHP (como hicimos en phpMyAdmin en clase)
CREATE USER IF NOT EXISTS 'libreria'@'%' IDENTIFIED BY 'libreria123';
GRANT ALL PRIVILEGES ON libreria.* TO 'libreria'@'%';
FLUSH PRIVILEGES;
