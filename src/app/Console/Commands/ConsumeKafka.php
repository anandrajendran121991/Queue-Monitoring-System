<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\KafkaConsumerService;

class ConsumeKafka extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:consume {topic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from Kafka topic';

    public function handle(KafkaConsumerService $consumerService)
    {
        $topic = $this->argument('topic');
        $this->info("Starting consumer for topic: $topic");
        $consumerService->consume($topic);
    }
}
