<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->line('Welcome to Dueño Directo - Your Ideal Platform to Connect with Potential Tenants!')
                    ->line('Dear '. $notifiable->email)
                    ->line('Congratulations on joining Dueño Directo, your one-stop platform for connecting with quality tenants effortlessly. As an esteemed property owner, you are now part of our vibrant community, where we aim to make the rental process simple, secure, and efficient.')
                    ->line('Benefits of Using Dueño Directo as an Owner:')
                    ->line('Hassle-Free Listing: Listing your property on Dueño Directo is a breeze! Our intuitive interface allows you to create appealing property listings with all the essential details, attracting potential tenants swiftly.')
                    ->line('Direct Communication: Communicate directly with potential tenants through our secure messaging system. Eliminate intermediaries and have full control over your conversations, ensuring transparency and prompt responses.')
                    ->line('Verified Tenants: We conduct rigorous background checks to verify the authenticity of potential tenants, giving you peace of mind in finding reliable renters for your valuable property.')
                    ->line('Lease Agreement Management: Create and manage lease agreements online with ease. Our platform provides tools to generate legally compliant lease contracts, streamlining the entire rental process.')
                    ->line('Expert Support: Our support team is here to assist you at every step. If you have any questions or need guidance, feel free to reach out to us at [support@email.com].')
                    ->line('We are thrilled to have you on board, and we are confident that your experience with Dueño Directo will be exceptional. Log in to your account now and start connecting with potential tenants who are looking for properties like yours!')
                    ->line('Thank you for choosing Dueño Directo as your trusted rental partner. We are committed to providing you with the best experience possible.')
                    ->line('Best regards,')
                    ->line('The Dueño Directo Team')
                    ->action('Visit us at', url('/'));
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
