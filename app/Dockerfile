FROM php:8.2-apache

# Устанавливаем системные зависимости
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
           apt-get install -y nodejs

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install --omit=dev \
    && npm run build

RUN chown -R $USER:www-data storage
RUN chown -R $USER:www-data bootstrap/cache
RUN chmod -R 775 storage
RUN chmod -R 775 bootstrap/cache
# RUN chmod -R guo+w storage

# Настройка Apache для работы с public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite
