<?php

namespace App\Notifications;

use App\Model\Tool;
use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentPosted extends Notification
{
    use Queueable;

    protected $user;
    protected $tool;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Tool $tool, User $user)
    {
        $this->tool = $tool;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [ 
            'toolTitle' => $this->tool->title,
            'toolId' => $this->tool->id,
            'lastname' => $this->user->lastname
        ];
    }
}
