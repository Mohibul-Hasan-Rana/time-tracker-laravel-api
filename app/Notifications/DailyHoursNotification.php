<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailyHoursNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $totalHours;

    /**
     * Create a new notification instance.
     */
    public function __construct($totalHours)
    {
        $this->totalHours = $totalHours;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Daily Time Log Summary')
            ->line("You've logged {$this->totalHours} hours today.")
            ->line('See you tommorrow.')
            ->action('View Time Logs', url('api/time-logs'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
