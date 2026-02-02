FROM wordpress:latest
WORKDIR /var/www/html
COPY --chown=www-data:www-data . ./wp-content/themes/arianna
EXPOSE 80