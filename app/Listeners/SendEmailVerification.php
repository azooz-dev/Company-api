<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Jobs\SendEmailVerification as JobsSendEmailVerification;
use App\Mail\VerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        dispatch(new JobsSendEmailVerification($event->user));
    }
}
