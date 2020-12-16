<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['product', 'manufacturer_id', 'category_id', 'details', 'barcode', 'price', 'place'];

    public function stock(){
        return $this->hasMany('App\Models\Stock');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function manufacturer(){
        return $this->belongsTo('App\Models\Manufacturer');
    }
}
