<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        $allMenus = collect(Menu::all());
        $terlarisMenus = $allMenus->where('terlaris', true)->values();
        
        return view('admin.dashboard.index', compact('allMenus', 'terlarisMenus'));
    }
}
