<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldRate extends Model
{
    protected $fillable = [
        'type',
        'location',
        'buy_rate',
        'sell_rate',
        'unit',
    ];

    public $timestamps = false;
}
