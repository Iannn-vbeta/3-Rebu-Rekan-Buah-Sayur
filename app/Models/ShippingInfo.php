<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    protected $fillable = ['order_id', 'method', 'address', 'city', 'phone', 'notes', 'status_barang'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}