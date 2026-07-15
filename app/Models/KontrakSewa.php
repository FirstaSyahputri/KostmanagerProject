<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontrakSewa extends Model
{
    protected $table = 'kontrak_sewa';

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }
}
