<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang','satuan','volume','alamat_tujuan','user_id','tanggal_pengiriman'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
