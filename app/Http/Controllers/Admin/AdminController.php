<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $pageTitle;
    protected $limit = 25;

    public function __construct()
    {
        $this->pageTitle = ' - JDIH Admin';
    }
}
