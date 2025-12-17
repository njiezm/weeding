<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuestionQuiDeux;

class QuestionQuiDeuxSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'question' => 'Qui est plus du matin ?',
                'bonne_reponse' => 'Gilles',
                'active' => true,
            ],
            [
                'question' => 'Qui aime plus le chocolat ?',
                'bonne_reponse' => 'Maëva',
                'active' => true,
            ],
            [
                'question' => 'Qui est plus du sport ?',
                'bonne_reponse' => 'Gilles',
                'active' => true,
            ],
            [
                'question' => 'Qui cuisine le mieux ?',
                'bonne_reponse' => 'Maëva',
                'active' => true,
            ],
            [
                'question' => 'Qui est plus organisé(e) ?',
                'bonne_reponse' => 'Maëva',
                'active' => true,
            ],
        ];

        foreach ($questions as $question) {
            QuestionQuiDeux::create($question);
        }
    }
}