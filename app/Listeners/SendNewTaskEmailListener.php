<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTaskEmail;
use App\Events\NewTaskEmailEvent;

class SendNewTaskEmailListener
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
    public function handle(NewTaskEmailEvent $event): void
    {
        $task = $event->task;
        Mail::to('testas@test.lt')->send(new NewTaskEmail());
    }
}
