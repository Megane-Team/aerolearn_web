<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;
    protected $table = 'pelatihan';
    protected $guarded = [];
    public function materi()
    {
        return $this->hasMany(Materi::class,'id_pelatihan');
    }
    public function exam()
    {
        return $this->hasMany(Exam::class,'id_pelatihan');
    }
}
