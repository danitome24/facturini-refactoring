#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git mysql-client zip -yqq

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install pdo_mysql mysqli

mysql --user=gitlabci --password="$MYSQL_PASSWORD" --host=mysql "$MYSQL_DATABASE"
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD -e "use $MYSQL_DATABASE"
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE  < db/factura.sql

php -S 0.0.0.0:80 -t . &> /dev/null &
