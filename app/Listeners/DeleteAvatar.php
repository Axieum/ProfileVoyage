<?php

namespace App\Listeners;

use App\Events\ProfileDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DeleteAvatar implements ShouldQueue
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
     * @param  ProfileDeleted  $event
     * @return void
     */
    public function handle(ProfileDeleted $event)
    {
        Storage::delete('public\\avatars\\' . $event->avatar . '.png');
    }
}
