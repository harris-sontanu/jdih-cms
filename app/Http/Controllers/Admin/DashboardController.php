<?php

namespace App\Http\Controllers\Admin;

// use App\Models\Download;
use App\Models\Legislation;
use App\Models\Log;
// use App\Models\Visitor;
use App\Models\Vote;
use Illuminate\Support\Carbon;

class DashboardController extends AdminController
{
    public function index()
    {
        $pageHeader = 'Dasbor';
        $pageTitle = $pageHeader . $this->pageTitle;

        $legislations = Legislation::with(['category', 'category.type', 'user', 'logs'])
            ->published()
            ->latest()
            ->take(5)
            ->get();
        $totalLaws        = Legislation::ofType(1)->count();
        $totalMonographs  = Legislation::ofType(2)->count();
        $totalArticles 	  = Legislation::ofType(3)->count();
        $totalJudgments	  = Legislation::ofType(4)->count();
        $latestLogs       = Log::with('legislation', 'user')
            ->latest()
            ->take(10)
            ->get();

        // $latestNews = News::with('taxonomy', 'author', 'cover')
        //     ->published()
        //     ->latest()
        //     ->take(4)
        //     ->get();

        $countVoters= Vote::select('ipv4')
            ->whereDate('created_at', Carbon::today())
            ->groupBy('ipv4')
            ->get()
            ->count();

        // $countVisitors = Visitor::countDaily()->get()->count();
        // $visitPercentage = $this->visitPercentage();

        // $countDownloads = Download::countDaily()->get()->count();

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/visualization/echarts/echarts.min.js',
			'assets/admin/js/vendor/visualization/d3/d3.min.js',
			'assets/admin/js/vendor/visualization/d3/d3_tooltip.js',
        ];

        return view('admin.dashboard.index', compact(
            'pageTitle',
            'pageHeader',
            'legislations',
            'totalLaws',
            'totalMonographs',
            'totalArticles',
            'totalJudgments',
            // 'latestNews',
            'latestLogs',
            // 'countVoters',
            // 'countVisitors',
            // 'visitPercentage',
            // 'countDownloads',
            'vendors',
        ));
    }

    // private function visitPercentage() {
    //     $yesterday = Visitor::countDaily(1)->get()->count();
    //     $twoDaysBefore = Visitor::countDaily(2)->get()->count();

    //     $percentage = $twoDaysBefore == 0 ? '&infin;' : ($yesterday - $twoDaysBefore) / $twoDaysBefore * 100;

    //     $badge = $percentage >= 0
    //         ? '<span class="badge bg-success rounded-pill ms-auto">+' .round($percentage, 2). '%</span>'
    //         : ($percentage == '&infin;'
    //             ? '<span class="badge bg-success rounded-pill ms-auto">&infin;</span>'
    //             : '<span class="badge bg-danger rounded-pill ms-auto">' .round($percentage, 2). '%</span>'
    //         );

    //     return $badge;
    // }
}
