<?php

namespace App\Domain\Users\Notifications;

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

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $antiPhishingCode = $notifiable->anti_phishing_code;
        $supportLink = config('app.support_url');

        return (new MailMessage())
            ->markdown('emails.default', ['antiPhishingCode' => $antiPhishingCode])
            ->subject('Account disabled')
            ->line(__(
                'Your account has been disabled, to enable it again, please contact ' .
                ':support_link to start the process.',
                ['support_link' => '<a href="' . $supportLink . '">' . $supportLink . '</a>']
            ));
    }
}
