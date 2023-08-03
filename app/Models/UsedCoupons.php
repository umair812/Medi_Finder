<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedCoupons extends Model
{
    use HasFactory;

    public function coupons(){
        return $this->belongsTo(Coupons::class);
    }
}
