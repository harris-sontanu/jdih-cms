<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Legislation;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use App\Models\Download;
use App\Models\LegislationDocument;
use App\Models\LegislationDownloadLog;
use App\Models\LegislationLog;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class LegislationController extends AdminController
{
    protected $statusOptions = [
        'mencabut' => 'Mencabut',
        'mengubah' => 'Mengubah',
        'dicabut'  => 'Dicabut dengan',
        'diubah'   => 'Diubah dengan',
    ];

    protected $lawRelationshipOptions = [
        'melaksanakan' => 'Melaksanakan',
    ];

    protected function statusAntonym($status)
    {
        if ($status === 'mencabut') {
            $antonym = 'dicabut';
        } else if ($status === 'mengubah') {
            $antonym = 'diubah';
        } else if ($status === 'dicabut') {
            $antonym = 'mencabut';
        } else if ($status === 'diubah') {
            $antonym = 'mengubah';
        }

        return $antonym;
    }

    protected $selectedCategories;

    function __construct()
    {
        $this->selectedCategories = Category::ofType(1)->inRandomOrder()->take(4)->pluck('id');
    }

    protected function documentStorage($legislation, $documentType, $sequence = 1)
    {
        $setting = Setting::where('key', 'region_code')->first();
        $file_code = empty($legislation->category->code) ? Str::lower($legislation->category->slug) : $legislation->category->code;
        $region_code = empty($setting->value) ? '' : $setting->value;
        $padded_number = empty($legislation->code_number) ? $legislation->id : Str::padLeft(Str::slug($legislation->code_number), 3, '0');

        $storage_path = 'produk-hukum/' . $legislation->category->type->slug . '/' . $legislation->year . '/' . Str::lower($legislation->category->slug);

        $prefix = match ($documentType) {
            'abstract'  => 'abs',
            'attachment'=> ($legislation->category->type_id === 1) ? 'lamp' . Str::padLeft($sequence, 2, '0') : '',
            'cover'     => 'img',
            default     => '',
        };

        $file_name = $legislation->year . $prefix . $file_code . $region_code . $padded_number;

        return [
            'path' => $storage_path,
            'file_name' => $file_name
        ];
    }

    protected function storeDocument($file, $legislation, $documentType, $sequence = 1)
    {
        $documentStorage = $this->documentStorage($legislation, $documentType, $sequence);
        $file_name = $documentStorage['file_name'] . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($documentStorage['path'], $file_name, 'public');

        // If document type is cover, create thumbnail
        if ($documentType === 'cover') {
            $extension = $file->getClientOriginalExtension();
            $thumbnail = Str::replace(".{$extension}", "_md.{$extension}", $path);
            if (Storage::disk('public')->exists($path)) {
                Image::make(storage_path('app/public/' . $path))->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/' . $thumbnail));
            }
        }

        $document = $legislation->documents()->create([
            'type'  => $documentType,
            'order' => $sequence,
        ]);

        $new_media = $document->media()->create([
            'name'      => $file_name,
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path'      => $path,
            'is_image'  => 0,
            'user_id'   => request()->user()->id,
            'published_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        return $new_media->id;
    }

    protected function deleteDocuments($legislation)
    {
        $documents = $legislation->documents->all();
        foreach ($documents as $document) {

            $this->removeMedia($document->media->path);

            $document->media->delete();
        }
    }

    public function search(Request $request)
    {
        $term       = $request->search;
        $laws       = Legislation::ofType(1)->search($request->only(['search']))->latestApproved()->take(3)->get();
        $monographs = Legislation::ofType(2)->search($request->only(['search']))->latest()->take(3)->get();
        $articles   = Legislation::ofType(3)->search($request->only(['search']))->latest()->take(3)->get();
        $judgments  = Legislation::ofType(4)->search($request->only(['search']))->latest()->take(3)->get();

        return view('admin.legislation.search', compact('term', 'laws', 'monographs', 'articles', 'judgments'));
    }

    public function log(Request $request)
    {
        $pageHeader = 'Riwayat';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Riwayat' => TRUE
        ];

        $logs = LegislationLog::with('legislation', 'user')
            ->search($request->only(['search']))
            ->filter($request)
            ->latest()
            ->paginate($this->limit);

        $users = User::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
        ];

        return view('admin.legislation.log', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'logs',
            'users',
            'vendors'
        ));
    }

    public function statistic(Request $request)
    {
        $pageHeader = 'Statistik Produk Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Statistik' => TRUE
        ];

        $countDownloads = LegislationDownloadLog::countDaily()->get()->count();

        $vendors = [
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/visualization/echarts/echarts.min.js',
			'assets/admin/js/vendor/visualization/d3/d3.min.js',
			'assets/admin/js/vendor/visualization/d3/d3_tooltip.js',
        ];

        return view('admin.legislation.statistic.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'vendors',
            'countDownloads',
        ));
    }

    public function legislationFilter(Request $request)
    {
        $action = $request->action;

        $yearOptions  = [];
        $year   = now()->format('Y');
        while ($year >= 2015) {
            $yearOptions[] = $year;
            $year--;
        }
        $selectedYears = [];
        for ($i=0; $i < 5; $i++) {
            $selectedYears[] = now()->format('Y') - $i;
        }

        $categories = Category::ofType(1)->pluck('name', 'id');
        $selectedCategories = $this->selectedCategories;

        return view('admin.legislation.statistic.filter', compact(
            'action',
            'yearOptions',
            'selectedYears',
            'categories',
            'selectedCategories',
        ));
    }

    public function lawYearlyColumnChart(Request $request)
    {
        if ($request->has('years')) {
            $years = $request->years;
            sort($years);
        } else {
            $years = [
                date("Y", strtotime("-4 year")),
                date("Y", strtotime("-3 year")),
                date("Y", strtotime("-2 year")),
                date("Y", strtotime("-1 year")),
                date("Y")
            ];
        }

        $selectedCategories = ($request->has('categories')) ? $request->categories : $this->selectedCategories;
        $categories = Category::ofType(1)->whereIn('id', $selectedCategories)->pluck('abbrev', 'id')->toArray();

        foreach ($categories as $key => $value) {

            $data = [];
            foreach ($years as $year) {
                $data[] = Legislation::ofType(1)->where('legislations.year', $year)
                    ->where('legislations.category_id', $key)
                    ->count();
            }

            $series[] = [
                'name'  => $value,
                'type'  => 'bar',
                'data'  => $data,
                'id'    => $key,
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

            $legend[] = $value;
        }

        $json = [
            'categories'=> $legend,
            'years'     => $years,
            'series'    => $series
        ];

        return response()->json($json);
    }

    public function lawMonthlyColumnChart(Request $request)
    {
        $year = ($request->has('year')) ? $request->year : date('Y') - 1;
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $selectedCategories = ($request->has('categories')) ? $request->categories : $this->selectedCategories;
        $categories = Category::ofType(1)->whereIn('id', $selectedCategories)->pluck('abbrev', 'id')->toArray();

        foreach ($categories as $key => $value) {

            $data = [];
            for ($i=0; $i < 12; $i++) {
                $data[] = [
                    'value' => Legislation::ofType(1)->where('legislations.year', $year)
                                ->whereMonth('legislations.published', $i + 1)
                                ->where('legislations.category_id', $key)
                                ->count(),
                    'groupId' => $key,
                ];

            }

            $series[] = [
                'name'  => $value,
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

            $legend[] = $value;
        }

        $json = [
            'year'      => $year,
            'months'    => $months,
            'categories'=> $legend,
            'series'    => $series
        ];

        return response()->json($json);
    }

    public function lawStatusColumnChart(Request $request)
    {
        if ($request->has('years')) {
            $years = $request->years;
            sort($years);
        } else {
            $years = [
                date("Y", strtotime("-4 year")),
                date("Y", strtotime("-3 year")),
                date("Y", strtotime("-2 year")),
                date("Y", strtotime("-1 year")),
                date("Y")
            ];
        }

        $statuses = ['berlaku', 'tidak berlaku'];

        foreach ($statuses as $key => $value) {

            $data = [];
            foreach ($years as $year) {
                $data[] = Legislation::ofType(1)->where('legislations.year', $year)
                    ->where('legislations.status', $value)
                    ->count();
            }

            $series[] = [
                'name'  => ucwords($value),
                'type'  => 'bar',
                'data'  => $data,
                'id'    => $key,
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

            $legend[] = ucwords($value);
        }

        $json = [
            'statuses'  => $legend,
            'years'     => $years,
            'series'    => $series
        ];

        return response()->json($json);
    }

    public function mostViewedChart(Request $request)
    {
        $categories = Legislation::selectRaw('category_id, abbrev, SUM(`view`) AS `view`')
            ->join('categories', 'legislations.category_id', '=', 'categories.id')
            ->where('categories.type_id', 1)
            ->groupBy('category_id')
            ->orderBy('view', 'desc')
            ->take(4);

        $categoryIds = $categories->pluck('category_id')->toArray();
        $categoryArray = $categories->pluck('abbrev', 'view');

        $otherCategories = Legislation::selectRaw('SUM(`view`) AS `view`')
            ->join('categories', 'legislations.category_id', '=', 'categories.id')
            ->where('categories.type_id', 1)
            ->whereNotIn('category_id', $categoryIds)
            ->groupBy('category_id')
            ->value('view');

        $categoryArray[isset($otherCategories) ? $otherCategories : 0] = 'Lainnya';

        $colors   = ['#5c6bc0', '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'];

        $i = 0;
        foreach ($categoryArray as $key => $value) {

            $json[] = [
                'category'  => $value,
                'value'     => $key,
                'color'     => $colors[$i],
            ];
            $i++;
        }

        return response()->json($json);
    }

    public function mostDownloadChart()
    {
        $downloads = LegislationDownloadLog::selectRaw('COUNT( document_id ) AS `count`, categories.abbrev')
            ->join('documents', 'downloads.document_id', '=', 'documents.id')
            ->join('legislations', 'documents.legislation_id', '=', 'legislations.id')
            ->join('categories', 'legislations.category_id', '=', 'categories.id')
            ->whereRaw('DATE(downloads.created_at) >= (DATE(NOW()) - INTERVAL 30 DAY)')
            ->groupBy('document_id')
            ->orderBy('count', 'desc')
            ->take(5)
            ->pluck('abbrev', 'count')
            ->toArray();

        $colors   = ['#5c6bc0', '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'];

        $i = 0;
        foreach ($downloads as $key => $value) {

            $json[] = [
                'category'  => $value,
                'value'     => $key,
                'color'     => $colors[$i],
            ];
            $i++;
        }

        return response()->json($json);
    }
}
