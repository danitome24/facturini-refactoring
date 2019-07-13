#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

apt-get update -yqq
apt-get install mysql-client libmysqlclient-dev -yqq

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install pdo_mysql mysqli

mysql --user=gitlabci --password="$MYSQL_PASSWORD" --host=mysql "$MYSQL_DATABASE"
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD -e "use $MYSQL_DATABASE"
mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE  < db/factura.sql

php -S 0.0.0.0:80 -t . &> /dev/null &
