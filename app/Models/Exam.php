<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exam';
    protected $guarded = [];

    public function question()
    {
        return $this->hasMany(Question::class, 'id_exam');
    }
    public function pelatihan(){
        return $this->belongsTo(Pelatihan::class,'id_pelatihan');
    }

}
