<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $table = 'setoran_sampah';

    protected $fillable = [
        'kode_tiket',
        'nama',
        'jenis_sampah',
        'berat',
        'keterangan',
        'status',
    ];
}
