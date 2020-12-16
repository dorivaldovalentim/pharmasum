<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $fillable = ['product_id', 'expire_date', 'qtd'];

    public function product(){
        return $this->belongsTo('App\Models\Product')
                    ->join('categories', 'categories.id', 'category_id')
                    ->join('manufacturers', 'manufacturers.id', 'manufacturer_id')
                    ->select('products.*', 'categories.category', 'manufacturers.manufacturer');
    }
}
