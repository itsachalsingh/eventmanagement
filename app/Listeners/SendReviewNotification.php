<?php

namespace App\Listeners;

use App\Events\ReviewSubmitted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewNotification;

class SendReviewNotification implements ShouldQueue
{

    use InteractsWithQueue;

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
    public function handle(ReviewSubmitted $event)
    {
        try {
            Mail::to($event->proposal->speaker->email)->send(
                new ReviewNotification($event->review, $event->proposal)
            );
        } catch (\Exception $e) {
            // Log the error for debugging but don’t interrupt the main flow
            \Log::error('Failed to send review notification email: ' . $e->getMessage());
        }
    }
}
