<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $token;

    /**
     * Create a new notification instance.
     *
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     **
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->locale);

        return (new MailMessage)
            ->markdown('emails.default')
            ->success()
            ->subject(__(':app_name - Confirm your registration', ['app_name' => config('app.name')]))
            ->greeting(__('Welcome to :app_name', ['app_name' => config('app.name')]))
            ->line(__('Click the link below to complete verification:'))
            ->action(__('Verify Email'), url('/users/verify/' . $this->token))
            ->line('<b>' . __('Security Tips') . '</b>')
            ->line('<small>' . __('DO NOT give your password to anyone!') . '<br>' .
                __('Enable Two Factor Authentication!') . '<br>' .
                __('Make sure you are visiting :app_url', ['app_url' => config('app.url')]) . '</small>');
    }
}
