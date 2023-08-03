<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistorOrders extends Model
{
    use HasFactory;
    public function vistor_order_details()
    {
        return $this->hasMany(VistorOrderDetails::class);
    }
    public function products()
    {
        return $this->vistor_order_details->products;
    }

    public function order_shipping()
    {
        return $this->hasOne(VisitorOrderShippingDetail::class);
    }
    public function shipping_companies()
    {
        return $this->order_shipping->shipping_companies;
    }
}
