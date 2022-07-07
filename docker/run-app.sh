#!/bin/bash

# Create standard directories which Laravel needs to write the cache, logs, sessions and views data
mkdir -p /var/www/html/storage/{app,framework/{cache,sessions,testing,views},logs,bootstrap/{cache}}

# Change ownerships of the above created directories so that the application can write the data
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# remove the .env file within the Laravel framework
rm /var/www/html/.env

# Copy the secrets data from the secrets file and paste it on the .env
cat /run/secrets/queue-system-secrets-env >> /var/www/html/.env

# Run Apache:
&>/dev/stdout /usr/sbin/apachectl -DFOREGROUND -k start
