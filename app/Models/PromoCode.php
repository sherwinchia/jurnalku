<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_spending',
        'max_discount',
        'max_use_count',
        'first_time_user',
        'start_at',
        'expired_at',
        'active',
    ];
}
