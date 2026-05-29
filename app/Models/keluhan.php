<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penghuni',
        'isi_keluhan',
        'status_keluhan',
        'tanggal',
    ];
}