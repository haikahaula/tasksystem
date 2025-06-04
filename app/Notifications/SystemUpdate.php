<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SystemUpdate extends Notification
{
    use Queueable;

    public $details;

    public function __construct(string $details)
    {
        $this->details = $details;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('System Update Notification')
            ->line($this->details)
            ->action('Check Updates', url('/'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'System update: ' . $this->details,
        ];
    }
}
