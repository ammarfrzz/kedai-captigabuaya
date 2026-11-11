@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')

@php
    $backRoute = (request('from') === 'take_away' || $order->order_type === 'take_away') 
        ? route('admin.pesanan.take_away') 
        : route('admin.pesanan.dine_in');
    $backLabel = ($order->order_type === 'take_away') ? 'Pesanan Take Away' : 'Pesanan Dine In';
@endphp

<div class="no-print">
    <a href="{{ $backRoute }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke {{ $backLabel }}
    </a>

    @if(session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- HEADER DETAIL PESANAN -->
    <div class="page-header" style="margin-bottom:22px; align-items:center;">
        <div class="page-header-left">
            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                <h1 style="margin-bottom:0; font-size:24px;">{{ $order->order_number }}</h1>
                
                {{-- Badge Status Bayar --}}
                @if($order->payment_status === 'paid')
                    <span class="badge" style="background:#dcfce7; color:#166534; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-check"></i> LUNAS
                    </span>
                @else
                    <span class="badge" style="background:#fee2e2; color:#991b1b; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-clock"></i> BELUM LUNAS
                    </span>
                @endif
            </div>

            <div style="margin-top:6px; font-size:12.5px; color:var(--text-3); display:flex; align-items:center; gap:16px;">
                <span><i class="fa-regular fa-calendar"></i> {{ $order->created_at->translatedFormat('l, d F Y') }}</span>
                <span><i class="fa-regular fa-clock"></i> {{ $order->created_at->format('H:i') }} WIB ({{ $order->created_at->diffForHumans() }})</span>
            </div>
        </div>

        <div class="page-header-right" style="display:flex; gap:10px; align-items:center;">
            @if($order->payment_status !== 'paid')
            <form action="{{ route('admin.pesanan.markPaid', $order->id) }}" method="POST" style="margin:0;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn" style="background:#16a34a; color:#ffffff; border:none; padding:8px 16px; border-radius:var(--radius-sm); font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-check"></i> Terima Pembayaran Tunai
                </button>
            </form>
            @endif

            @if($order->order_status === 'cancelled')
            <form action="{{ route('admin.pesanan.destroy', $order->id) }}" method="POST"
                  data-confirm="Apakah Anda yakin ingin menghapus permanen pesanan yang dibatalkan ini (#{{ $order->order_number }})? Data tidak dapat dipulihkan."
                  data-confirm-title="Hapus Pesanan Dibatalkan?"
                  data-confirm-btn="Ya, Hapus Permanen"
                  data-confirm-type="danger"
                  style="margin:0;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="from_show" value="1">
                <button type="submit" class="btn btn-danger" style="gap:6px; font-weight:700; background:#dc2626; color:#fff; border:none; padding:8px 16px; border-radius:var(--radius-sm); cursor:pointer; display:inline-flex; align-items:center;">
                    <i class="fa-solid fa-trash-can"></i> Hapus Pesanan
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- MAIN SINGLE COLUMN CONTAINER -->
    <div style="max-width:880px; margin:0 auto;">
        <div class="section-card" style="margin-bottom:20px; box-shadow:0 1px 3px rgba(0,0,0,0.06);">
            <!-- HEADER RINCIAN & IDENTITAS PEMESAN -->
            <div class="section-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; padding:18px 24px; border-bottom:1px solid var(--border);">
                <div>
                    <h3 style="font-size:16px; font-weight:700; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-receipt" style="color:var(--green-600);"></i> Rincian Menu Dipesan
                    </h3>
                    <p style="margin:3px 0 0; font-size:13px; color:var(--text-3);">
                        Pelanggan: <strong style="color:var(--text-1);">{{ $order->customer_name }}</strong>
                        @if($order->order_type === 'dine_in')
                            <span style="color:var(--border); margin:0 6px;">|</span>
                            <span style="color:#0369a1; font-weight:600;"><i class="fa-solid fa-chair"></i> Meja {{ $order->table_number ?: '-' }}</span>
                        @else
                            <span style="color:var(--border); margin:0 6px;">|</span>
                            <span style="color:#b45309; font-weight:600;"><i class="fa-solid fa-bag-shopping"></i> Take Away</span>
                        @endif
                        @if(!empty($order->customer_phone))
                            <span style="color:var(--border); margin:0 6px;">|</span>
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" style="color:#16a34a; font-weight:600; text-decoration:none;">
                                <i class="fa-brands fa-whatsapp"></i> {{ $order->customer_phone }}
                            </a>
                        @endif
                    </p>
                </div>
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="badge" style="background:#f8fafc; border:1px solid var(--border); color:var(--text-2); font-weight:700; font-size:12px; padding:6px 12px; text-transform:uppercase;">
                        {{ $order->payment_method ?: 'QRIS' }}
                    </span>
                </div>
            </div>

            <div class="section-card-body" style="padding:24px 28px;">
                <!-- LIST ITEM MENU -->
                <div style="display:flex; flex-direction:column; gap:22px;">
                    @foreach($order->items as $item)
                    <div class="order-item" style="padding:0; border-bottom:none;">
                        <div class="order-item-img" style="width:68px; height:68px; border-radius:10px; overflow:hidden; flex-shrink:0;">
                            <img src="{{ $item->menu?->gambar ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80' }}" alt="{{ $item->menu_name }}" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div class="order-item-info" style="flex:1; padding:0 18px;">
                            <div class="order-item-name" style="font-size:15.5px; font-weight:700; color:var(--text-1);">
                                {{ $item->menu_name }}
                            </div>
                            <div class="order-item-sub" style="font-size:13px; color:var(--text-3); margin-top:3px;">
                                {{ $item->quantity }} porsi &times; Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                            @if($item->notes)
                            <div class="order-note" style="margin-top:8px; background:#fffbeb; border:1px solid #fde68a; border-radius:6px; padding:6px 10px; font-size:12px; color:#92400e; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fa-regular fa-note-sticky" style="flex-shrink:0;"></i>
                                <span>Catatan: <em>"{{ $item->notes }}"</em></span>
                            </div>
                            @endif
                        </div>
                        <div class="order-item-price" style="font-size:16px; font-weight:800; color:var(--text-1); text-align:right;">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- CATATAN GLOBAL DARI PEMESAN -->
                @if($order->notes)
                <div style="background:#f8fafc; border:1.5px dashed var(--border); padding:14px 18px; border-radius:10px; margin-top:20px; font-size:13px; color:var(--text-2);">
                    <div style="font-weight:700; color:var(--text-1); margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                        <i class="fa-regular fa-message" style="color:var(--green-600);"></i>
                        <span>Catatan Tambahan Pesanan:</span>
                    </div>
                    <div style="font-style:italic; line-height:1.5;">"{{ $order->notes }}"</div>
                </div>
                @endif

                <!-- RINCIAN BREAKDOWN HARGA & TOTAL -->
                <div style="margin-top:36px; padding-top:24px; border-top:1.5px solid var(--border);">
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; font-size:13.5px; color:var(--text-2);">
                            <span>Subtotal Menu ({{ $order->items->sum('quantity') }} Porsi)</span>
                            <span style="font-weight:600; color:var(--text-1);">Rp {{ number_format($order->subtotal ?: $order->total, 0, ',', '.') }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; font-size:13.5px; color:var(--text-2);">
                            <span>Pajak Restoran (PB1)</span>
                            <span>
                                @if($order->tax > 0)
                                    <strong style="color:var(--text-1);">Rp {{ number_format($order->tax, 0, ',', '.') }}</strong>
                                @else
                                    <span style="color:var(--text-3); font-weight:500;">Rp 0 (Termasuk)</span>
                                @endif
                            </span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center; padding-top:14px; margin-top:4px;">
                            <span style="font-size:14px; font-weight:800; color:var(--text-1); text-transform:uppercase; letter-spacing:0.5px;">
                                Total Pembayaran
                            </span>
                            <span style="font-size:20px; font-weight:800; color:var(--green-700);">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════
     STRUK NOTA CETAK (KHUSUS TAMPIL SAAT DI-PRINT / WINDOW.PRINT)
     ══════════════════════════════════════════════════════════════════ --}}
