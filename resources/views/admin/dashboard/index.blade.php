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
        <div class="stat-icon" style="width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,0.7); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); border:1px solid rgba(229,233,230,0.85); box-shadow:0 4px 12px rgba(0,0,0,0.03), inset 0 1px 0 rgba(255,255,255,0.9); color:#111827; display:flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                <line x1="2" x2="22" y1="10" y2="10"></line>
                <path d="M6 15h2"></path>
                <circle cx="16" cy="15" r="1"></circle>
            </svg>
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
        <div class="stat-icon" style="width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,0.7); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); border:1px solid rgba(229,233,230,0.85); box-shadow:0 4px 12px rgba(0,0,0,0.03), inset 0 1px 0 rgba(255,255,255,0.9); color:#111827; display:flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 2v4"></path>
                <path d="M8 2v4"></path>
                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                <path d="M3 10h18"></path>
                <path d="m9 16 2 2 4-4"></path>
            </svg>
        </div>
    </div>

    {{-- Menu Aktif --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Menu Aktif</div>
            <div class="stat-value">{{ $activeMenusCount }}</div>
            <div class="stat-note">Item tersedia di menu</div>
        </div>
        <div class="stat-icon" style="width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,0.7); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); border:1px solid rgba(229,233,230,0.85); box-shadow:0 4px 12px rgba(0,0,0,0.03), inset 0 1px 0 rgba(255,255,255,0.9); color:#111827; display:flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path>
                <line x1="6" y1="2" x2="6" y2="4"></line>
                <line x1="10" y1="2" x2="10" y2="4"></line>
                <line x1="14" y1="2" x2="14" y2="4"></line>
            </svg>
        </div>
    </div>

    {{-- Jam Terpadat --}}
    <div class="stat-card">
        <div>
            <div class="stat-label">Jam Terpadat</div>
            @if($peakHour)
                <div class="stat-value" style="font-size:16px; color:#111827;">{{ $peakHour }}</div>
                <div class="stat-note">Jam tersibuk dari data nyata</div>
            @else
                <div class="stat-value" style="color:var(--text-3); font-size:18px;">–</div>
                <div class="stat-note">Belum ada data transaksi</div>
            @endif
        </div>
        <div class="stat-icon" style="width:46px; height:46px; border-radius:12px; background:rgba(255,255,255,0.7); backdrop-filter:blur(8px); -webkit-backdrop-filter:blur(8px); border:1px solid rgba(229,233,230,0.85); box-shadow:0 4px 12px rgba(0,0,0,0.03), inset 0 1px 0 rgba(255,255,255,0.9); color:#111827; display:flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
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
                <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;" id="stat-omset-title">Omset Minggu Ini</div>
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
                <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;" id="stat-rata-note">Per hari minggu ini</div>
            </div>
            <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
                <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Jam Terpadat</div>
                <div style="font-size:20px; font-weight:800; color:#111827; margin-top:4px;">
                    {{ $peakHour ?? '–' }}
                </div>
                <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;">
                    {{ $peakHour ? 'Dari data transaksi nyata' : 'Belum ada data' }}
                </div>
            </div>
        </div>

        {{-- CANVAS CHART CONTAINER --}}
        <div style="position:relative; width:100%; height:260px; padding-top:10px;">
            <canvas id="salesChart"></canvas>
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
            maintainAspectRatio: false,
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
    function updateStats(stats, period) {
        const isWeek = period === 'minggu';
        const titleText = isWeek ? 'Omset Minggu Ini' : 'Omset Bulan Ini';
        const emptyNoteText = isWeek ? 'Belum ada pemasukan minggu ini' : 'Belum ada pemasukan bulan ini';
        const ordersNoteText = isWeek ? 'Minggu ini' : 'Bulan ini';
        const emptyOrdersNote = isWeek ? 'Belum ada pesanan minggu ini' : 'Belum ada pesanan bulan ini';
        const avgNoteText = isWeek ? 'Per hari minggu ini' : 'Per hari bulan ini';

        document.getElementById('stat-omset-title').innerText = titleText;
        document.getElementById('stat-omset').innerText       = formatRp(stats.omset);
        document.getElementById('stat-omset-note').innerText  = stats.omset > 0 ? 'Dari pesanan lunas' : emptyNoteText;
        document.getElementById('stat-transaksi').innerText   = stats.orders > 0 ? stats.orders + ' Pesanan' : '–';
        document.getElementById('stat-transaksi-note').innerText = stats.orders > 0 ? ordersNoteText : emptyOrdersNote;
        document.getElementById('stat-rata').innerText        = formatRp(stats.avgDaily);
        document.getElementById('stat-rata-note').innerText   = avgNoteText;
    }

    // ── Switch periode ──
    function switchPeriod(btn, period) {
        document.querySelectorAll('.chart-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const d = period === 'minggu' ? chartDataWeek : chartDataMonth;
        salesChart.data.labels           = d.labels;
        salesChart.data.datasets[0].data = d.omset;
        salesChart.update('active');

        updateStats(period === 'minggu' ? weekStats : monthStats, period);
    }
</script>
@endpush
@endif
