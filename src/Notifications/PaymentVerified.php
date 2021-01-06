<?php

namespace Zareismail\Strandprofile\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;
use Mirovit\NovaNotifications\Notification as Messages;

class PaymentVerified extends Notification
{
    use Queueable;

    /**
     * The Maturity data.
     * 
     * @var array
     */
    public $maturity;

    /**
     * The Announcement data.
     * 
     * @var array
     */
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($maturity, array $data)
    {
        $this->maturity = $maturity;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return Messages::make() 
                ->success(__('The installment #:installment was paid', [
                    'installment' => $this->maturity->installment
                ])) 
                ->subtitle(__('Click to see your payment receipt')) 
                ->link($this->data['receipt_url'], true)
                ->showMarkAsRead()
                ->toArray();
    }
}
