<?php

namespace Core\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        //$this->middleware(implode(['lice', 'nse']));
    }

    public function dashboard()
    {
        $update_config_path = base_path('updates/config.json');
        if (file_exists($update_config_path)) {
            return view('core::base.system.update.update_dashboard');
        }
        return view('core::base.dashboard.index');
    }
}
