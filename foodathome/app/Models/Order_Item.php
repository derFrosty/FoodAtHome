<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Item extends Model
{
    protected $table = 'order_items';

    /**
     *  Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'sub_total_price'
    ];
}
