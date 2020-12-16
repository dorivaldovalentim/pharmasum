<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Events\LowQuantityMedicine;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LowQuantityMedicineNotification
{

    private $product;
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
     * @param  LowQuantityMedicine  $event
     * @return void
     */
    public function handle(LowQuantityMedicine $event)
    {
        //        
        $this->product = $event->getProduct();

        if($this->product->qtd < 15){
            
            $notifications = Notification::whereProductId($this->product->id)->where('created_at', 'like', date('Y-m-d') . '%')->whereType(2)->get();
            if($notifications->count() > 0)
                return true;
                
            $notification = new Notification;
            $notification->content = 'Restam apenas '. $this->product->qtd . ' ' . $this->product->product . ' no Stock';
            $notification->type = 2;
            $notification->product_id = $this->product->id;
            $notification->save();
        }  
    }
}
