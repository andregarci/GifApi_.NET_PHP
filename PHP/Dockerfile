# Utilizar la imagen de PHP con Apache
FROM php:7.4-apache

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-install mysqli

# Copiar los archivos de tu aplicación PHP al contenedor
COPY . /var/www/html/

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html/
