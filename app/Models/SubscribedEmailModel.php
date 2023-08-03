<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribedEmailModel extends Model
{
    use HasFactory;
    protected $table="subscribed_emails";
    protected $primaryKey="id";
}
