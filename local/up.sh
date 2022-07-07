#!/bin/bash

# Configuration => If the conf.sh doesn't exist 
# then copy the empty contents from conf.template.sh and create a conf.sh file
if [[ ! -f local/conf.sh ]]
then
  cp local/conf.template.sh local/conf.sh
fi

source local/conf.sh

# Local variables
export APP_NAME=queue-system
export IMAGE_NAME=queue-system

# App URL
export APP_URL=http://localhost:${APP_PORT_PREFIX}080/

# Volume
# DataBase
export DB_CONNECTION=mysql
export LOGS=$MOUNT_DIR/$APP_NAME/logs
export LARAVEL_STORAGE=$MOUNT_DIR/$APP_NAME/storage
export PHP_SESSIONS=$MOUNT_DIR/$APP_NAME/sessions

# Remove the secret if it already exists
local/down.sh

# Load a Docker Secret for env variables and secrets
cat <<EOF | docker secret create queue-system-secrets-env -
# Hardcoded
APP_KEY=base64:BVy+zPCsr0txvac/p94FDs5IKXJ4WNSPxQYEE6mPuIc=
APP_ENV=local
APP_DEBUG=true
APP_URL=$APP_URL
DB_CONNECTION=$DB_CONNECTION
DB_HOST=$HOST_ADDRESS
DB_DATABASE=$DB_NAME
DB_USERNAME=$DB_USER
DB_PASSWORD=$DB_PASS
MAIL_USERNAME=$MAIL_USERNAME
MAIL_FROM_NAME=$MAIL_FROM_NAME
MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS
MAIL_PASSWORD=$MAIL_PASSWORD
MAIL_HOST=$MAIL_HOST
EOF

# Build the docker images
docker build --no-cache -t "${APP_NAME}/${IMAGE_NAME}" -f local/Dockerfile.dev .

# Create directories
mkdir -p "${LOGS}" "${LARAVEL_STORAGE}" "${PHP_SESSIONS}" 

chmod u+x local/docker-compose.dev.yml.sh

echo ${MOUNT_DIR}/${APP_NAME}/docker-compose.dev.yml

# Dump Configuration to file
local/docker-compose.dev.yml.sh > ${MOUNT_DIR}/${APP_NAME}/docker-compose.dev.yml

# Deploy the Stack
docker stack deploy --with-registry-auth -c ${MOUNT_DIR}/${APP_NAME}/docker-compose.dev.yml ${APP_NAME}