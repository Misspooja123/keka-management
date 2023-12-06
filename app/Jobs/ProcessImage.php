<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ImageUploaded;
use Illuminate\Support\Facades\Mail;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image;

    public function __construct($image)
    {
        $this->image = $image;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // Process the image here, if needed.

        // Send an email notification.
        Mail::to(auth()->user()->email)->send(new ImageUploaded());
    }
}
