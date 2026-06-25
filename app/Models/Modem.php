<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modem extends Model
{
    protected $table = 'modems';
    protected $fillable = [
        'nomor_aset_internal',
        'serial_number',
        'merek',
        'customer_id',
        'status',
    ];
}
