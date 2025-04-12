# Используем официальный образ PHP с Apache
FROM php:8.1-apache

# Копируем файлы приложения в директорию веб-сервера
COPY . /var/www/html/

# Настраиваем права доступа (при необходимости)
RUN chown -R www-data:www-data /var/www/html/

# Экспонируем порт 80
EXPOSE 80
