@extends('admin.layouts.admin')

@section('title', 'Pesanan Dine In')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Pesanan Dine In</h1>
        <p>Kelola pesanan makan di tempat (Dine In) beserta nomor meja pelanggan Kedai Cap Tiga Buaya.</p>
    </div>
</div>

@if (session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<!-- TOOLBAR -->
<div class="toolbar" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
    <form action="{{ route('admin.pesanan.dine_in') }}" method="GET" style="display:flex; width:100%; max-width:340px;">
        <div class="toolbar-search" style="width:100%;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Meja, Pesanan, Pelanggan..." id="order-search">
        </div>
    </form>

    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-left:auto;">
        {{-- Filter Pembayaran --}}
        <form id="filter-form" action="{{ route('admin.pesanan.dine_in') }}" method="GET" style="display:flex; gap:10px;">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <select name="payment" class="toolbar-select" onchange="document.getElementById('filter-form').submit()" style="font-size:12.5px;">
                <option value="">Semua Pembayaran</option>
                <option value="paid" {{ request('payment') === 'paid' ? 'selected' : '' }}>🟢 Lunas</option>
                <option value="unpaid" {{ request('payment') === 'unpaid' ? 'selected' : '' }}>🔴 Belum Lunas</option>
            </select>

            @if(request('payment') || request('search'))
                <a href="{{ route('admin.pesanan.dine_in') }}" class="btn btn-outline btn-sm" style="font-size:12px;" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            @endif
        </form>
    </div>
</div>

<!-- TABLE DINE IN -->
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Menu Dipesan</th>
                <th>Pembayaran</th>
                <th>Total Bayar</th>
                <th style="min-width:180px; text-align:right; padding-right:24px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $p)
            <tr>
                <td>
                    <div style="font-weight:700; font-size:13px; color:#1a4d2b;">{{ $p->order_number }}</div>
                    <div style="font-size:11px; color:var(--text-3); margin-top:2px;">
                        <i class="fa-regular fa-clock"></i> {{ $p->created_at->format('H:i') }} WIB • {{ $p->created_at->translatedFormat('d M') }}
                    </div>
                </td>
                <td>
                    <div style="font-weight:600; font-size:13.5px; color:var(--text-1);">{{ $p->customer_name }}</div>
                    <div style="display:flex; align-items:center; gap:6px; margin-top:3px;">
                        <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:11px; font-weight:700;">
                            <i class="fa-solid fa-chair"></i> Meja {{ $p->table_number ?: '-' }}
                        </span>
                    </div>
                </td>
                <td style="color:var(--text-2); font-size:12.5px; max-width:240px;">
                    @php
                        $itemsSummary = $p->items->map(fn($item) => "{$item->quantity}x {$item->menu_name}")->join(', ');
                    @endphp
                    <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:500;" title="{{ $itemsSummary }}">
                        {{ $itemsSummary ?: 'Tidak ada item' }}
                    </div>
                    <div style="font-size:11px; color:var(--text-3); margin-top:2px;">
                        Total: {{ $p->items->sum('quantity') }} porsi
                    </div>
                </td>
                <td>
                    <div>
                        @if($p->payment_status === 'paid')
                            <span class="badge" style="background:#dcfce7; color:#166534; font-size:11px; font-weight:700;">
                                <i class="fa-solid fa-check"></i> Lunas
                            </span>
                        @else
                            <span class="badge" style="background:#fee2e2; color:#991b1b; font-size:11px; font-weight:700;">
                                <i class="fa-solid fa-clock"></i> Belum Lunas
                            </span>
                        @endif
                    </div>
                    <div style="font-size:11px; color:var(--text-3); margin-top:3px; text-transform:uppercase; font-weight:600;">
                        {{ $p->payment_method ?: 'QRIS' }}
                    </div>
                </td>
                <td style="font-weight:700; color:var(--green-700); font-size:14px; white-space:nowrap;">
                    Rp {{ number_format($p->total, 0, ',', '.') }}
                </td>
                <td style="white-space:nowrap; text-align:right; padding-right:24px;">
                    <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:8px;">
                        <a href="{{ route('admin.pesanan.show', ['id' => $p->id, 'from' => 'dine_in']) }}" class="btn btn-primary btn-sm" style="background:var(--green-800); border-color:var(--green-800); color:#ffffff; font-weight:600; font-size:12px; white-space:nowrap; padding:6px 14px; border-radius:var(--radius-sm); text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
                            <span>Detail</span>
                            <i class="fa-solid fa-chevron-right" style="font-size:10px;"></i>
                        </a>
                        @if($p->order_status === 'cancelled')
                        <form action="{{ route('admin.pesanan.destroy', $p->id) }}" method="POST"
                              data-confirm="Apakah Anda yakin ingin menghapus permanen pesanan yang dibatalkan ini (#{{ $p->order_number }})? Data tidak dapat dipulihkan."
                              data-confirm-title="Hapus Pesanan Dibatalkan?"
                              data-confirm-btn="Ya, Hapus Permanen"
                              data-confirm-type="danger"
                              style="display:inline-block; margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" title="Hapus Pesanan yang Dibatalkan" style="background:#fee2e2; border:1px solid #fca5a5; color:#b91c1c; font-weight:600; font-size:12px; padding:6px 12px; border-radius:var(--radius-sm); cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:all 0.15s ease;" onmouseover="this.style.background='#dc2626'; this.style.color='#fff';" onmouseout="this.style.background='#fee2e2'; this.style.color='#b91c1c';">
                                <i class="fa-solid fa-trash-can"></i>
                                <span>Hapus</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:40px 20px; color:var(--text-3);">
                    <i class="fa-solid fa-clipboard-list" style="font-size:30px; margin-bottom:10px; display:block; opacity:0.35;"></i>
                    <div style="font-weight:600; font-size:14px; color:var(--text-2);">Belum ada pesanan Dine In</div>
                    <div style="font-size:12.5px; margin-top:2px;">Pesanan makan di tempat akan muncul otomatis di sini.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-top:1px solid var(--border);">
        <span style="font-size:13px; color:var(--text-3);">Menampilkan {{ $orders->count() }} dari total {{ $orders->total() }} pesanan</span>
        <div>
            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection
