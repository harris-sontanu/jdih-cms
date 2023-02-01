<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Employee;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;

class PageController extends AdminController
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Halaman';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('admin.page.index') => 'Halaman',
            'Daftar' => TRUE
        ];

        $pages = Post::ofType('page')->with('author', 'cover');

        $onlyTrashed = FALSE;
        if ($tab = $request->tab)
        {
            if ($tab === 'sampah') {
                $pages->onlyTrashed();
                $onlyTrashed = TRUE;
            } else if ($tab === 'terbit') {
                $pages->published();
            } else if ($tab === 'draf') {
                $pages->draft();
            }
        }

        $limit = !empty($request->limit) ? $request->limit : $this->limit;

        $pages = $pages->search($request->only(['search']))
            ->filter($request)
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $authors = Employee::sorted()->pluck('name', 'id');
        $users = User::sorted()->pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
            'assets/admin/js/vendor/ui/moment/moment.min.js',
            'assets/admin/js/vendor/pickers/daterangepicker.js',
            'assets/admin/js/vendor/ui/sortable.min.js',
            'assets/admin/js/vendor/tables/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('admin.page.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'onlyTrashed',
            'pages',
            'authors',
            'users',
            'tabFilters',
            'vendors'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'total'     => Post::ofType('page')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->count(),
            'draf'      => Post::ofType('page')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->draft()
                                ->count(),
            'terbit'    => Post::ofType('page')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->published()
                                ->count(),
            'sampah'    => Post::ofType('page')->with('author', 'cover')
                                ->search($request->only(['search']))
                                ->filter($request)
                                ->onlyTrashed()
                                ->count()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
