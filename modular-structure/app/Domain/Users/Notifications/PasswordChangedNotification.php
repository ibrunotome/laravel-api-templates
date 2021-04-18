<?php

namespace App\Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification implements ShouldQueue
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
        $disableAccountToken = $notifiable->email_token_disable_account;

        return (new MailMessage())
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email,
            ])
            ->subject(__(':app_name - Password Changed', ['app_name' => config('app.name')]))
            ->greeting(__('Password Changed'))
            ->line(__('Your password has been changed. The withdrawal function is not available in 24h.'));
    }
}
