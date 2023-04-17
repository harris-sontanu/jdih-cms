<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class DashboardController extends AdminController
{
    public function index()
    {
        return 'This is dashboard';
    }
}
