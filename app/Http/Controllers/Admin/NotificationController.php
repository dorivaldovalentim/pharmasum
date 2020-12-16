<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:admin');
    }
    
    public function index(){
        
        $notifications = [
            'notifications' => Notification::get(),
            'active_notifications' => Notification::whereStatus(1)->get(),
            'inactive_notifications' => Notification::whereStatus(0)->get(),
            'expireds_notifications' => Notification::whereType(1)->get(),
            'active_expireds_notifications' => Notification::whereType(1)->whereStatus(1)->get(),
            'inactive_expireds_notifications' => Notification::whereType(1)->whereStatus(0)->get(),
            'lowqtd_notifications' => Notification::whereType(2)->get(),
            'active_lowqtd_notifications' => Notification::whereType(2)->whereStatus(1)->get(),
            'inactive_lowqtd_notifications' => Notification::whereType(2)->whereStatus(0)->get(),
        ];

        return view('notifications.index', compact('notifications'));
    }
}
