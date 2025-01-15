<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';
    protected $guarded = [];
    
    public function jawaban_benar()
    {
        return $this->hasOne(JawabanBenar::class, 'id_question');
    }
    public function opsi_jawaban()
    {
        return $this->hasMany(OpsiJawaban::class, 'id_question');
    }
}
