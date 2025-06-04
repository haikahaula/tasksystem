<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskStatusChanged extends Notification
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
            ->subject('Task Status Updated')
            ->line('The task "' . $this->task->title . '" status has been updated to: ' . ucfirst($this->task->status))
            ->action('View Task', url('/tasks/' . $this->task->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Task "' . $this->task->title . '" status changed to ' . ucfirst($this->task->status),
            'task_id' => $this->task->id,
        ];
    }
}
