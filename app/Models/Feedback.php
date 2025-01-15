<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedback';
    protected $guarded = [];
    public function feedbackquestion(){
        return $this->belongsTo(FeedbackQuestion::class,'id_feedbackQuestion');
    }
}
