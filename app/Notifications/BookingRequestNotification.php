<?php

namespace App\Notifications;

use App\Models\Booking;
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
            ->subject('New Booking Request')
            ->greeting('Hello ' . $notifiable->name)
            ->line("You have received a new booking request for {$this->booking->listing->title}.")
            ->line("Check-in: " . \Carbon\Carbon::parse($this->booking->start_date)->format('M d, Y'))
            ->line("Check-out: " . \Carbon\Carbon::parse($this->booking->end_date)->format('M d, Y'))
            ->line("Guests: {$this->booking->number_of_guests}")
            ->line("Total Price: \${$this->booking->total_price}")
            ->action('View Booking', route('dashboard'))
            ->line('Please review and respond to this booking request.');
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
            'message'       => 'New booking request',
            'booking_id'    => $this->booking->id,
            'listing_title' => $this->booking->listing->title,
            'status'        => $this->booking->status,
            'check_in'      => $this->booking->start_date,
            'check_out'     => $this->booking->end_date,
        ];
    }
}

