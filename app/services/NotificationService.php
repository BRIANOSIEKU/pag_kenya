<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function notify($districtAdminId, $title, $message, $type = 'info', $relatedId = null)
    {
        Notification::create([
            'district_admin_id' => $districtAdminId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_id' => $relatedId,
        ]);
    }
}