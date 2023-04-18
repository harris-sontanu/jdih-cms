<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   
        $pageHeader = 'Dasbor';
        $pageTitle = $pageHeader . $this->pageTitle;

        return view('admin.dashboard.index', compact(
            'pageHeader',
            'pageTitle',
        ));
    }
}
