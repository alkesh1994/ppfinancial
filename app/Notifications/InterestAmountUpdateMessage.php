<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class InterestAmountUpdateMessage extends Notification
{
    use Queueable;

    private $clientFullName;
    private $interestAmount;
    private $interestMonth;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($clientFullName,$interestAmount,$interestMonth)
    {
        $this->clientFullName = $clientFullName;
        $this->interestAmount = $interestAmount;
        $this->interestMonth = $interestMonth;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
     public function toNexmo($notifiable)
     {
         $message = 'Dear '.$this->clientFullName.',your interest amount Rs'.$this->interestAmount.' for '.$this->interestMonth.' has been deposited to your account.For any queries please contact Tushar Nikam - +91-8976620915';
         return (new NexmoMessage)
                     ->content($message);
     }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
          //
        ];
    }
}
