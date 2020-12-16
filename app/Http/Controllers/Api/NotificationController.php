<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    //
    public function list(){

        return response()->json([
            'notifications' => Notification::orderBy('id', 'DESC')->get(),
            'active_notifications' => Notification::whereStatus(1)->orderBy('id', 'DESC')->get(),
            'inactive_notifications' => Notification::whereStatus(0)->orderBy('id', 'DESC')->get(),
            'expireds_notifications' => Notification::whereType(1)->orderBy('id', 'DESC')->get(),
            'expireds_active_notifications' => Notification::whereType(1)->whereStatus(1)->orderBy('id', 'DESC')->get(),
            'expireds_inactive_notifications' => Notification::whereType(1)->whereStatus(0)->orderBy('id', 'DESC')->get(),
            'lowqtd_notifications' => Notification::whereType(2)->orderBy('id', 'DESC')->get(),
            'lowqtd_active_notifications' => Notification::whereType(2)->whereStatus(1)->orderBy('id', 'DESC')->get(),
            'lowqtd_inactive_notifications' => Notification::whereType(2)->whereStatus(0)->orderBy('id', 'DESC')->get(),
        ]);
    }

    
    public function update($id){
        
        $notification = Notification::findOrFail($id);

        $notification->status = 1;

        $notification->save();

        return response()->json(['message' => 'Notificação visualizada!', 'success' => true]);
        
    }

    
    public function destroy($id){
        
        Notification::findOrFail($id)->delete();
        
        return response()->json(['message' => 'Notificação apagada com sucesso!', 'success' => true]);
        
    }
}
