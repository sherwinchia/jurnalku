<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
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

    protected $dates = ['start_at', 'expired_at'];

    public function getStartedAttribute()
    {
        return $this->start_at->lte(now());
    }

    public function getExpiredAttribute()
    {
        return now()->gt($this->expired_at);
    }

    public function getUseCountAttribute()
    {
        return Transaction::where('promocode_id', $this->id)->count();
    }
}
