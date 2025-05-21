#!/bin/bash

set -e
set -x

cd /var/www/html

# Instala WP CLI si no existe
if ! command -v wp &> /dev/null; then
  curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x wp-cli.phar && \
  mv wp-cli.phar /usr/local/bin/wp
fi

# Espera hasta que MySQL esté disponible
echo "⌛ Esperando conexión a la base de datos..."
for i in {1..10}; do
  if wp db check --allow-root; then
    echo "✅ Base de datos disponible"
    break
  else
    echo "⏳ Intento $i: Base de datos no disponible aún..."
    sleep 5
  fi
done

# Si WordPress no está instalado, instalarlo con datos dummy
if ! wp core is-installed --allow-root; then
  wp core install \
    --url="http://localhost" \
    --title="WordPress Cloud Run" \
    --admin_user=admin \
    --admin_password=admin \
    --admin_email=admin@example.com \
    --skip-email \
    --allow-root
fi

# Activar plugins si están definidos
if [ -n "$PLUGINS" ]; then
  for plugin in $PLUGINS; do
    if wp plugin is-installed "$plugin" --allow-root; then
      wp plugin activate "$plugin" --allow-root || echo "⚠️ No se pudo activar $plugin"
    else
      echo "❌ Plugin no encontrado: $plugin"
    fi
  done
fi

# Activar tema si están definidos
if [ -n "$THEMES" ]; then
  for theme in $THEMES; do
    if wp theme is-installed "$theme" --allow-root; then
      wp theme activate "$theme" --allow-root || echo "⚠️ No se pudo activar el tema $theme"
    else
      echo "❌ Tema no encontrado: $theme"
    fi
  done
fi

# Iniciar Apache
exec apache2-foreground
