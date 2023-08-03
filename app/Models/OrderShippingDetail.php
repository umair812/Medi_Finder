<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShippingDetail extends Model
{
    use HasFactory;

    public function shipping_companies()
    {
        return $this->belongsTo(ShippingCompanies::class);
    }
}
