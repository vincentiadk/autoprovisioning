<?php

namespace App\Notifications;

//use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\UserNotification;

class RealTimeNotification extends Notification implements ShouldBroadcastNow
{
    public string $message;
    public string $event;

    public function __construct(string $message, string $event)
    {
        $this->message = $message;
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        $notification = UserNotification::create([
            'user_id' => $notifiable->id,
            'message' => $this->message
        ])->id;

        return new BroadcastMessage([
            'message' => "$this->message",
            'event' => "$this->event",
            'notification' => [
                UserNotification::with('user')->find($notification)]
        ]);

    }
}
