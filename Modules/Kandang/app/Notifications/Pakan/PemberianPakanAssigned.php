<?php

namespace Modules\Kandang\Notifications\Pakan;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Kandang\Models\PerhitunganPakan;

class PemberianPakanAssigned extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private PerhitunganPakan $perhitunganPakan,
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', 'https://laravel.com')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        $namaKandang = $this->perhitunganPakan->kandang->nama;
        $tanggalPemberian = $this->perhitunganPakan->tanggal_pemberian_pakan->translatedFormat('l, d F Y');
        return [
            'title'     => 'Pemberian Pakan',
            'message'   => "Anda ditugaskan untuk memberian pakan pada kandang $namaKandang pada $tanggalPemberian.",
            'url'       => route('pemberian-pakan-sisa-pakan.edit', $this->perhitunganPakan->id),
            'icon'      => 'fas fa-clipboard-list'
        ];
    }
}
