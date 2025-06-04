<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskAssigned extends Notification
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned')
            ->line('A new task "' . $this->task->title . '" has been assigned to you.')
            ->action('View Task', url('/tasks/' . $this->task->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'A new task "' . $this->task->title . '" has been assigned to you.',
            'task_id' => $this->task->id,
        ];
    }
}
