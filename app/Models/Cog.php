<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Cog extends Model
{
    //

    public function verify(){
        
        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2021-10-28 0:00:00');

        $from = Carbon::now();
    
        $diff_in_days = $from->diffInDays($to, false);

        if($diff_in_days < 0)
            return true;

        return false;
    }
}
