<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'customer_id',
        'notes',
        'total_price',
        'date',
        'prepared_by',
        'delivered_by',
        'opened_at',
        'current_status_at',
        'closed_at',
        'preparation_time',
        'delivery_time',
        'total_time'
    ];
}
