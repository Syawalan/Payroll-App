<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penggajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','periode','total_volume','tarif','total_gaji','status','bukti'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
