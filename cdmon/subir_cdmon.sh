#!/bin/bash
# Sube la web (carpeta www/) a CDMON por FTP.
# Uso (desde la carpeta libreria):   bash cdmon/subir_cdmon.sh
# Te pedirá la contraseña FTP (no se ve al escribirla y no se guarda en ningún sitio).

SERVIDOR="185.42.105.105"
USUARIO="libreria4a"
CARPETA_REMOTA="${1:-web}"    # carpeta pública del hosting

cd "$(dirname "$0")/.." || exit 1

if grep -q "PON_AQUI_TU_CONTRASEÑA" cdmon/variables.php; then
    echo "Primero pon la contraseña de MySQL en cdmon/variables.php"
    exit 1
fi

read -r -s -p "Contraseña FTP de $USUARIO: " CLAVE
echo

subir() {   # subir <archivo local> <ruta remota>
    if curl -s --ftp-create-dirs -T "$1" --user "$USUARIO:$CLAVE" "ftp://$SERVIDOR/$CARPETA_REMOTA/$2"; then
        echo "  OK  $2"
    else
        echo "  ERROR  $2"
        exit 1
    fi
}

echo "Subiendo a ftp://$SERVIDOR/$CARPETA_REMOTA/ ..."
subir www/index.html        index.html
subir www/inserirLlibre.php inserirLlibre.php
subir www/buscarLlibre.php  buscarLlibre.php
subir www/css/style.css     css/style.css
subir www/img/cielo.jpg     img/cielo.jpg
subir cdmon/variables.php   variables.php     # la versión con los datos de CDMON
echo "¡Listo! Abre http://librerialuce.com.mialias.net"
