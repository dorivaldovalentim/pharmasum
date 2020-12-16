<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Models\Notification;
use App\Events\ExpiredMedicine;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpiredMedicineNotification
{
    protected $product;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExpiredMedicine  $event
     * @return void
     */
    public function handle(ExpiredMedicine $event)
    {
        //
        $this->product = $event->getProduct();

        $from = Carbon::now();

        $to = Carbon::createFromFormat('Y-m-d H:s:i', $this->product->expire_date);
        
        $diff_in_days = $from->diffInDays($to, false);
    
        $notifications = Notification::whereProductId($this->product->id)->where('created_at', 'like', date('Y-m-d') . '%')->whereType(1)->get();
        if($notifications->count() > 0)
            return true;
            
        $notification = new Notification;
        $notification->type = 1;
        $notification->product_id = $this->product->id;

        if($diff_in_days < 30){
            if($diff_in_days < 0)   
                $notification->content = 'O produto ' . $this->product->product . ' encontra-se expirado'; 
            else
                $notification->content = 'O produto ' . $this->product->product . ' expira em ' . $diff_in_days . ' dias';         
        }   
                
        $notification->save();
    }
}
