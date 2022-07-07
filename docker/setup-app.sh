#!/bin/bash

APACHE_DOCUMENT_ROOT=/var/www/html/public

export DEBIAN_FRONTEND=noninteractive

sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
sed -i 's/AllowOverride\ None/AllowOverride\ All/g' /etc/apache2/apache2.conf

# Enable Apache rewrite module
a2enmod rewrite expires
