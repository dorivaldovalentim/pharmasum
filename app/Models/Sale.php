<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = ['costumer_id', 'user_id', 'amount_recieved', 'amount', 'amount_change'];

    public function employee(){
        return $this->belongsTo('App\Models\User');
    }

    public function client(){
        return $this->belongsTo('App\Models\Client');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
