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
        $status = ucfirst($this->booking->status);
        $subject = "Booking {$status}";

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $notifiable->name)
            ->line("Your booking request for {$this->booking->listing->title} has been {$this->booking->status}.")
            ->line("Check-in: " . \Carbon\Carbon::parse($this->booking->start_date)->format('M d, Y'))
            ->line("Check-out: " . \Carbon\Carbon::parse($this->booking->end_date)->format('M d, Y'))
            ->line("Total Price: \${$this->booking->total_price}");

        if ($this->booking->status === 'approved') {
            $mailMessage->action('View Booking Details', route('dashboard'))
                ->line('We look forward to hosting you!');
        } else {
            $mailMessage->line('You can search for other available properties.');
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification (for database storage).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        $statusText = $this->booking->status === 'approved' ? 'approved' : 'declined';
        
        return [
            'message'       => "Your booking for {$this->booking->listing->title} has been {$statusText}",
            'booking_id'    => $this->booking->id,
            'listing_title' => $this->booking->listing->title,
            'status'        => $this->booking->status,
            'check_in'      => $this->booking->start_date,
            'check_out'     => $this->booking->end_date,
        ];
    }
}
