<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    //
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address'];
}
