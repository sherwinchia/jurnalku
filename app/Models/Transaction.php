<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'status',
        'promo_code_id',
        'gross_total',
        'discount',
        'net_total'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package','package_id');
    }

    public function promoCode()
    {
        return $this->belongsTo('App\Models\PromoCode','promo_code_id');
    }
}
