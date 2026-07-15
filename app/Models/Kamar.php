<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar'; 
    protected $guarded = ['id'];


    public function kontrak_sewas()
    {
        return $this->hasMany(KontrakSewa::class);
    }
}
