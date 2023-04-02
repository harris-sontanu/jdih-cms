<?php

namespace App\Http\Controllers\Jdih;

use App\Http\Controllers\Controller;
use App\Http\Traits\VisitorTrait;
use App\Models\Setting;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    use VisitorTrait;

    public function show()
    {
        $questionnerSettings = json_decode(Setting::where('key', 'questionner')
            ->value('value'));

        $identityQuestions = Question::with('answers')
            ->identities()
            ->get();

        $questions = Question::with('answers')
            ->questions()
            ->get();

        // Record visitor
        $this->recordVisitor(request());

        return view('jdih.post.vote', compact(
            'questionnerSettings',
            'identityQuestions',
            'questions'
        ));
    }

    public function vote(Request $request)
    {
        $questionsTotal = Question::get()->count();

        $request->validate([
            'answers'   => 'required|array|min:' . $questionsTotal,
        ]);

        foreach ($request->answers as $key => $value) {
            Vote::create([
                'ipv4'      => DB::raw('INET_ATON("'.$request->ip().'")'),
                'answer_id' => $value,
            ]);
        }

        return redirect('/kuisioner')->with('message', '<strong>Sukses!</strong> Penilaian Anda sudah berhasil tersimpan');
    }
}
