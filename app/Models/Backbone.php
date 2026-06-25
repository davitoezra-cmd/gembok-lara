<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Backbone extends Model
{
    protected $table = 'backbones'; 

    protected $fillable = [
        'kode_backbone',
        'nama_jalur',
        'kapasitas_core',
        'core_terpakai',
        'panjang_kabel',
        'tipe_kabel',
        'status',
        'keterangan',
    ];
}