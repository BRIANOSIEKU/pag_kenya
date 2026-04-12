<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PastoralTransferCreated extends Notification
{
    use Queueable;

    public $transfer;

    public function __construct($transfer)
    {
        $this->transfer = $transfer;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Pastoral Transfer Request',
            'message' => 'A transfer has been initiated and requires your attention.',
            'transfer_id' => $this->transfer->id,
        ];
    }
}