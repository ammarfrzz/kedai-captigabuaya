<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Statistik Realtime ──
        $totalOrdersCount  = Order::count();
        $todayOrdersCount  = Order::whereDate('created_at', today())->count();
        $totalRevenue      = Order::where('payment_status', 'paid')->sum('total');
        $activeMenusCount  = Menu::where('is_available', true)->count();

        // ── Pesanan Terbaru ──
        $recentOrders = Order::with('items')->latest()->take(5)->get();

        // ── Stat Minggu Ini ──
        $startOfWeek = Carbon::now()->startOfWeek();
        $weekRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfWeek, now()])
            ->sum('total');
        $weekOrders = Order::whereBetween('created_at', [$startOfWeek, now()])->count();
        $daysInWeek = max(1, Carbon::now()->dayOfWeek ?: 7);
        $weekAvgDaily = $daysInWeek > 0 ? $weekRevenue / $daysInWeek : 0;

        // ── Stat Bulan Ini ──
        $startOfMonth = Carbon::now()->startOfMonth();
        $monthRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startOfMonth, now()])
            ->sum('total');
        $monthOrders = Order::whereBetween('created_at', [$startOfMonth, now()])->count();
        $dayOfMonth  = max(1, Carbon::now()->day);
        $monthAvgDaily = $dayOfMonth > 0 ? $monthRevenue / $dayOfMonth : 0;

        // ── Grafik: 7 hari terakhir ──
        $chartWeek = $this->getChartData('minggu');

        // ── Grafik: 30 hari / bulan ini ──
        $chartMonth = $this->getChartData('bulan');

        // ── Peak hour dari data nyata ──
        $peakHour = $this->getPeakHour();

        return view('admin.dashboard.index', compact(
            'totalOrdersCount',
            'todayOrdersCount',
            'totalRevenue',
            'activeMenusCount',
            'recentOrders',
            'weekRevenue',
            'weekOrders',
            'weekAvgDaily',
            'monthRevenue',
            'monthOrders',
            'monthAvgDaily',
            'chartWeek',
            'chartMonth',
            'peakHour'
        ));
    }

    /**
     * API endpoint untuk chart data (JSON)
     */
    public function chartData(Request $request)
    {
        $period = $request->get('period', 'minggu');
        $data   = $this->getChartData($period);
        return response()->json($data);
    }

    // ─────────────────────────────────────────────
    private function getChartData(string $period): array
    {
        if ($period === 'bulan') {
            $start = Carbon::now()->startOfMonth();
            $end   = Carbon::now()->endOfDay();
            $format = '%d %b';
            $groupBy = 'DATE(created_at)';
            $days = [];
            $cur = $start->copy();
            while ($cur->lte($end)) {
                $days[] = $cur->format('Y-m-d');
                $cur->addDay();
            }
        } else {
            // Minggu ini: Senin sampai hari ini
            $start = Carbon::now()->startOfWeek();
            $end   = Carbon::now()->endOfDay();
            $format = '%a';
            $groupBy = 'DATE(created_at)';
            $days = [];
            $cur = $start->copy();
            while ($cur->lte($end)) {
                $days[] = $cur->format('Y-m-d');
                $cur->addDay();
            }
        }

        $rows = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as tgl'),
                DB::raw('SUM(total) as omset'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get()
            ->keyBy('tgl');

        $labels  = [];
        $omset   = [];
        $jumlah  = [];

        foreach ($days as $day) {
            $dt = Carbon::parse($day);
            $labels[]  = $period === 'bulan' ? $dt->format('d') : $dt->locale('id')->dayName;
            $omset[]   = (float) ($rows[$day]->omset ?? 0);
            $jumlah[]  = (int)   ($rows[$day]->jumlah ?? 0);
        }

        return compact('labels', 'omset', 'jumlah');
    }

    private function getPeakHour(): ?string
    {
        $peak = Order::select(
                DB::raw('HOUR(created_at) as jam'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('jam')
            ->orderByDesc('total')
            ->first();

        if (!$peak) {
            return null; // belum ada data, tampil "–" di view
        }

        $h = (int) $peak->jam;
        return sprintf('%02d:00 - %02d:00', $h, $h + 1);
    }
}
