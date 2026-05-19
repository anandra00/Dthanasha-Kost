<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    // Primary key adalah order_id (string), bukan auto-increment id
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'order_id', 'id_tagihan', 'id_waiting_list', 'snap_token', 
        'status_transaksi', 'tipe_pembayaran',
        'kegiatan', 'nama', 'nominal', 'waktu'
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id');
    }
}