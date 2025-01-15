<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaksanaanPelatihan extends Model
{
    use HasFactory;
    protected $table = 'pelaksanaan_pelatihan';
    protected $guarded = [];
    public function pelatihan(){
        return $this->belongsTo(Pelatihan::class,'id_pelatihan');
    }
    public function instruktur(){
        return $this->belongsTo(User::class,'id_instruktur');
    }
    public function ruangan(){
        return $this->belongsTo(Ruangan::class,'id_ruangan');
    }
    public function tablepeserta(){
        return $this->hasMany(PesertaPelatihan::class,'id_pelaksanaan_pelatihan');
    }
    public function tablealat(){
        return $this->hasMany(TableAlat::class,'id_pelaksanaan_pelatihan');
    }
    public function permintaantraining(){
        return $this->hasOne(PermintaanTraining::class,'id_pelaksanaanPelatihan');
    } 
}
