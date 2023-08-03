<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public function customers()
    {
        return $this->belongsTo(Customers::class);
    }
    public function order_details()
    {
        return $this->hasMany(OrderDetails::class);
    }
    public function products()
    {
        return $this->order_details->products();
    }
    public function order_billing_addresses()
    {
        return $this->hasOne(OrderBillingAddress::class);
    }
    public function order_shipping()
    {
        return $this->hasOne(OrderShippingDetail::class);
    }
    public function shipping_companies()
    {
        return $this->order_shipping->shipping_companies;
    }
}
