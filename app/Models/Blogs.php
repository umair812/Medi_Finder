<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    public function blog_categories()
    {
        return $this->belongsTo(BlogCategories::class);
    }
}
