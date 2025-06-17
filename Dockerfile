FROM php:8.2-apache

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    unzip \
    zip \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# ✅ Copiar contenido actual (ya estamos dentro del sistema)
COPY public/ /var/www/html/sistema_evaluacion/public/
COPY app/ /var/www/html/sistema_evaluacion/app/
COPY config/ /var/www/html/sistema_evaluacion/config/
COPY vendor/ /var/www/html/sistema_evaluacion/vendor/
COPY composer.json /var/www/html/sistema_evaluacion/composer.json
COPY .env /var/www/html/sistema_evaluacion/.env
# COPY public/.htaccess /var/www/html/sistema_evaluacion/public/.htaccess

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

ENV APACHE_DOCUMENT_ROOT=/var/www/html/sistema_evaluacion/public

RUN sed -ri -e 's!/var/www/html!/var/www/html/sistema_evaluacion/public!g' /etc/apache2/sites-available/000-default.conf

RUN echo '<Directory "/var/www/html/sistema_evaluacion/public">\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

EXPOSE 80
