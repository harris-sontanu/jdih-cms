<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Answer;
use App\Models\Setting;
use App\Models\Question;
use App\Models\Vote;

class QuestionnerController extends AdminController
{
    public function index()
    {
        $pageHeader = 'Kuesioner';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.questionner.index') => 'IKM',
            'Kuesioner' => TRUE
        ];

        $setting = Setting::where('key', 'questionner')->first();
        $questionner = json_decode($setting->value);

        $identityQuestions = Question::with('answers')->identities()->get();
        $questions = Question::with('answers')->questions()->get();

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
        ];

        return view('admin.questionner.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'questionner',
            'identityQuestions',
            'questions',
            'vendors'
        ));
    }

    public function destroyQuestion(Question $question)
    {
        $question->delete();

        return redirect('/admin/questionner')->with('message', '<strong>Berhasil!</strong> Data Pertanyaan telah berhasil dihapus');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required',
            'newAnswers'  => 'required|array|min:1'
        ]);

        $new_question = Question::create([
            'title' => $request->title,
            'type'  => $request->type
        ]);

        foreach ($request->newAnswers as $answer) {
            $new_question->answers()->create([
                'name'  => $answer
            ]);
        }

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Pertanyaan baru telah berhasil disimpan');
    }

    public function edit(Question $question)
    {
        return view('admin.questionner.edit')->with('question', $question);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'title'     => 'required',
            'answers'   => 'required|array|min:1',
        ]);

        $question->update([
            'title' => $request->title,
        ]);

        foreach ($request->answers as $key => $value) {
            Answer::where('id', $key)
                ->update([
                    'name' => $value,
                ]);
        }

        if ($request->has('newAnswers')) {
            foreach ($request->newAnswers as $newAnswer) {
                $question->answers()->create([
                    'name'  => $newAnswer,
                ]);
            }
        }

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Pertanyaan telah berhasil diperbarui');
    }

    public function destroyAnswer(Answer $answer)
    {
        $answer->delete();

        request()->session()->flash('message', '<strong>Berhasil!</strong> Data Jawaban telah berhasil dihapus');
    }

    public function statistic(Request $request)
    {
        $pageHeader = 'Statistik IKM (Indeks Kepuasan Masyarakat)';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.questionner.index') => 'IKM',
            'Statistik' => TRUE
        ];

        $countVoters= Vote::select('ipv4')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('ipv4')
            ->get()
            ->count();

        $identityQuestions = Question::with('answers')->identities()->get();
        $questions = Question::with('answers')->questions()->get();

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/visualization/echarts/echarts.min.js',
			'assets/admin/js/vendor/visualization/d3/d3.min.js',
			'assets/admin/js/vendor/visualization/d3/d3_tooltip.js',
        ];

        return view('admin.questionner.statistic.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'countVoters',
            'identityQuestions',
            'questions',
            'vendors',
        ));
    }

    public function voteChart(Request $request)
    {
        $question = Question::find($request->id);
        foreach ($question->answers as $answer) {
            $series[] = [
                'value' => $answer->votes->count(),
                'name'  => $answer->name,
            ];
            $answers[] = $answer->name;
        }

        $json = [
            'series'    => $series,
            'answers'   => $answers,
            'question'  => $question->title,
        ];

        return response()->json($json);
    }

    public function voteLineChart()
    {
        $sum = 0;
        $avg = 0;
        for ($i=6; $i >= 0; $i--) {
            $dt     = Carbon::now();
            $count  = Vote::select('ipv4')
                ->whereDate('created_at', $dt->subDays($i))
                ->groupBy('ipv4')
                ->get()
                ->count();
            $sum    = $sum + $count;
            $avg    = $sum / 1;
            $json[] = [
                'qty'  => $count,
                'date' => $dt->subDays($i)->translatedFormat('Y/m/d'),
                'sum'  => $sum,
                'avg'  => $avg
            ];
        }

        return response()->json($json);
    }
}
