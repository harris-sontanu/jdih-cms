<?php

namespace App\Http\Controllers\Admin\Legislation;

use App\Http\Controllers\Admin\Legislation\LegislationController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;

class CategoryController extends LegislationController
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Jenis/Bentuk Produk Hukum';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            '#' => 'Produk Hukum',
            'Jenis/Bentuk' => TRUE
        ];

        $categories = Category::with(['type', 'user' => function($query) {
            $query->withTrashed();
        }]);

        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        
        $categories = $categories->search($request->only(['search']))
            ->sorted($request->only(['order', 'sort']))
            ->paginate($limit)
            ->withQueryString();

        $types = Type::pluck('name', 'id');

        $vendors = [
            'assets/admin/js/vendor/notifications/bootbox.min.js',
            'assets/admin/js/vendor/ui/sortable.min.js',
            'assets/admin/js/vendor/forms/selects/select2.min.js',
        ];

        return view('admin.legislation.category.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'categories',
            'types',
            'vendors'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $request->user()->categories()->create($validated);

        return redirect('/admin/legislation/category')->with('message', '<strong>Berhasil!</strong> Data Jenis/Bentuk baru telah berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $types = Type::pluck('name', 'id');
        
        return view('admin.legislation.category.edit', compact('category', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $category->update($validated);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Jenis/Bentuk telah berhasil diperbarui');
    }

    public function orderUpdate(Request $request)
    {
        $orders = $request->orders;
        foreach ($orders as $q => $value) {
            Category::where('id', $value)->update(['sort' => $q+1]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect('/admin/legislation/category')->with('message', '<strong>Berhasil!</strong> Data Jenis/Bentuk telah berhasil dihapus');
    }
}
