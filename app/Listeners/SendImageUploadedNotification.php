<?php

namespace App\Listeners;

use App\Events\ImageUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailSendEvent;

class SendImageUploadedNotification
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
    public function handle(ImageUploaded $event): void
    {
        //
        Mail::to(auth()->user())->send(new mailSendEvent($event->image));
    }
}
