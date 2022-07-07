#!/bin/bash 

#Configuration
source local/conf.sh

export APP_NAME=queue-system

docker stack rm $APP_NAME

if [[ 0 -ne $(docker secret ls -q -f name=queue-system-secrets-env | wc -l) ]]
then
  docker secret rm queue-system-secrets-env
fi