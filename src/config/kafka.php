<?php
return [
    'brokers' => env('KAFKA_BROKERS', 'localhost:9092'), // Kafka brokers
    'consumer' => [
        'group_id' => env('KAFKA_CONSUMER_GROUP_ID', 'laravel-consumer-group'),
    ],
    'producer' => [
        'acks' => env('KAFKA_ACKS', 'all'), // Number of acknowledgments
        'delivery_timeout' => env('KAFKA_DELIVERY_TIMEOUT', 60),
    ],
    'topic' => env('KAFKA_TOPIC', 'default-topic'),
    'additional_config' => [
        'api.version.request' => false,
        'broker.version.fallback' => '2.1.0', // Or whatever version your broker is
    ],

];
