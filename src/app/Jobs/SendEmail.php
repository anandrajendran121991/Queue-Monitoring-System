<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The maximum number of exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 10;

    /**
     * @var $name
     */
    public $name;

    /**
     * @var $from
     */
    public $from;

    /**
     * @var $template
     */
    public $template;

    /**
     * @var $emailData
     */
    public $emailData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->from = $emailData['contactEmail'];
        $this->name = "Test";
        $this->template = $emailData['template'];
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send($this->template, $this->emailData, function ($message)
        {
            $message->from($this->from, $this->name)
                ->to($this->emailData['to'])
                ->subject($this->emailData['subject']);

                if (isset($this->emailData['cc'])) {
                    $message->cc([$this->emailData['cc']]);
                }
        });
    }
}
