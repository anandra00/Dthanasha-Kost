<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; //[cite: 6]

    // Mematikan incrementing karena primary key-nya string (order_id)
    public $incrementing = false;
    protected $keyType = 'string'; //[cite: 6]

    protected $fillable = ['order_id', 'id_tagihan', 'snap_token', 'status_transaksi', 'tipe_pembayaran'];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id');
    }
}