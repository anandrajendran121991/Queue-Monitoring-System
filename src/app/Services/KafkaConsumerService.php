<?php

namespace App\Services;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaConsumerService
{
    public function consume(string $topic): void
    {
        Kafka::createConsumer()
            ->subscribe($topic)
            ->withConsumerGroupId('laravel-consumer-group') // Must be unique or reused intentionally
            ->withHandler(function (KafkaConsumerMessage $message) {
                // Log or process the message
                logger()->info('Received message from Kafka', [
                    'topic' => $message->getTopicName(),
                    'payload' => $message->getBody(),
                ]);

                // You can also dispatch Laravel jobs or events here
            })
            ->build()
            ->consume();
    }
}
