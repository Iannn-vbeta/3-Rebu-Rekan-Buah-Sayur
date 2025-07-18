<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingInfo()
    {
        return $this->hasOne(ShippingInfo::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}