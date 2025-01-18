<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    use HasFactory;
    protected $table = 'sertifikat';
    protected $guarded = [];
    protected $appends = ['link'];
    public function peserta()
    {
        return $this->belongsTo(User::class,'id_peserta');
    }
    public function pelaksanaan()
    {
        return $this->belongsTo(PelaksanaanPelatihan::class,'id_pelaksanaan_pelatihan');
    }
    public function getLinkAttribute()
    {
        return route('pelaksanaan-peserta.sertif',$this->attributes['id']);
    }
}
