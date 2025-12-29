# Gunakan PHP versi 8.2 dengan Apache (Server)
FROM php:8.2-apache

# Install unzip (diperlukan jika nanti pakai Composer)
RUN apt-get update && apt-get install -y unzip

# Aktifkan mod_rewrite (agar URL cantik/bersih berfungsi)
RUN a2enmod rewrite

# Setting folder public sebagai root (sesuai struktur Anda)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy semua file kode Anda ke dalam server
COPY . /var/www/html

# Install library (Hanya jika Anda punya file composer.json)
# Jika tidak pakai composer, Render akan mengabaikan error baris ini atau Anda bisa menghapusnya
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN if [ -f composer.json ]; then composer install --no-dev --optimize-autoloader; fi

# Buka port 80 (Standar web)
EXPOSE 80