<div class="print-only-receipt" style="display:none;">
    <div style="max-width:320px; margin:0 auto; font-family:'Courier New', Courier, monospace; color:#000; font-size:12px; line-height:1.4;">
        <div style="text-align:center; padding-bottom:8px; border-bottom:1px dashed #000; margin-bottom:8px;">
            <div style="font-size:16px; font-weight:bold;">KEDAI CAP TIGA BUAYA</div>
            <div style="font-size:10px;">Jl. Jemursari IX No. 9, Surabaya</div>
            <div style="font-size:10px;">WhatsApp: 0877-6610-2500</div>
        </div>

        <div style="margin-bottom:8px; font-size:11px;">
            <div>Nota   : {{ $order->order_number }}</div>
            <div>Waktu  : {{ $order->created_at->format('d/m/Y H:i') }} WIB</div>
            <div>Nama   : {{ $order->customer_name }}</div>
            <div>Tipe   : {{ $order->order_type === 'dine_in' ? 'Dine In (Meja ' . ($order->table_number ?: '-') . ')' : 'Take Away (Bungkus)' }}</div>
            <div>Kasir  : {{ Auth::user()?->name ?? 'Admin' }}</div>
        </div>

        <div style="border-top:1px dashed #000; border-bottom:1px dashed #000; padding:6px 0; margin-bottom:8px;">
            @foreach($order->items as $item)
            <div style="display:flex; justify-content:space-between; margin-bottom:3px;">
                <span>{{ $item->quantity }}x {{ $item->menu_name }}</span>
                <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($item->notes)
            <div style="font-size:10px; font-style:italic; padding-left:10px; margin-bottom:2px;">* {{ $item->notes }}</div>
            @endif
            @endforeach
        </div>

        <div style="font-size:11px; margin-bottom:8px;">
            <div style="display:flex; justify-content:space-between;">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->subtotal ?: $order->total, 0, ',', '.') }}</span>
            </div>
            @if($order->tax > 0)
            <div style="display:flex; justify-content:space-between;">
                <span>PB1 (Pajak):</span>
                <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
            </div>
            @endif
            <div style="display:flex; justify-content:space-between; font-weight:bold; font-size:13px; margin-top:4px;">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; margin-top:3px;">
                <span>Metode Bayar:</span>
                <span style="text-transform:uppercase;">{{ $order->payment_method ?: 'QRIS' }}</span>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span>Status:</span>
                <span>{{ $order->payment_status === 'paid' ? 'LUNAS' : 'BELUM DIBAYAR' }}</span>
            </div>
        </div>

        @if($order->notes)
        <div style="border-top:1px dashed #000; padding-top:6px; font-size:10px; margin-bottom:8px;">
            Catatan: {{ $order->notes }}
        </div>
        @endif

        <div style="text-align:center; border-top:1px dashed #000; padding-top:8px; font-size:10px;">
            <div>Terima Kasih atas Kunjungan Anda!</div>
            <div>Nikmati Kehangatan Rasa Kopitiam Kami</div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    @media print {
        body {
            background: #fff !important;
            color: #000 !important;
        }
        .sidebar, .topbar, .back-link, .page-header, .no-print {
            display: none !important;
        }
        .page-content {
            padding: 0 !important;
            margin: 0 !important;
        }
        .print-only-receipt {
            display: block !important;
            width: 100% !important;
            padding: 10px !important;
        }
    }
</style>
@endpush
