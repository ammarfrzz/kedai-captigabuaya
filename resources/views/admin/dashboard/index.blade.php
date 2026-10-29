@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Dashboard</h1>
        <p>Selamat datang kembali. Berikut ringkasan operasional Kedai Cap Tiga Buaya.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('home') }}" target="_blank" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Kunjungi Toko
        </a>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div class="stat-grid" style="margin-bottom:24px;">
    {{-- Total Omset --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Total Omset</div>
            @if($totalRevenue > 0)
                <div class="stat-value" style="color:var(--green-700);">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-note">Semua pesanan lunas</div>
            @else
                <div class="stat-value" style="color:var(--text-3); font-size:18px;">–</div>
                <div class="stat-note">Belum ada transaksi lunas</div>
            @endif
        </div>
        <div class="stat-icon" style="background:#dcfce7; color:var(--green-600);">
            <i class="fa-solid fa-sack-dollar"></i>
        </div>
    </div>

    {{-- Total Pesanan --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Total Pesanan</div>
            @if($totalOrdersCount > 0)
                <div class="stat-value">{{ number_format($totalOrdersCount) }}</div>
                <div class="stat-note">Hari ini: <strong>{{ $todayOrdersCount }}</strong> pesanan</div>
            @else
                <div class="stat-value" style="color:var(--text-3); font-size:18px;">–</div>
                <div class="stat-note">Belum ada pesanan masuk</div>
            @endif
        </div>
        <div class="stat-icon" style="background:#dbeafe; color:#2563eb;">
            <i class="fa-solid fa-receipt"></i>
        </div>
    </div>

    {{-- Menu Aktif --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Menu Aktif</div>
            <div class="stat-value">{{ $activeMenusCount }}</div>
            <div class="stat-note">Item tersedia di menu</div>
        </div>
        <div class="stat-icon" style="background:#fef3c7; color:#b45309;">
            <i class="fa-solid fa-utensils"></i>
        </div>
    </div>

    {{-- Peak Hours --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Peak Hours</div>
            @if($peakHour)
                <div class="stat-value" style="font-size:16px; color:#ea580c;">{{ $peakHour }}</div>
                <div class="stat-note">Jam tersibuk dari data nyata</div>
            @else
                <div class="stat-value" style="color:var(--text-3); font-size:18px;">–</div>
                <div class="stat-note">Belum ada data transaksi</div>
            @endif
        </div>
        <div class="stat-icon" style="background:#ffedd5; color:#ea580c;">
            <i class="fa-solid fa-fire"></i>
        </div>
    </div>
</div>

{{-- ── GRAFIK PENJUALAN ── --}}
<div style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:24px; box-shadow:var(--shadow-sm); margin-bottom:24px;">
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; margin-bottom:22px; padding-bottom:18px; border-bottom:1px solid var(--border);">
        <div>
            <h3 style="font-size:16px; font-weight:700; color:var(--text-1);">Grafik Penjualan &amp; Pendapatan</h3>
            <p style="font-size:12.5px; color:var(--text-3); margin-top:4px;">Tren transaksi pesanan dan akumulasi omset Kedai Cap Tiga Buaya</p>
        </div>
        @if($totalOrdersCount > 0)
        <div style="display:flex; background:var(--bg); border-radius:var(--radius-sm); padding:3px; border:1px solid var(--border);">
            <button type="button" class="chart-tab active" onclick="switchPeriod(this, 'minggu')">Minggu Ini</button>
            <button type="button" class="chart-tab" onclick="switchPeriod(this, 'bulan')">Bulan Ini</button>
        </div>
        @endif
    </div>

    @if($totalOrdersCount > 0)
        {{-- ── SUMMARY HIGHLIGHTS (isi dari PHP langsung, bukan JS dummy) ── --}}
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
            <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
                <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Omset Minggu Ini</div>
                <div style="font-size:20px; font-weight:800; color:var(--green-700); margin-top:4px;" id="stat-omset">
                    {{ $weekRevenue > 0 ? 'Rp '.number_format($weekRevenue, 0, ',', '.') : '–' }}
                </div>
                <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;" id="stat-omset-note">
                    {{ $weekRevenue > 0 ? 'Dari pesanan lunas' : 'Belum ada pemasukan minggu ini' }}
                </div>
            </div>
            <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
                <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Total Transaksi</div>
                <div style="font-size:20px; font-weight:800; color:var(--text-1); margin-top:4px;" id="stat-transaksi">
                    {{ $weekOrders > 0 ? $weekOrders.' Pesanan' : '–' }}
                </div>
                <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;" id="stat-transaksi-note">
                    {{ $weekOrders > 0 ? 'Minggu ini' : 'Belum ada pesanan minggu ini' }}
                </div>
            </div>
            <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
                <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Rata-rata Harian</div>
                <div style="font-size:20px; font-weight:800; color:var(--text-1); margin-top:4px;" id="stat-rata">
                    {{ $weekAvgDaily > 0 ? 'Rp '.number_format(round($weekAvgDaily), 0, ',', '.') : '–' }}
                </div>
                <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;">Per hari minggu ini</div>
            </div>
            <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
                <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Jam Terpadat</div>
                <div style="font-size:20px; font-weight:800; color:#ea580c; margin-top:4px;">
                    {{ $peakHour ?? '–' }}
                </div>
                <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;">
                    {{ $peakHour ? 'Dari data transaksi nyata' : 'Belum ada data' }}
                </div>
            </div>
        </div>

        {{-- CANVAS CHART --}}
        <div style="position:relative; width:100%; overflow-x:auto; padding-top:10px;">
            <canvas id="salesChart" style="width:100%; max-height:260px;"></canvas>
        </div>

        <div style="display:flex; flex-wrap:wrap; align-items:center; gap:20px; margin-top:20px; padding-top:14px; border-top:1px solid #f1f5f3; font-size:12.5px; color:var(--text-3);">
            <span style="display:flex; align-items:center; gap:6px;">
                <span style="width:18px; height:3px; background:#2d7a40; border-radius:2px;"></span>
                Tren Omset Harian
            </span>
        </div>

    @else
        {{-- ── KOSONG: belum ada pesanan ── --}}
        <div style="padding:48px 0; text-align:center; color:var(--text-3);">
            <i class="fa-solid fa-chart-line" style="font-size:40px; opacity:0.25; display:block; margin-bottom:16px;"></i>
            <div style="font-size:15px; font-weight:700; color:var(--text-2); margin-bottom:6px;">Belum ada data penjualan</div>
            <div style="font-size:13px;">Grafik akan tampil otomatis setelah ada pesanan masuk dari pelanggan.</div>
        </div>
    @endif
</div>

{{-- ── PESANAN TERBARU ── --}}
<div style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:20px 24px; box-shadow:var(--shadow-sm);">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-1);">
            <i class="fa-solid fa-clock-rotate-left" style="color:var(--green-600); margin-right:6px;"></i> Pesanan Terbaru
        </h3>
        @if($recentOrders->count())
        <a href="{{ route('admin.pesanan.dine_in') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        @endif
    </div>

    @if($recentOrders->count())
    <div class="table-wrap" style="border:none; box-shadow:none;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.pesanan.show', $order->id) }}" style="font-weight:700; font-size:12.5px; color:#1a4d2b; text-decoration:none;">
                            {{ $order->order_number }}
                        </a>
                        <div style="font-size:11px; color:var(--text-3);">{{ $order->created_at->diffForHumans() }}</div>
                    </td>
                    <td style="font-weight:600;">{{ $order->customer_name }}</td>
                    <td>
                        @if($order->order_type === 'dine_in')
                            <span class="badge" style="background:#e0f2fe; color:#0369a1;">Dine In</span>
                        @else
                            <span class="badge" style="background:#fef3c7; color:#b45309;">Take Away</span>
                        @endif
                    </td>
                    <td>
                        @if($order->order_status === 'completed')
                            <span class="badge" style="background:#dcfce7; color:#15803d;">Selesai</span>
                        @elseif($order->order_status === 'processing')
                            <span class="badge" style="background:#fef3c7; color:#b45309;">Dimasak</span>
                        @elseif($order->order_status === 'cancelled')
                            <span class="badge" style="background:#fee2e2; color:#b91c1c;">Dibatalkan</span>
                        @else
                            <span class="badge" style="background:#f1f5f9; color:#475569;">Menunggu</span>
                        @endif
                    </td>
                    <td style="font-weight:700; color:var(--green-700);">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="padding:32px 0; text-align:center; color:var(--text-3);">
        <i class="fa-solid fa-clipboard-list" style="font-size:32px; opacity:0.3; display:block; margin-bottom:12px;"></i>
        <div style="font-size:14px; font-weight:600; color:var(--text-2); margin-bottom:4px;">Belum ada pesanan masuk</div>
        <div style="font-size:13px;">Data akan muncul otomatis setelah ada transaksi dari pelanggan.</div>
    </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .chart-tab {
        border: none;
        background: transparent;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-3);
        border-radius: 6px;
        cursor: pointer;
        transition: all var(--transition);
        font-family: inherit;
    }
    .chart-tab:hover { color: var(--text-1); }
    .chart-tab.active {
        background: var(--surface);
        color: var(--green-800);
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
    }
</style>
@endpush

@if($totalOrdersCount > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    const chartDataWeek  = @json($chartWeek);
    const chartDataMonth = @json($chartMonth);

    const weekStats = {
        omset   : {{ $weekRevenue }},
        orders  : {{ $weekOrders }},
        avgDaily: {{ round($weekAvgDaily) }},
    };
    const monthStats = {
        omset   : {{ $monthRevenue }},
        orders  : {{ $monthOrders }},
        avgDaily: {{ round($monthAvgDaily) }},
    };

    // ── Format Rupiah ──
    function formatRp(n) {
        if (n <= 0) return '–';
        if (n >= 1_000_000) return 'Rp ' + (n / 1_000_000).toFixed(1).replace('.0', '') + ' Jt';
        if (n >= 1_000)     return 'Rp ' + Math.round(n / 1_000) + ' Rb';
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    // ── Chart.js setup ──
    const ctx = document.getElementById('salesChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0,   'rgba(45,122,64,0.35)');
    gradient.addColorStop(0.7, 'rgba(45,122,64,0.07)');
    gradient.addColorStop(1,   'rgba(45,122,64,0.00)');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartDataWeek.labels,
            datasets: [{
                label: 'Omset',
                data: chartDataWeek.omset,
                fill: true,
                backgroundColor: gradient,
                borderColor: '#2d7a40',
                borderWidth: 3,
                tension: 0.42,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2d7a40',
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: c => ' Omset: ' + formatRp(c.parsed.y),
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f4f7f5' },
                    ticks: { color: '#7a9482', font: { size: 12, weight: '600' } }
                },
                y: {
                    grid: { color: '#f4f7f5', drawBorder: false },
                    ticks: { color: '#7a9482', font: { size: 11 }, callback: v => formatRp(v) },
                    beginAtZero: true
                }
            }
        }
    });

    // ── Update stat cards saat switch tab ──
    function updateStats(stats) {
        document.getElementById('stat-omset').innerText       = formatRp(stats.omset);
        document.getElementById('stat-omset-note').innerText  = stats.omset > 0 ? 'Dari pesanan lunas' : 'Belum ada pemasukan periode ini';
        document.getElementById('stat-transaksi').innerText   = stats.orders > 0 ? stats.orders + ' Pesanan' : '–';
        document.getElementById('stat-transaksi-note').innerText = stats.orders > 0 ? 'Periode ini' : 'Belum ada pesanan periode ini';
        document.getElementById('stat-rata').innerText        = formatRp(stats.avgDaily);
    }

    // ── Switch periode ──
    function switchPeriod(btn, period) {
        document.querySelectorAll('.chart-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const d = period === 'minggu' ? chartDataWeek : chartDataMonth;
        salesChart.data.labels           = d.labels;
        salesChart.data.datasets[0].data = d.omset;
        salesChart.update('active');

        updateStats(period === 'minggu' ? weekStats : monthStats);
    }
</script>
@endpush
@endif
