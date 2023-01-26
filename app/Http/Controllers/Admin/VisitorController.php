<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Download;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorController extends AdminController
{
    public function index(Request $request)
    {
        $pageHeader = 'Pengunjung';
        $pageTitle = $pageHeader . $this->pageTitle;

        $navPills = [
            [
                'route'     => route('admin.visitor', ['type' => 'daily']),
                'value'     => 'daily',
                'active'    => ($request->type == 'daily' OR is_null($request->type)) ? true : false,
                'text'      => 'Harian',
            ],
            [
                'route'     => route('admin.visitor', ['type' => 'weekly']),
                'value'     => 'weekly',
                'active'    => $request->type == 'weekly' ? true : false,
                'text'      => 'Mingguan',
            ],
            [
                'route'     => route('admin.visitor', ['type' => 'monthly']),
                'value'     => 'monthly',
                'active'    => $request->type == 'monthly' ? true : false,
                'text'      => 'Bulanan',
            ]
        ];

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/visualization/echarts/echarts.min.js',
			'assets/admin/js/vendor/visualization/d3/d3.min.js',
			'assets/admin/js/vendor/visualization/d3/d3_tooltip.js',
        ];

        return view('admin.visitor.index', compact(
            'pageTitle',
            'pageHeader',
            'navPills',
            'vendors',
        ));
    }

    public function barChart()
    {
        $sum = 0;
        $avg = 0;
        for ($i=24; $i >= 0; $i--) {
            $dt     = Carbon::now();
            $count  = Visitor::countDaily($i)->get()->count();
            $sum    = $sum + $count;
            $avg    = $sum / 1;
            $json[] = [
                'qty'   => $count,
                'date'  => $dt->subDays($i)->translatedFormat('j M Y'),
                'sum'   => $sum,
                'avg'   => $avg
            ];
        }

        return response()->json($json);
    }

    public function chart(Request $request)
    {
        if ($request->type == 'weekly') {
            $max = 7;
        } else if ($request->type == 'monthly') {
            $max = 11;
        } else {
            $max = 6;
        }

        $types = ['Komputer', 'Ponsel'];

        foreach ($types as $type)
        {
            $data = [];
            $xaxis = [];
            for ($i=$max; $i >= 0; $i--) {
                $dt = Carbon::now()->settings([
                    'monthOverflow' => false,
                ]);

                if ($request->type == 'monthly') {
                    $visitor = Visitor::countMonthly($i);
                    $xaxis[] = $dt->subMonths($i)->translatedFormat('M');
                } else if ($request->type == 'weekly') {
                    $visitor = Visitor::countWeekly($i);
                    $xaxis[] = $dt->subWeeks($i)->translatedFormat('j M');
                } else {
                    $visitor = Visitor::countDaily($i);
                    $xaxis[] = $dt->subDays($i)->translatedFormat('l, j M');
                }
                $visitor = $type == 'Komputer'
                    ? $visitor->where('mobile', 0)
                    : $visitor->where('mobile', 1);

                $data[] = $visitor->get()->count();
                $sum[$type] = $data;
            }

            $series[] = [
                'name'  => $type,
                'type'  => 'bar',
                'data'  => $data,
                'itemStyle' => [
                    'normal'  => [
                        'barBorderRadius' => [4, 4, 0, 0],
                        'label' => [
                            'show'  => true,
                            'position'  => 'top',
                            'fontWeight'=> 500,
                            'fontSize'  => 12,
                            'color' => 'var(--body-color)'
                        ]
                    ]
                ],
                'markLine'  => [
                    'data'  => [
                        0   => [
                            'type'  => 'average',
                            'name'  => 'Average'
                        ]
                    ],
                    'label' => [
                        'color' => 'var(--body-color)'
                    ]
                ]
            ];

        }

        array_push($types, 'Total');
        $sum = array_map(function () {
            return array_sum(func_get_args());
        }, $sum['Komputer'], $sum['Ponsel']);

        $series[] = [
            'name'  => 'Total',
            'type'  => 'line',
            'data'  => $sum,
        ];

        $json = [
            'legend'    => $types,
            'xaxis'     => $xaxis,
            'series'    => $series
        ];

        return response()->json($json);
    }

    public function browserChart(Request $request)
    {
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera', 'Lainnya'];
        $colors   = ['#5c6bc0', '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'];

        $i = 0;
        foreach ($browsers as $browser) {

            if ($request->type == 'weekly') {
                $visitor = Visitor::countWeekly();
                $date = Carbon::now()->translatedFormat('j F');
            } else if ($request->type == 'monthly') {
                $visitor = Visitor::countMonthly();
                $date = Carbon::now()->translatedFormat('F');
            } else {
                $visitor = Visitor::countDaily();
                $date = Carbon::now()->translatedFormat('l, j F');
            }

            $value = $browser == 'Lainnya'
                ? $visitor->whereNotIn('browser', $browsers)->get()->count()
                : $visitor->where('browser', $browser)->get()->count();

            $data[] = [
                'browser'   => $browser,
                'value'     => $value,
                'color'     => $colors[$i],
            ];
            $i++;
        }

        $json = [
            'data'  => $data,
            'date'  => $date
        ];

        return response()->json($json);
    }

    public function downloadChart(Request $request)
    {
        $sum = 0;
        $avg = 0;
        for ($i=6; $i >= 0; $i--) {
            $dt  = Carbon::now();
            $count  = Download::countDaily($i)->get()->count();
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
