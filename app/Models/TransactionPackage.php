<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'package_id',
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction_id');
    }
    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id');
    }
}
