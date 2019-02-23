FROM php:7.3-apache

#Installs
RUN apt update && apt install git vim -y

#Configuring a Web Server to run Symfony 4
#ADD 000-default.conf /etc/apache2/sites-available/000-default.conf

#Enable pdo and pdo_mysql extensions
RUN docker-php-ext-install mysqli

#Set uid and gid 1000 for www-data (I assume that my user on host have id 1000)
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

#Enable mod_rewrite
RUN a2enmod rewrite

#Enable xdebug. This must be enable ONLY for dev purposes
#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug

#Set Spain's datetime
ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
