<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'expired_at',
        'package_id'
    ];

    protected $dates = ['expired_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }
}
