<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PastoralTransferApproved extends Notification
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
            'title' => 'Transfer Approval Update',
            'message' => 'Your pastoral transfer has received approval.',
            'transfer_id' => $this->transfer->id,
        ];
    }
}