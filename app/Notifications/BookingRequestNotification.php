<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingStatusNotification extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
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
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Booking Status Update')
            ->greeting('Hello ' . $notifiable->name)
            ->line("Your booking for {$this->booking->listing->title} has been {$this->booking->status}.")
            ->line("Check‑in: {$this->booking->check_in->format('M d, Y')}")
            ->line("Check‑out: {$this->booking->check_out->format('M d, Y')}")
            ->action('View My Trips', route('guest.bookings.index'))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification (for database storage).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'message'       => 'Booking status updated',
            'booking_id'    => $this->booking->id,
            'listing_title' => $this->booking->listing->title,
            'status'        => $this->booking->status,
            'check_in'      => $this->booking->check_in,
            'check_out'     => $this->booking->check_out,
        ];
    }
}

