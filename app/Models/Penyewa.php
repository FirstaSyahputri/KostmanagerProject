<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa'; 
    protected $guarded = ['id'];

    public function kontrak_sewas()
    {
        return $this->hasMany(KontrakSewa::class);
    }
}
