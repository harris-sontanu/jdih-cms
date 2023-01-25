<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
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
            for ($i=0; $i < rand(1, 15); $i++) {
                $dt = fake()->dateTimeBetween('-2 years');
                $created_at = rand(0, 1) ? Carbon::parse($dt)->addDays(rand(1, 3)) : Carbon::parse($dt);
                $updated_at = rand(0, 1) ? Carbon::parse($created_at)->addDays(rand(1, 3)) : $created_at;

                $answer = $question->answers()->get()->random();

                Vote::create([
                    'ipv4'  => DB::raw('INET_ATON("'.fake()->ipv4().'")'),
                    'answer_id'     => $answer->id,
                    'created_at'    => $created_at->toDateTimeString(),
                    'updated_at'    => $updated_at->toDateTimeString(),
                ]);
            }
        }
    }
}
