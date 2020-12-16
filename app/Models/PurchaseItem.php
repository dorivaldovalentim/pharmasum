<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    //
    protected $fillable = ['purchase_price', 'qtd', 'product_id', 'purchase_id'];
}
