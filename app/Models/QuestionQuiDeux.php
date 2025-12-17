<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionQuiDeux extends Model
{
    protected $table = 'questions_qui_deux';

    protected $fillable = [
        'question',
        'bonne_reponse',
        'active'
    ];

    public function reponses()
    {
        return $this->hasMany(ReponseQuiDeux::class, 'question_id');
    }
}