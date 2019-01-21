<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AuthorizeDeviceNotification extends Notification implements ShouldQueue
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
        $location = $this->data['city'] . ', ' . $this->data['country_name'];

        return (new MailMessage)
            ->markdown('emails.default', [
                'antiPhishingCode'    => $antiPhishingCode,
                'disableAccountToken' => $disableAccountToken,
                'email'               => $notifiable->email
            ])
            ->success()
            ->subject(__(':app_name - Authorize New Device', ['app_name' => config('app.name')]))
            ->greeting(__('Authorize New Device'))
            ->line(__('You recently attempted to sign into your :app_name account from a new device or in a new location. As a security measure, we require additional confirmation before allowing access to your :app_name account.',
                ['app_name' => config('app.name')]))
            ->line('Location: ' . $location . '<br>' .
                'Device: ' . $device . '<br>' .
                'Time: ' . now()->format('Y-m-d H:i:s') . ' (UTC)<br>' .
                'Ip Address: <a href="https://www.ip-adress.com/ip-address/ipv4/' . $this->data['ip'] . '">' .
                $this->data['ip'] . '</a>')
            ->action(__('Authorize New Device'), url('/authorize-device/' . $this->data['authorization_token']));
    }
}
