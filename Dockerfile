FROM php:8.3-apache
# Activamos la extensión mysqli (la que usamos con mysqli_connect, mysqli_query...)
RUN docker-php-ext-install mysqli
