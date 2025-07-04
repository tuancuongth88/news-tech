<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    //
    const PROVINCE = 'province';
    const LATITUDE = 'latitude';
    const LONGITUDE = 'longitude';
    const TIME = 'time';
    const TEMPERATURE = 'temperature';
    const HUMIDITY = 'humidity';
    const WIND_SPEED = 'wind_speed';
    const PRECIPITATION     = 'precipitation';

    public $fillable = [
        self::PROVINCE,
        self::LATITUDE,
        self::LONGITUDE,
        self::TIME,
        self::TEMPERATURE,
        self::HUMIDITY,
        self::WIND_SPEED,
        self::PRECIPITATION
    ];
}
