FROM php:8.2-apache


# Instala dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    wget \
    less \
    mariadb-client \
 && docker-php-ext-install mysqli

COPY custom-ports.conf /etc/apache2/ports.conf
RUN sed -i 's/<VirtualHost \\*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

# Crea el punto de montaje del socket
RUN mkdir -p /cloudsql && chown www-data:www-data /cloudsql

# Descarga e instala WordPress

WORKDIR /var/www/html
RUN wget https://wordpress.org/latest.tar.gz && \
    tar -xzf latest.tar.gz --strip-components=1 && \
    rm latest.tar.gz

# Variables de plugins y temas
#estos siempre se deben poner en la variable themes
ARG PLUGINS="elementor wpforms-lite wp-stateless-elementor wp-stateless-wpforms header-footer-elementor wp-stateless custom-fonts wordpress-importer all-in-one-wp-migration"
ENV PLUGINS=$PLUGINS

ARG THEMES="astra"
ENV THEMES=$THEMES

# Instala plugins desde WordPress.org
RUN for plugin in $PLUGINS; do \
      curl -LO https://downloads.wordpress.org/plugin/${plugin}.latest-stable.zip && \
      unzip ${plugin}.latest-stable.zip -d /var/www/html/wp-content/plugins && \
      rm ${plugin}.latest-stable.zip; \
    done

# Instala temas desde WordPress.org
RUN for theme in $THEMES; do \
      curl -LO https://downloads.wordpress.org/theme/${theme}.latest-stable.zip && \
      unzip ${theme}.latest-stable.zip -d /var/www/html/wp-content/themes && \
      rm ${theme}.latest-stable.zip; \
    done

# Copia archivos personalizados
COPY themes/astra-child /var/www/html/wp-content/themes/astra-child
# increase to 24 mb
COPY php.ini /usr/local/etc/php/conf.d/uploads.ini
COPY wp-config.php /var/www/html/wp-config.php
COPY entrypoint.sh /entrypoint.sh
COPY stateless-diagnostic.php /var/www/html/stateless-diagnostic.php

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
