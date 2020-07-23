<?php

namespace App\Infrastructure\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

abstract class Notification extends \Illuminate\Notifications\Notification implements ShouldQueue
{
    use Queueable;

    public array $data;

    protected string $title;

    protected string $message;

    protected string $url;

    protected string $color;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return [
            'mail',
            'broadcast',
            'database',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'url'     => $this->url,
            'color'   => $this->color,
        ];
    }
}
