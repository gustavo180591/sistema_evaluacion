# Imagen base con PHP y Apache
FROM php:8.2-apache

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    unzip \
    zip \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# ✅ Copiar contenido del sistema que está dentro de la carpeta 'sistema_evaluacion'
COPY sistema_evaluacion/public/ /var/www/html/public/
COPY sistema_evaluacion/app/ /var/www/html/app/
COPY sistema_evaluacion/config/ /var/www/html/config/
COPY sistema_evaluacion/vendor/ /var/www/html/vendor/
COPY sistema_evaluacion/composer.json /var/www/html/composer.json
COPY sistema_evaluacion/.env /var/www/html/.env
COPY sistema_evaluacion/.htaccess /var/www/html/public/.htaccess

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Establecer DocumentRoot a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Configurar Apache para reconocer /public como raíz
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Habilitar override y acceso total en public/
RUN echo '<Directory "/var/www/html/public">\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Exponer el puerto HTTP
EXPOSE 80
