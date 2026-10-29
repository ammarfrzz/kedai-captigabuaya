@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

@php
    $backRoute = (request('from') === 'take_away' || $order->order_type === 'take_away') 
        ? route('admin.pesanan.take_away') 
        : route('admin.pesanan.dine_in');
@endphp
<a href="{{ $backRoute }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Pesanan
</a>

@if(session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<!-- HEADER -->
<div class="page-header" style="margin-bottom:20px;">
    <div class="page-header-left">
        <h1 style="margin-bottom:0;">{{ $order->order_number }}</h1>
        <div style="margin-top: 6px;">
            <span class="badge" style="background:{{ $order->order_type === 'dine_in' ? '#e0f2fe' : '#fef3c7' }}; color:{{ $order->order_type === 'dine_in' ? '#0369a1' : '#b45309' }}; text-transform:uppercase;">
                {{ $order->order_type === 'dine_in' ? 'Makan di Tempat (Meja ' . ($order->table_number ?? '-') . ')' : 'Take Away (Bungkus)' }}
            </span>
        </div>
    </div>
    <div class="page-header-right">
        <div style="display:flex; gap:16px; align-items:center;">
            <span style="font-size:13px; color:var(--text-3);">
                <i class="fa-regular fa-calendar"></i> {{ $order->created_at->translatedFormat('d F Y') }}
            </span>
            <span style="font-size:13px; color:var(--text-3);">
                <i class="fa-regular fa-clock"></i> {{ $order->created_at->format('H:i') }} WIB
            </span>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:flex-start;">

    <!-- LEFT -->
    <div>
        <!-- RINCIAN PESANAN -->
        <div class="section-card" style="margin-bottom:16px;">
            <div class="section-card-header">
                <div>
                    <h3><i class="fa-solid fa-bag-shopping" style="color:var(--green-600);"></i> Rincian Pesanan</h3>
                    <p>Total {{ $order->items->count() }} Menu Terpilih</p>
                </div>
            </div>
            <div class="section-card-body">

                @foreach($order->items as $item)
                <div class="order-item">
                    <div class="order-item-img">
                        <img src="{{ $item->menu->gambar ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80' }}" alt="{{ $item->menu_name }}" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                        <span class="qty-badge">{{ $item->quantity }}</span>
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">{{ $item->menu_name }}</div>
                        <div class="order-item-sub">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        @if($item->notes)
                        <div class="order-note">
                            <i class="fa-regular fa-note-sticky"></i>
                            <span><strong>CATATAN KHUSUS:</strong> <em>"{{ $item->notes }}"</em></span>
                        </div>
                        @endif
                    </div>
                    <div class="order-item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>
                @endforeach

                <!-- CATATAN GLOBAL PESANAN -->
                @if($order->notes)
                <div style="background:#f8fafc; border:1px dashed var(--border); padding:12px 14px; border-radius:8px; margin-top:16px; font-size:12.5px; color:var(--text-2);">
                    <strong>Catatan Pemesan:</strong> "{{ $order->notes }}"
                </div>
                @endif

                <!-- TOTAL -->
                <div style="margin-top:20px; padding-top:8px;">
                    <table class="total-table">
                        <tr class="grand" style="border:none;">
                            <td style="border-top:none; padding-top:0;">Total Pembayaran</td>
                            <td style="border-top:none; padding-top:0;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div>
        <!-- UPDATE STATUS PESANAN -->
        <div class="section-card" style="margin-bottom:16px;">
            <div class="section-card-header">
                <h3 style="font-size:11px; font-weight:700; color:var(--text-3); letter-spacing:.7px; text-transform:uppercase;">
                    <i class="fa-solid fa-sliders"></i> Kelola Status
                </h3>
            </div>
            <div class="section-card-body" style="padding:16px;">
                <form action="{{ route('admin.pesanan.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group" style="margin-bottom:14px;">
                        <label class="form-label">Status Pesanan</label>
                        <select name="order_status" class="form-control">
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>⏳ Menunggu / Antre</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>🍳 Sedang Dimasak</option>
                            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>✅ Selesai Dihidangkan</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom:16px;">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-control">
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Lunas / Dibayar</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Status
                    </button>
                </form>
            </div>
        </div>

        <!-- INFO PELANGGAN -->
        <div class="section-card" style="margin-bottom:16px;">
            <div class="section-card-header">
                <h3 style="font-size:11px; font-weight:700; color:var(--text-3); letter-spacing:.7px; text-transform:uppercase;">
                    <i class="fa-regular fa-user"></i> Informasi Pelanggan
                </h3>
            </div>
            <div class="section-card-body" style="padding:16px;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px; padding-bottom:14px; border-bottom:1px solid var(--border);">
                    <div style="width:44px; height:44px; border-radius:50%; background:var(--bg); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">
                        👤
                    </div>
                    <div>
                        <div style="font-size:14.5px; font-weight:700;">{{ $order->customer_name }}</div>
                        <div style="font-size:12px; color:var(--text-3);">{{ $order->order_type === 'dine_in' ? 'Meja: ' . ($order->table_number ?? '-') : 'Take Away' }}</div>
                    </div>
                </div>
                <div class="contact-row" style="margin-top:4px;">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Metode: <strong style="text-transform:uppercase;">{{ $order->payment_method ?: 'QRIS' }}</strong></span>
                </div>
                <div class="contact-row" style="margin-top:4px;">
                    <i class="fa-solid fa-circle-check" style="color:{{ $order->payment_status === 'paid' ? '#16a34a' : '#ea580c' }};"></i>
                    <span>Status: <strong>{{ $order->payment_status === 'paid' ? 'LUNAS' : 'BELUM DIBAYAR' }}</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
