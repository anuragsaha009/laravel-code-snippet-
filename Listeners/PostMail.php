<?php

namespace App\Listeners;

use App\Events\PostEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\PostNotification;
use Mail;

class PostMail
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
     * @param  PostEvent  $event
     * @return void
     */
    public function handle(PostEvent $event)
    {   
        $to = 'karmicksol213@gmail.com';
        Mail::to($to)->send(new PostNotification($event->post));
    }
}
