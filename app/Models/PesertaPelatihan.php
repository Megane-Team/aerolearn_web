<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPelatihan extends Model
{
    use HasFactory;
    protected $table = 'table_peserta';
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'id_peserta');
    }
    public function pelaksanaan(){
        return $this->belongsTo(PelaksanaanPelatihan::class,'id_pelaksanaan_pelatihan');
    }
}
