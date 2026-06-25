<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiang extends Model
{
    protected $table = 'tiangs';
    protected $fillable = [
        'nomor_tiang',
        'lokasi_spesifik',
        'latitude',
        'longitude',
        'status',
    ];
}
