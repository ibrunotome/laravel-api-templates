<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuccessfulLoginFromIpNotification extends Notification implements ShouldQueue
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

        return (new MailMessage())
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email,
            ])
            ->subject(__(':app_name - Successful Login From New IP', ['app_name' => config('app.name')]))
            ->greeting(__('Successful Login From New IP'))
            ->line(__('The system has detected that your account made a successful login:'))
            ->line('Email: ' . $notifiable->email . '<br>' .
                'Device: ' . $device . '<br>' .
                'Time: ' . now()->format('Y-m-d H:i:s') . ' (UTC)<br>' .
                'Ip Address: <a href="https://www.ip-adress.com/ip-address/ipv4/' . $this->data['ip'] . '">' .
                $this->data['ip'] . '</a>');
    }
}
