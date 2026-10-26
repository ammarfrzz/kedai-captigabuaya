@extends('admin.layouts.admin')

@section('title', 'Menu Terlaris')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Menu Terlaris</h1>
        <p>Daftar produk dengan penjualan dan ulasan tertinggi di Kedai Cap Tiga Buaya.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Semua Menu
        </a>
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Menu
        </a>
    </div>
</div>

<!-- STATS SUMMARY -->
<div class="stat-grid" style="margin-bottom:24px;">
    <div class="stat-card">
        <div>
            <div class="stat-label">Total Menu Unggulan</div>
            <div class="stat-value">5 Item</div>
        </div>
        <div class="stat-icon" style="background:#eaf5ee; color:#1a4d2b;">
            <i class="fa-solid fa-list-ol"></i>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Rata-rata Rating</div>
            <div class="stat-value">4.9 <span style="font-size:14px; font-weight:500; color:var(--text-3);">/ 5.0</span></div>
            <div class="stat-note up"><i class="fa-solid fa-arrow-trend-up"></i> Feedback positif</div>
        </div>
        <div class="stat-icon" style="background:#eaf5ee; color:#1a4d2b;">
            <i class="fa-solid fa-star"></i>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Total Ulasan Masuk</div>
            <div class="stat-value">{{ number_format(collect($terlarisMenus)->take(5)->sum('ulasan'), 0, ',', '.') }}</div>
            <div class="stat-note" style="color:var(--text-3); font-weight:500;">Dari seluruh pembeli terverifikasi</div>
        </div>
        <div class="stat-icon" style="background:#eaf5ee; color:#1a4d2b;">
            <i class="fa-solid fa-comment-dots"></i>
        </div>
    </div>
    <div class="stat-card">
        <div>
            <div class="stat-label">Rata-rata Pembelian</div>
            <div class="stat-value">Rp 28.500 <span style="font-size:13px; font-weight:500; color:var(--text-3);">/ pelanggan</span></div>
            <div class="stat-note up"><i class="fa-solid fa-arrow-trend-up"></i> Nilai per transaksi</div>
        </div>
        <div class="stat-icon" style="background:#eaf5ee; color:#1a4d2b;">
            <i class="fa-solid fa-basket-shopping"></i>
        </div>
    </div>
</div>

<!-- LEADERBOARD TABLE -->
<div class="table-wrap" style="margin-bottom:28px;">
    <div style="padding:18px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
        <div>
            <h3 style="font-size:15px; font-weight:700; color:var(--text-1); margin:0;">Top 5 Peringkat Menu Terlaris</h3>
            <p style="font-size:12px; color:var(--text-3); margin-top:3px; margin-bottom:0;">5 menu dengan tingkat penjualan dan kepuasan pelanggan tertinggi</p>
        </div>
        <a href="https://www.google.com/maps/place/Kedai+Cap+Tiga+Buaya/@-7.3214466,112.7399411,715m/data=!3m1!1e3!4m8!3m7!1s0x2dd7fb4dc4e7c851:0x6c4bf8055536605f!8m2!3d-7.3214466!4d112.7399411!9m1!1b1!16s%2Fg%2F11xs2ycj5l?entry=ttu&g_ep=EgoyMDI2MTAyMC4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer" style="display:inline-flex; align-items:center; gap:8px; background:var(--green-800); color:#ffffff; padding:7px 14px; border-radius:var(--radius-sm); font-size:12.5px; font-weight:600; text-decoration:none; transition:all var(--transition); box-shadow:0 1px 3px rgba(0,0,0,.1);" onmouseover="this.style.background='var(--green-700)'" onmouseout="this.style.background='var(--green-800)'">
            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px;"></i>
            <span>Cek Ulasan</span>
        </a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:70px; text-align:center;">Peringkat</th>
                <th style="width:72px;">Foto</th>
                <th>Nama Produk</th>
                <th style="width:140px;">Kategori</th>
                <th style="width:160px; text-align:right;">Harga</th>
                <th style="width:160px; text-align:center;">Rating &amp; Ulasan</th>
            </tr>
        </thead>
        <tbody>
            @foreach(collect($terlarisMenus)->take(5) as $index => $item)
            @php
                $rank = $index + 1;
            @endphp
            <tr>
                <!-- POSISI / PERINGKAT -->
                <td style="text-align:center;">
                    @if($rank === 1)
                        <span class="rank-badge rank-1" title="Peringkat 1">1</span>
                    @elseif($rank === 2)
                        <span class="rank-badge rank-2" title="Peringkat 2">2</span>
                    @elseif($rank === 3)
                        <span class="rank-badge rank-3" title="Peringkat 3">3</span>
                    @else
                        <span class="rank-badge rank-default">{{ $rank }}</span>
                    @endif
                </td>

                <!-- FOTO PRODUK -->
                <td>
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" class="product-thumb">
                </td>

                <!-- NAMA PRODUK -->
                <td>
                    <div style="font-weight:700; font-size:14px; color:var(--text-1);">
                        {{ $item['nama'] }}
                    </div>
                </td>

                <!-- KATEGORI -->
                <td>
                    <span class="badge badge-gray" style="text-transform:capitalize;">
                        {{ $item['kategori'] }}
                    </span>
                </td>

                <!-- HARGA -->
                <td style="text-align:right; font-weight:700; color:var(--green-700); font-size:13.5px;">
                    Rp {{ number_format($item['harga'], 0, ',', '.') }}
                </td>

                <!-- RATING & ULASAN -->
                <td style="text-align:center;">
                    <div style="font-weight:600; font-size:13px; color:var(--text-1);">
                        <i class="fa-solid fa-star" style="color:#eab308; font-size:11px;"></i> {{ $item['rating'] }}
                    </div>
                    <div style="font-size:11.5px; color:var(--text-3); margin-top:2px;">
                        {{ number_format($item['ulasan'], 0, ',', '.') }} ulasan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('styles')
<style>
    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 13px;
        line-height: 1;
    }
    .rank-1 {
        background: #fef08a;
        color: #854d0e;
        border: 1px solid #facc15;
        box-shadow: 0 1px 3px rgba(234, 179, 8, 0.25);
    }
    .rank-2 {
        background: #e2e8f0;
        color: #334155;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(100, 116, 139, 0.2);
    }
    .rank-3 {
        background: #eddcd2;
        color: #5c3d2e;
        border: 1px solid #c9a798;
        box-shadow: 0 1px 3px rgba(92, 61, 46, 0.2);
    }
    .rank-default {
        background: #f8fafc;
        color: #64748b;
        border: 1px solid var(--border);
    }
    .product-thumb {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        border: 1px solid var(--border);
        display: block;
    }
</style>
@endpush

@endsection
