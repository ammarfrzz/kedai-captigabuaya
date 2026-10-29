<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $allMenus = collect(Menu::all());
        $terlarisMenus = Menu::where('terlaris', true)->get();
        
        // Statistik Realtime
        $totalOrdersCount = Order::count();
        $todayOrdersCount = Order::whereDate('created_at', today())->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $activeMenusCount = Menu::where('is_available', true)->count();

        // Pesanan Terbaru
        $recentOrders = Order::with('items')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'allMenus',
            'terlarisMenus',
            'totalOrdersCount',
            'todayOrdersCount',
            'totalRevenue',
            'activeMenusCount',
            'recentOrders'
        ));
    }
}
