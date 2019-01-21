<?php

namespace Preferred\Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountDisabledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->locale);

        $antiPhishingCode = $notifiable->profile->anti_phishing_code;

        return (new MailMessage)
            ->markdown('emails.default', ['antiPhishingCode' => $antiPhishingCode])
            ->subject('Account disabled')
            ->line(__('Your account has been disabled, to enable it again, please contact :support_link to start the process.',
                ['support_link' => '<a href="' . config('app.support_url') . '">' . config('app.support_url') . '</a>']));
    }
}
