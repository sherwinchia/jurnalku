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
        'reference',
        'merchant_ref',
        'net_total'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id');
    }

    public function promocode()
    {
        return $this->belongsTo('App\Models\Promocode', 'promocode_id');
    }
}
