@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Dashboard</h1>
        <p>Selamat datang kembali, Berikut Ringkasan Operasional Kedai Cap Tiga Buaya</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('home') }}" target="_blank" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Kunjungi Toko
        </a>
    </div>
</div>


<!-- GRAFIK PENJUALAN -->
<div style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:24px; box-shadow:var(--shadow-sm); margin-bottom:24px;">
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px; margin-bottom:22px; padding-bottom:18px; border-bottom:1px solid var(--border);">
        <div>
            <h3 style="font-size:16px; font-weight:700; color:var(--text-1);">Grafik Penjualan &amp; Pendapatan</h3>
            <p style="font-size:12.5px; color:var(--text-3); margin-top:4px;">Tren transaksi pesanan harian dan akumulasi omset Kedai Cap Tiga Buaya</p>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="display:flex; background:var(--bg); border-radius:var(--radius-sm); padding:3px; border:1px solid var(--border);">
                <button type="button" class="chart-tab active" onclick="switchPeriod(this, 'minggu')">Minggu Ini</button>
                <button type="button" class="chart-tab" onclick="switchPeriod(this, 'bulan')">Bulan Ini</button>
            </div>
        </div>
    </div>

    <!-- SUMMARY HIGHLIGHTS -->
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
        <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
            <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Omset Periode Ini</div>
            <div style="font-size:20px; font-weight:800; color:var(--green-700); margin-top:4px;" id="stat-omset">Rp 12.850.000</div>
            <div style="font-size:11.5px; color:#16a34a; margin-top:4px;"><i class="fa-solid fa-arrow-trend-up"></i> +14.2% vs periode sebelumnya</div>
        </div>
        <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
            <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Total Transaksi</div>
            <div style="font-size:20px; font-weight:800; color:var(--text-1); margin-top:4px;" id="stat-transaksi">382 Pesanan</div>
            <div style="font-size:11.5px; color:#16a34a; margin-top:4px;"><i class="fa-solid fa-arrow-trend-up"></i> +8.5% peningkatan</div>
        </div>
        <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
            <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Rata-rata Harian</div>
            <div style="font-size:20px; font-weight:800; color:var(--text-1); margin-top:4px;" id="stat-rata">Rp 1.835.000</div>
            <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;">~ 54 cup/porsi per hari</div>
        </div>
        <div style="background:var(--bg); border-radius:var(--radius-md); padding:14px 16px; border:1px solid var(--border);">
            <div style="font-size:12px; color:var(--text-3); font-weight:600; text-transform:uppercase;">Jam Terpadat (Peak Hours)</div>
            <div style="font-size:20px; font-weight:800; color:#ea580c; margin-top:4px;">18:00 - 21:00</div>
            <div style="font-size:11.5px; color:var(--text-3); margin-top:4px;">Waktu nongkrong sore &amp; malam</div>
        </div>
    </div>

    <!-- SVG INTERACTIVE SMOOTH AREA / LINE CHART (TANPA BATANG) -->
    <div style="position:relative; width:100%; overflow-x:auto; padding-top:10px;">
        <svg viewBox="0 0 800 280" style="width:100%; height:auto; min-width:600px; overflow:visible;" id="sales-svg">
            <defs>
                <linearGradient id="areaGradient" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#2d7a40" stop-opacity="0.38"></stop>
                    <stop offset="70%" stop-color="#2d7a40" stop-opacity="0.08"></stop>
                    <stop offset="100%" stop-color="#2d7a40" stop-opacity="0.0"></stop>
                </linearGradient>
                <filter id="chartGlow" x="-20%" y="-20%" width="140%" height="140%">
                    <feDropShadow dx="0" dy="4" stdDeviation="5" flood-color="#2d7a40" flood-opacity="0.25"/>
                </filter>
            </defs>

            <!-- GRID HORIZONTAL LINES -->
            <line x1="50" y1="30" x2="750" y2="30" stroke="#edf2ee" stroke-dasharray="4 4" stroke-width="1"></line>
            <text x="40" y="34" font-size="11" fill="#7a9482" text-anchor="end">Rp 2.5M</text>

            <line x1="50" y1="80" x2="750" y2="80" stroke="#edf2ee" stroke-dasharray="4 4" stroke-width="1"></line>
            <text x="40" y="84" font-size="11" fill="#7a9482" text-anchor="end">Rp 2.0M</text>

            <line x1="50" y1="130" x2="750" y2="130" stroke="#edf2ee" stroke-dasharray="4 4" stroke-width="1"></line>
            <text x="40" y="134" font-size="11" fill="#7a9482" text-anchor="end">Rp 1.5M</text>

            <line x1="50" y1="180" x2="750" y2="180" stroke="#edf2ee" stroke-dasharray="4 4" stroke-width="1"></line>
            <text x="40" y="184" font-size="11" fill="#7a9482" text-anchor="end">Rp 1.0M</text>

            <line x1="50" y1="230" x2="750" y2="230" stroke="#e0e8e2" stroke-width="1.5"></line>
            <text x="40" y="234" font-size="11" fill="#7a9482" text-anchor="end">Rp 0</text>

            <!-- VERTICAL GUIDE LINES (SUBTLE) -->
            <line x1="100" y1="30" x2="100" y2="230" stroke="#f4f7f5" stroke-width="1"></line>
            <line x1="200" y1="30" x2="200" y2="230" stroke="#f4f7f5" stroke-width="1"></line>
            <line x1="300" y1="30" x2="300" y2="230" stroke="#f4f7f5" stroke-width="1"></line>
            <line x1="400" y1="30" x2="400" y2="230" stroke="#f4f7f5" stroke-width="1"></line>
            <line x1="500" y1="30" x2="500" y2="230" stroke="#f4f7f5" stroke-width="1"></line>
            <line x1="600" y1="30" x2="600" y2="230" stroke="#f4f7f5" stroke-width="1"></line>
            <line x1="700" y1="30" x2="700" y2="230" stroke="#f4f7f5" stroke-width="1"></line>

            <!-- SMOOTH CURVE AREA -->
            <path id="chart-area" d="M 100 230 L 100 135 C 150 115, 170 110, 200 110 C 240 110, 260 145, 300 145 C 340 145, 360 90, 400 90 C 440 90, 460 70, 500 70 C 540 70, 560 45, 600 45 C 640 45, 660 60, 700 60 L 700 230 Z" fill="url(#areaGradient)"></path>

            <!-- SMOOTH CURVE LINE -->
            <path id="chart-line" d="M 100 135 C 150 115, 170 110, 200 110 C 240 110, 260 145, 300 145 C 340 145, 360 90, 400 90 C 440 90, 460 70, 500 70 C 540 70, 560 45, 600 45 C 640 45, 660 60, 700 60" fill="none" stroke="#2d7a40" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" filter="url(#chartGlow)"></path>

            <!-- DATA POINTS & VALUE LABELS -->
            <!-- Senin -->
            <g class="chart-point">
                <circle cx="100" cy="135" r="5.5" fill="#ffffff" stroke="#2d7a40" stroke-width="3"></circle>
                <text x="100" y="117" font-size="11.5" font-weight="700" fill="#1b4d2b" text-anchor="middle">1.45M</text>
                <text x="100" y="252" font-size="12" font-weight="600" fill="#4d6655" text-anchor="middle">Senin</text>
            </g>

            <!-- Selasa -->
            <g class="chart-point">
                <circle cx="200" cy="110" r="5.5" fill="#ffffff" stroke="#2d7a40" stroke-width="3"></circle>
                <text x="200" y="92" font-size="11.5" font-weight="700" fill="#1b4d2b" text-anchor="middle">1.70M</text>
                <text x="200" y="252" font-size="12" font-weight="600" fill="#4d6655" text-anchor="middle">Selasa</text>
            </g>

            <!-- Rabu -->
            <g class="chart-point">
                <circle cx="300" cy="145" r="5.5" fill="#ffffff" stroke="#2d7a40" stroke-width="3"></circle>
                <text x="300" y="127" font-size="11.5" font-weight="700" fill="#1b4d2b" text-anchor="middle">1.35M</text>
                <text x="300" y="252" font-size="12" font-weight="600" fill="#4d6655" text-anchor="middle">Rabu</text>
            </g>

            <!-- Kamis -->
            <g class="chart-point">
                <circle cx="400" cy="90" r="5.5" fill="#ffffff" stroke="#2d7a40" stroke-width="3"></circle>
                <text x="400" y="72" font-size="11.5" font-weight="700" fill="#1b4d2b" text-anchor="middle">1.90M</text>
                <text x="400" y="252" font-size="12" font-weight="600" fill="#4d6655" text-anchor="middle">Kamis</text>
            </g>

            <!-- Jumat -->
            <g class="chart-point">
                <circle cx="500" cy="70" r="5.5" fill="#ffffff" stroke="#2d7a40" stroke-width="3"></circle>
                <text x="500" y="52" font-size="11.5" font-weight="700" fill="#1b4d2b" text-anchor="middle">2.10M</text>
                <text x="500" y="252" font-size="12" font-weight="600" fill="#4d6655" text-anchor="middle">Jumat</text>
            </g>

            <!-- Sabtu (Peak) -->
            <g class="chart-point">
                <circle cx="600" cy="45" r="7" fill="#facc15" stroke="#133920" stroke-width="3"></circle>
                <text x="600" y="25" font-size="12" font-weight="800" fill="#1a4d2b" text-anchor="middle">2.35M ⭐</text>
                <text x="600" y="252" font-size="12" font-weight="700" fill="#1a4d2b" text-anchor="middle">Sabtu</text>
            </g>

            <!-- Minggu -->
            <g class="chart-point">
                <circle cx="700" cy="60" r="5.5" fill="#ffffff" stroke="#2d7a40" stroke-width="3"></circle>
                <text x="700" y="42" font-size="11.5" font-weight="700" fill="#1b4d2b" text-anchor="middle">2.00M</text>
                <text x="700" y="252" font-size="12" font-weight="600" fill="#4d6655" text-anchor="middle">Minggu</text>
            </g>
        </svg>
    </div>

    <!-- LEGEND FOOTER -->
    <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:flex-start; gap:20px; margin-top:20px; padding-top:14px; border-top:1px solid #f1f5f3; font-size:12.5px; color:var(--text-3);">
        <span style="display:flex; align-items:center; gap:6px;">
            <span style="width:18px; height:3px; background:#2d7a40; border-radius:2px;"></span>
            Tren Penjualan &amp; Pendapatan
        </span>
        <span style="display:flex; align-items:center; gap:6px;">
            <span style="width:8px; height:8px; border-radius:50%; background:#facc15; border:1px solid #133920;"></span>
            Puncak Penjualan (Weekend)
        </span>
    </div>
</div>

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
    .chart-tab:hover {
        color: var(--text-1);
    }
    .chart-tab.active {
        background: var(--surface);
        color: var(--green-800);
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
    }
    .chart-point circle {
        transition: r 0.2s ease, stroke-width 0.2s ease;
    }
    .chart-point:hover circle {
        r: 8px;
        stroke-width: 4px;
    }
</style>
@endpush

@push('scripts')
<script>
    function switchPeriod(btn, period) {
        document.querySelectorAll('.chart-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const omsetEl = document.getElementById('stat-omset');
        const transEl = document.getElementById('stat-transaksi');
        const rataEl = document.getElementById('stat-rata');

        if (period === 'minggu') {
            omsetEl.innerText = 'Rp 12.850.000';
            transEl.innerText = '382 Pesanan';
            if (rataEl) rataEl.innerText = 'Rp 1.835.000';
        } else {
            omsetEl.innerText = 'Rp 42.500.000';
            transEl.innerText = '1.284 Pesanan';
            if (rataEl) rataEl.innerText = 'Rp 1.416.000';
        }
    }
</script>
@endpush

@endsection
