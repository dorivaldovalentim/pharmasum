<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    //
    protected $fillable = ['sale_price', 'qtd', 'sale_id', 'product_id'];
}
