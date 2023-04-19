<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::all();
        foreach ($questions as $question) {
            for ($i=0; $i < rand(2, 5); $i++) {
                Answer::create([
                    'question_id'   => $question->id,
                    'name'          => fake()->words(rand(1, 2), true)
                ]);
            }
        }
    }
}
