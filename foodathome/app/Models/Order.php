<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    public function order_items()
    {
        return $this->hasMany('App\Models\Order_Item', 'order_id', 'id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\User', 'customer_id', 'id');
    }

    public function cook(){
        return $this->belongsTo('App\Models\User', 'prepared_by', 'id');
    }

    public function deliverer(){
        return $this->belongsTo('App\Models\User', 'delivered_by', 'id');
    }
}
