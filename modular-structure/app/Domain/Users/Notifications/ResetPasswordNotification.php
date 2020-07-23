<?php

namespace App\Domain\Users\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(string $token)
    {
        parent::__construct($token);
        $this->onQueue('notifications');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * {@inheritdoc}
     */
    public function toMail($notifiable)
    {
        $antiPhishingCode = $notifiable->anti_phishing_code ?? null;
        $disableAccountToken = $notifiable->email_token_disable_account ?? null;

        return (new MailMessage())
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email,
            ])
            ->level('warning')
            ->subject(__(':app_name - Reset password', ['app_name' => config('app.name')]))
            ->greeting(__('Reset password'))
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(
                __('Reset password'),
                url('/password/reset/' . $this->token) . '?email=' . urlencode($notifiable->email)
            );
    }
}
