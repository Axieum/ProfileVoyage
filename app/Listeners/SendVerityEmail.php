<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Mail\EmailVerity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendVerityEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        Mail::to($event->user->email)->send(new EmailVerity($event->user));
    }
}
