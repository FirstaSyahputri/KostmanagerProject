<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran'; 
    protected $guarded = ['id'];
    protected $casts = ['tanggal_bayar' => 'date'];

    public function kontrak_sewa()
    {
        return $this->belongsTo(KontrakSewa::class);
    }
}
