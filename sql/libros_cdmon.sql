-- Para el ISP (CDMON):
-- En un hosting no se puede hacer CREATE DATABASE ni CREATE USER desde SQL.
-- La base de datos y su usuario se crean desde el panel de CDMON,
-- y después se importa este archivo en su phpMyAdmin (solo crea la tabla).

CREATE TABLE IF NOT EXISTS libros (
    idLlibre INT AUTO_INCREMENT PRIMARY KEY,  -- autoincremental, NO se inserta
    titol    VARCHAR(100) NOT NULL,           -- título del libro
    numPag   INT NOT NULL,                    -- número de páginas
    reu      DECIMAL(6,2) NOT NULL            -- precio del libro
);
