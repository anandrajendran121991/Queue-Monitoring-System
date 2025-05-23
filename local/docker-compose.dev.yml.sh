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
    networks:
      - kafka-net
  
  kafka:
    image: bitnami/kafka:latest
    ports:
      - "9092:9092"
    environment:
      - KAFKA_CFG_PROCESS_ROLES=broker,controller
      - KAFKA_CFG_NODE_ID=1
      - KAFKA_CFG_CONTROLLER_QUORUM_VOTERS=1@kafka:9093
      - KAFKA_CFG_LISTENERS=PLAINTEXT://:9092,CONTROLLER://:9093
      - KAFKA_CFG_LISTENER_SECURITY_PROTOCOL_MAP=CONTROLLER:PLAINTEXT,PLAINTEXT:PLAINTEXT
      - KAFKA_CFG_CONTROLLER_LISTENER_NAMES=CONTROLLER
      - KAFKA_CFG_ADVERTISED_LISTENERS=PLAINTEXT://kafka:9092
      - ALLOW_PLAINTEXT_LISTENER=yes
    networks:
      - kafka-net
  
  kafka-ui:
    image: provectuslabs/kafka-ui:latest
    container_name: kafka-ui
    ports:
      - "8080:8080"
    environment:
      - KAFKA_CLUSTERS_0_NAME=local
      - KAFKA_CLUSTERS_0_BOOTSTRAPSERVERS=kafka:9092
    depends_on:
      - kafka
    networks:
      - kafka-net

networks:
  kafka-net:
    driver: overlay  # Using overlay for Docker Swarm, if applicable
secrets:
  queue-system-secrets-env:
       external: true    
EOF