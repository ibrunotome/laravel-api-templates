<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorAuthenticationWasDisabledNotification extends Notification implements ShouldQueue
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
            ->subject(__(':app_name - Two Factor Authentication Disabled', ['app_name' => config('app.name')]))
            ->greeting(__('Two Factor Authentication Disabled'))
            ->line(
                __(
                    'Your 2FA (Two Factor Authentication) was disabled. ' .
                    'The withdrawal function is not available in 24h.'
                )
            );
    }
}
