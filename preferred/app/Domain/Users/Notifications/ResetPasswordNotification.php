<?php

namespace Preferred\Domain\Users\Notifications;

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
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        app()->setLocale($notifiable->locale);

        if (!empty($notifiable->profile)) {
            $antiPhishingCode = $notifiable->profile->anti_phishing_code;
            $disableAccountToken = $notifiable->profile->email_token_disable_account;
        } else {
            $antiPhishingCode = null;
            $disableAccountToken = null;
        }

        return (new MailMessage)
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email
            ])
            ->level('warning')
            ->subject(__(':app_name - Reset password', ['app_name' => config('app.name')]))
            ->greeting(__('Reset password'))
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(__('Reset password'),
                url('/password/reset/' . $this->token) . '?email=' . urlencode($notifiable->email));
    }
}
