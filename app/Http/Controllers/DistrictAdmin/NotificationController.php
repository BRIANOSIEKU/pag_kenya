<?php

namespace App\Http\Controllers\DistrictAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // =========================
    // LIST NOTIFICATIONS
    // =========================
    public function index()
    {
        $adminId = session('district_admin_id');

        $notifications = Notification::where('district_admin_id', $adminId)
            ->latest()
            ->get();

        return view('district_admin.notifications.index', compact('notifications'));
    }

    // =========================
    // MARK ONE AS READ
    // =========================
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'is_read' => true
        ]);

        return back();
    }

    // =========================
    // MARK ALL AS READ
    // =========================
    public function markAllAsRead()
    {
        $adminId = session('district_admin_id');

        Notification::where('district_admin_id', $adminId)
            ->update(['is_read' => true]);

        return back();
    }
}