<?php

// app/Services/KafkaProducerService.php
namespace App\Services;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;

class KafkaProducerService
{
    public function produceMessage($message)
    {
        for ($i = 0; $i < 100; $i++) {
            $message = new Message(
                headers: [],
                key: 'user-key_' . $i,
                body: ['event' => 'user_registered']
            );

            Kafka::publishOn('Laravel-App')
                ->withMessage($message)
                ->send();
        }
    }
}
