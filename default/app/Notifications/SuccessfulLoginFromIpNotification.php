<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuccessfulLoginFromIpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;

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

        $antiPhishingCode = $notifiable->profile->anti_phishing_code;
        $disableAccountToken = $notifiable->profile->email_token_disable_account;
        $device = $this->data['browser'] . ' ' . $this->data['browser_version'] . ' (' . $this->data['platform'] . ')';

        return (new MailMessage)
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email
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
