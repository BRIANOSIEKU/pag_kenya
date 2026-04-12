<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PastoralTransferCompleted extends Notification
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
            'title' => 'Transfer Completed',
            'message' => 'A pastoral transfer has been fully approved.',
            'transfer_id' => $this->transfer->id,
        ];
    }
}