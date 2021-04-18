<?php

namespace App\Domain\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AuthorizeDeviceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private array $data)
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
        $device = $this->data['browser'] . ' ' . $this->data['browser_version'] . ' (' . $this->data['platform'] . ')';
        $location = $this->data['city'] . ', ' . $this->data['country_name'];

        return (new MailMessage())
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email,
            ])
            ->success()
            ->subject(__(':app_name - Authorize New Device', ['app_name' => config('app.name')]))
            ->greeting(__('Authorize New Device'))
            ->line(__(
                'You recently attempted to sign into your :app_name account from a new device or in a new location. ' .
                'As a security measure, we require additional confirmation before allowing access to your ' .
                ':app_name account.',
                ['app_name' => config('app.name')]
            ))
            ->line('Location: ' . $location . '<br>' .
                'Device: ' . $device . '<br>' .
                'Time: ' . now()->format('Y-m-d H:i:s') . ' (UTC)<br>' .
                'Ip Address: <a href="https://www.ip-adress.com/ip-address/ipv4/' . $this->data['ip'] . '">' .
                $this->data['ip'] . '</a>')
            ->action(__('Authorize New Device'), url('/authorize-device/' . $this->data['authorization_token']));
    }
}
