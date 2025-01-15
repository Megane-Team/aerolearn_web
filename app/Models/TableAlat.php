<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAlat extends Model
{
    use HasFactory;
    protected $table = 'tablealat';
    protected $guarded = [];
    public function alat(){
        return $this->belongsTo(Alat::class,'id_alat');
    }
}
