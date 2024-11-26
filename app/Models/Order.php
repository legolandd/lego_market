<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'delivery_method', 'total_price', 'status', 'address', 'delivery_date', 'delivery_time', 'payment_method'];
}
