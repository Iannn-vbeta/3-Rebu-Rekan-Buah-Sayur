<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'payment_gateway', 'payment_status', 'transaction_id', 'amount', 'paid_at'];

    protected $dates = ['paid_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}