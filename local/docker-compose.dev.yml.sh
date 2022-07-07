# Compose is a tool for defining and running multi-container Docker applications.
# With Compose, you use a YAML file to configure your application’s services.
# Then, with a single command, you create and start all the services from your configuration.

#!/bin/bash
cat <<-EOF
version: '3.8'

services:
  ${APP_NAME}:
    image: ${APP_NAME}/${IMAGE_NAME}
    ports:
      - published: ${APP_PORT_PREFIX}080
        target: 80
        protocol: tcp
        mode: host
    volumes:
      - ${LOGS}:/var/log/apache2
      - ${LARAVEL_STORAGE}:/var/www/html/storage
      - ${PHP_SESSIONS}:/var/lib/php/sessions
      - /etc/hosts:/var/hosts
      - ${APP_DIR}/src:/var/www/html
    deploy:
      replicas: 1
    secrets:
      - source: queue-system-secrets-env
        target: queue-system-secrets-env
secrets:
  queue-system-secrets-env:
       external: true    
EOF