<?php

namespace Zareismail\Strandprofile\Notifications;
  
use Illuminate\Notifications\Notification;
use Mirovit\NovaNotifications\Notification as Messages;

class IdentityVerification extends Notification
{ 
    /**
     * The user instance.
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                ->error(__('The landlord :user wants you verify your identity', [
                    'user' => request()->user()->fullname(),
                ])) 
                ->subtitle(__('Click to update your identity information.')) 
                ->routeEdit(\Zareismail\Strandprofile\Nova\Verification::uriKey(), $notifiable->id)
                ->showMarkAsRead()
                ->toArray();
    }
}
