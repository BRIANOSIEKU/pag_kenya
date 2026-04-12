<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\PastoralTransfer;

class PastoralTransferCreatedNotification extends Notification
{
    use Queueable;

    protected $transfer;

    public function __construct(PastoralTransfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function via($notifiable)
    {
        return ['database']; // you can add mail later
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Pastoral Transfer Request',
            'message' => 'A transfer request has been submitted for approval.',
            'transfer_id' => $this->transfer->id,
            'pastor' => $this->transfer->pastor->name ?? '',
            'from' => $this->transfer->fromDistrict->name ?? '',
            'to' => $this->transfer->toDistrict->name ?? '',
        ];
    }
}