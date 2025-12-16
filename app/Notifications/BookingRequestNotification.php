<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingRequestNotification extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $booking
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Send both email and database notifications
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Booking Request')
            ->line('You have received a new booking request.')
            ->line('Property ID: ' . $this->booking->property_id)
            ->line('Guest ID: ' . $this->booking->guest_id)
            ->action('View Booking', url('/dashboard'))
            ->line('Thank you for using HomeAway!');
    }

    /**
     * Get the array representation of the notification (for database storage).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message'     => 'New booking request received',
            'booking_id'  => $this->booking->id,
            'guest_id'    => $this->booking->guest_id,
            'property_id' => $this->booking->property_id,
            'status'      => $this->booking->status,
        ];
    }
}
