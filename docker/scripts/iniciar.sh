#!/bin/bash

if [[ -f "/var/www/html/.env" && -f "/var/www/html/libs/db_conn.php" ]]; then

    if [[ ! -z "${DB_USUARIO:-}" ]]; then
        sed -i "s|^\$DB_USUARIO.*|\$DB_USUARIO = \"${DB_USUARIO}\"; //|g" /var/www/html/libs/db_conn.php
        sed -i "s|^DB_USERNAME.*|DB_USERNAME=${DB_USUARIO}|g" /var/www/html/.env
    fi

    if [[ ! -z "${DB_SENHA:-}" ]]; then
        sed -i "s|^\$DB_SENHA.*|\$DB_SENHA = \"${DB_SENHA}\"; //|g" /var/www/html/libs/db_conn.php
        sed -i "s|^DB_PASSWORD.*|DB_PASSWORD=${DB_SENHA}|g" /var/www/html/.env
    fi

    if [[ ! -z "${DB_SERVIDOR:-}" ]]; then
        sed -i "s|^\$DB_SERVIDOR.*|\$DB_SERVIDOR = \"${DB_SERVIDOR}\"; //|g" /var/www/html/libs/db_conn.php
        sed -i "s|^DB_HOST.*|DB_HOST=${DB_SERVIDOR}|g" /var/www/html/.env
    fi

    if [[ ! -z "${DB_PORTA:-}" ]]; then
        sed -i "s|^\$DB_PORTA\ .*|\$DB_PORTA = \"${DB_PORTA}\"; //|g" /var/www/html/libs/db_conn.php
        sed -i "s|^\$DB_PORTA_ALT.*|\$DB_PORTA_ALT = \"${DB_PORTA}\"; //|g" /var/www/html/libs/db_conn.php
        sed -i "s|^DB_PORT.*|DB_PORT=${DB_PORTA}|g" /var/www/html/.env
    fi

    if [[ ! -z "${DB_BASE:-}" ]]; then
        sed -i "s|^\$DB_BASE.*|\$DB_BASE = \"${DB_BASE}\"; //|g" /var/www/html/libs/db_conn.php
        sed -i "s|^DB_DATABASE.*|DB_DATABASE=${DB_BASE}|g" /var/www/html/.env
    fi

fi

# Habilita o vhost do e-cidade no apache2
sudo a2ensite ecidade.conf

#: ${WWW_UID:=33}
#: ${WWW_GID:=33}

# Mapeia o usu·rio e grupo do apache caso tenham sido configurados
# via vari√°vel de ambiente
#usermod -u $WWW_UID www-data
#groupmod -g $WWW_GID www-data

#sudo chown -R contass:www-data "$PWD"
#sudo chmod -R 775 "$PWD"

DB_CONN_DIST_FILE=libs/db_conn.php.dist
DB_CONN_FILE=libs/db_conn.php
if [ -f "$DB_CONN_DIST_FILE" ] && ! [ -f "$DB_CONN_FILE" ]; then
    cp libs/db_conn.php.dist libs/db_conn.php
fi

COMPOSER_FILE=composer.json
if [ -f "$COMPOSER_FILE" ]; then
    composer install
fi

# Inicializa o supervisord
exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
