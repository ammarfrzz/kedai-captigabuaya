@extends('admin.layouts.admin')

@section('title', 'Pesanan Dine In')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Pesanan Dine In</h1>
        <p>Kelola pesanan makan di tempat (Dine In) beserta nomor meja pelanggan Kedai Cap Tiga Buaya.</p>
    </div>
</div>

<!-- TOOLBAR -->
<div class="toolbar">
    <form action="{{ route('admin.pesanan.dine_in') }}" method="GET" style="display:flex; width:100%; max-width:380px;">
        <div class="toolbar-search" style="width:100%;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Meja, Pesanan, Pelanggan..." id="order-search">
        </div>
    </form>
</div>

<!-- TABLE DINE IN -->
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Menu Dipesan</th>
                <th>Status</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $p)
            <tr>
                <td>
                    <div style="font-weight:700; font-size:12.5px; color:#1a4d2b;">{{ $p->order_number }}</div>
                    @if($p->table_number)
                        <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:11px; margin-top:3px;">Meja {{ $p->table_number }}</span>
                    @endif
                </td>
                <td>
                    <div style="font-weight:600;">{{ $p->customer_name }}</div>
                    <div style="font-size:11.5px; color:var(--text-3);"><i class="fa-solid fa-utensils"></i> Makan di Tempat</div>
                </td>
                <td style="color:var(--text-2); font-size:12.5px; max-width:240px;">
                    @php
                        $itemsSummary = $p->items->map(fn($item) => "{$item->quantity}x {$item->menu_name}")->join(', ');
                    @endphp
                    <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $itemsSummary }}">
                        {{ $itemsSummary ?: 'Tidak ada item' }}
                    </div>
                </td>
                <td>
                    @if($p->order_status === 'completed')
                        <span class="badge" style="background:#dcfce7; color:#15803d;">Selesai</span>
                    @elseif($p->order_status === 'processing')
                        <span class="badge" style="background:#fef3c7; color:#b45309;">Dimasak</span>
                    @elseif($p->order_status === 'cancelled')
                        <span class="badge" style="background:#fee2e2; color:#b91c1c;">Dibatalkan</span>
                    @else
                        <span class="badge" style="background:#f1f5f9; color:#475569;">Menunggu</span>
                    @endif
                </td>
                <td style="font-weight:700; color:var(--green-700);">
                    Rp {{ number_format($p->total, 0, ',', '.') }}
                </td>
                <td>
                    <a href="{{ route('admin.pesanan.show', ['id' => $p->id, 'from' => 'dine_in']) }}" class="btn btn-primary btn-sm" style="background:var(--green-800); border-color:var(--green-800); color:#ffffff; font-weight:600; font-size:12px; white-space:nowrap; padding:6px 14px; border-radius:var(--radius-sm); text-decoration:none; display:inline-block;">
                        Detail Pesanan
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:30px; color:var(--text-3);">
                    <i class="fa-solid fa-clipboard-list" style="font-size:24px; margin-bottom:8px; display:block; opacity:0.4;"></i>
                    Belum ada pesanan Dine In saat ini.
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
