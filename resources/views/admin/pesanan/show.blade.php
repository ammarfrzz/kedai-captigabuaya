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
                
                {{-- Badge Tipe Pesanan --}}
                @if($order->order_type === 'dine_in')
                    <span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-chair"></i> Makan di Tempat (Meja {{ $order->table_number ?: '-' }})
                    </span>
                @else
                    <span class="badge" style="background:#fef3c7; color:#b45309; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-bag-shopping"></i> Take Away (Bungkus)
                    </span>
                @endif

                {{-- Badge Status Pesanan --}}
                @if($order->order_status === 'completed')
                    <span class="badge" style="background:#dcfce7; color:#15803d; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-circle-check"></i> Selesai
                    </span>
                @elseif($order->order_status === 'processing')
                    <span class="badge" style="background:#fef3c7; color:#b45309; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-fire-burner"></i> Dimasak
                    </span>
                @elseif($order->order_status === 'cancelled')
                    <span class="badge" style="background:#fee2e2; color:#b91c1c; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-ban"></i> Dibatalkan
                    </span>
                @else
                    <span class="badge" style="background:#f1f5f9; color:#475569; font-size:12px; font-weight:700; padding:5px 12px;">
                        <i class="fa-solid fa-hourglass-half"></i> Menunggu
                    </span>
                @endif

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
            <button type="button" onclick="window.print()" class="btn btn-outline" style="gap:8px; font-weight:700;">
                <i class="fa-solid fa-print"></i> Cetak Struk
            </button>
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

    <!-- MAIN TWO COLUMN LAYOUT -->
    <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:flex-start;">

        <!-- LEFT COLUMN: DETAIL ITEM PESANAN -->
        <div>
            <div class="section-card" style="margin-bottom:20px;">
                <div class="section-card-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <h3><i class="fa-solid fa-receipt" style="color:var(--green-600);"></i> Rincian Menu Dipesan</h3>
                        <p>Total {{ $order->items->count() }} menu dengan akumulasi {{ $order->items->sum('quantity') }} porsi hidangan.</p>
                    </div>
                    <span class="badge" style="background:#f1f5f9; color:#475569; font-weight:700; font-size:12px;">
                        {{ $order->items->sum('quantity') }} Item
                    </span>
                </div>
                <div class="section-card-body" style="padding:20px 24px;">

                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="order-item-img">
                            <img src="{{ $item->menu?->gambar ?: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=600&q=80' }}" alt="{{ $item->menu_name }}" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                            <span class="qty-badge">{{ $item->quantity }}</span>
                        </div>
                        <div class="order-item-info">
                            <div class="order-item-name" style="font-size:15px; font-weight:700; color:var(--text-1);">
                                {{ $item->menu_name }}
                            </div>
                            <div class="order-item-sub" style="font-size:13px; color:var(--text-3); margin-top:2px;">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                            @if($item->notes)
                            <div class="order-note" style="margin-top:8px; background:#fffbeb; border:1px solid #fde68a; border-radius:6px; padding:7px 10px; font-size:12px; color:#92400e; display:flex; align-items:flex-start; gap:6px;">
                                <i class="fa-regular fa-note-sticky" style="margin-top:2px; flex-shrink:0;"></i>
                                <span><strong>Catatan Item:</strong> <em>"{{ $item->notes }}"</em></span>
                            </div>
                            @endif
                        </div>
                        <div class="order-item-price" style="font-size:15px; font-weight:800; color:var(--text-1);">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach

                    <!-- CATATAN GLOBAL DARI PEMESAN -->
                    @if($order->notes)
                    <div style="background:#f8fafc; border:1.5px dashed var(--border); padding:14px 16px; border-radius:10px; margin-top:20px; font-size:13px; color:var(--text-2);">
                        <div style="font-weight:700; color:var(--text-1); margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                            <i class="fa-regular fa-message" style="color:var(--green-600);"></i>
                            <span>Catatan Tambahan dari Pelanggan:</span>
                        </div>
                        <div style="font-style:italic; line-height:1.5;">"{{ $order->notes }}"</div>
                    </div>
                    @endif

                    <!-- RINCIAN BREAKDOWN HARGA & TOTAL -->
                    <div style="margin-top:24px; padding-top:16px; border-top:1.5px solid var(--border);">
                        <table class="total-table">
                            <tr>
                                <td>Subtotal Menu ({{ $order->items->sum('quantity') }} Porsi)</td>
                                <td>Rp {{ number_format($order->subtotal ?: $order->total, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Pajak Restoran (PB1)</td>
                                <td>
                                    @if($order->tax > 0)
                                        Rp {{ number_format($order->tax, 0, ',', '.') }}
                                    @else
                                        <span style="color:var(--text-3); font-weight:500;">Rp 0 (Termasuk)</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="grand" style="border-top:2px solid var(--border); margin-top:8px;">
                                <td style="padding-top:14px; font-size:13px; font-weight:800; color:var(--text-1); text-transform:uppercase; letter-spacing:.5px;">
                                    Total Pembayaran
                                </td>
                                <td style="padding-top:14px; font-size:20px; font-weight:800; color:var(--green-700);">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: UPDATE STATUS & INFO PELANGGAN -->
        <div>
            <!-- KELOLA STATUS FORM -->
            <div class="section-card" style="margin-bottom:20px;">
                <div class="section-card-header">
                    <h3 style="font-size:12px; font-weight:700; color:var(--text-3); letter-spacing:.7px; text-transform:uppercase;">
                        <i class="fa-solid fa-sliders" style="color:var(--green-600);"></i> Kelola Status Pesanan
                    </h3>
                </div>
                <div class="section-card-body" style="padding:18px 20px;">
                    <form action="{{ route('admin.pesanan.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group" style="margin-bottom:16px;">
                            <label class="form-label" style="font-size:11px;">Status Pengerjaan</label>
                            <select name="order_status" class="form-control" style="font-weight:600; font-size:13px;">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>⏳ Menunggu / Antre</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>🍳 Sedang Dimasak</option>
                                <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>✅ Selesai Dihidangkan</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                            <div class="form-hint">Update sesuai tahapan di dapur kedai.</div>
                        </div>

                        <div class="form-group" style="margin-bottom:18px;">
                            <label class="form-label" style="font-size:11px;">Status Pembayaran</label>
                            <select name="payment_status" class="form-control" style="font-weight:600; font-size:13px;">
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>🔴 Belum Lunas</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>🟢 Lunas / Sudah Dibayar</option>
                            </select>
                            <div class="form-hint">Pastikan uang / transfer sudah diterima.</div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:11px; font-weight:700;">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Status
                        </button>
                    </form>
                </div>
            </div>

            @if($order->order_status === 'cancelled')
            <!-- HAPUS PESANAN YANG DIBATALKAN -->
            <div class="section-card" style="margin-bottom:20px; border:1px solid #fecaca; background:#fff5f5;">
                <div class="section-card-header" style="background:transparent; border-bottom:1px solid #fee2e2;">
                    <h3 style="font-size:12px; font-weight:700; color:#b91c1c; letter-spacing:.7px; text-transform:uppercase;">
                        <i class="fa-solid fa-trash-can"></i> Hapus Pesanan Dibatalkan
                    </h3>
                </div>
                <div class="section-card-body" style="padding:16px 20px;">
                    <p style="font-size:12px; color:#991b1b; line-height:1.5; margin-bottom:14px;">
                        Pesanan ini berstatus <strong>Dibatalkan</strong>. Anda dapat menghapus data pesanan ini secara permanen dari sistem.
                    </p>
                    <form action="{{ route('admin.pesanan.destroy', $order->id) }}" method="POST"
                          data-confirm="Apakah Anda yakin ingin menghapus permanen pesanan #{{ $order->order_number }} ini? Tindakan ini tidak dapat dibatalkan."
                          data-confirm-title="Hapus Pesanan Dibatalkan?"
                          data-confirm-btn="Ya, Hapus Permanen"
                          data-confirm-type="danger">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="from_show" value="1">
                        <button type="submit" class="btn btn-danger" style="width:100%; justify-content:center; background:#dc2626; color:#ffffff; border:none; padding:10px; font-weight:700; border-radius:8px; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-trash-can"></i>
                            <span>Hapus Permanen Pesanan Ini</span>
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- INFORMASI PELANGGAN & TRANSAKSI -->
            <div class="section-card" style="margin-bottom:20px;">
                <div class="section-card-header">
                    <h3 style="font-size:12px; font-weight:700; color:var(--text-3); letter-spacing:.7px; text-transform:uppercase;">
                        <i class="fa-regular fa-user" style="color:var(--green-600);"></i> Informasi Pelanggan
                    </h3>
                </div>
                <div class="section-card-body" style="padding:18px 20px;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px; padding-bottom:16px; border-bottom:1px solid var(--border);">
                        <div style="width:46px; height:46px; border-radius:50%; background:#e0f2fe; color:#0369a1; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div style="min-width:0; flex:1;">
                            <div style="font-size:15px; font-weight:700; color:var(--text-1); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $order->customer_name }}
                            </div>
                            <div style="font-size:12px; color:var(--text-3); margin-top:2px;">
                                @if($order->order_type === 'dine_in')
                                    <span style="color:#0369a1; font-weight:600;"><i class="fa-solid fa-chair"></i> Meja {{ $order->table_number ?: '-' }}</span>
                                @else
                                    <span style="color:#b45309; font-weight:600;"><i class="fa-solid fa-bag-shopping"></i> Take Away</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:10px;">
                        <div class="summary-row">
                            <span class="s-key"><i class="fa-solid fa-phone" style="width:16px;"></i> No. WhatsApp / HP</span>
                            <span class="s-val">
                                @if(!empty($order->customer_phone))
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" style="color:#16a34a; font-weight:700; text-decoration:none;">
                                        <i class="fa-brands fa-whatsapp"></i> {{ $order->customer_phone }}
                                    </a>
                                @else
                                    <span style="color:var(--text-3); font-weight:500;">Tidak dicantumkan</span>
                                @endif
                            </span>
                        </div>

                        <div class="summary-row">
                            <span class="s-key"><i class="fa-solid fa-credit-card" style="width:16px;"></i> Metode Bayar</span>
                            <span class="s-val" style="text-transform:uppercase; font-weight:700;">
                                {{ $order->payment_method ?: 'QRIS' }}
                            </span>
                        </div>

                        <div class="summary-row">
                            <span class="s-key"><i class="fa-solid fa-shield-halved" style="width:16px;"></i> Status Bayar</span>
                            <span class="s-val">
                                @if($order->payment_status === 'paid')
                                    <span style="color:#16a34a; font-weight:800;">LUNAS</span>
                                @else
                                    <span style="color:#dc2626; font-weight:800;">BELUM LUNAS</span>
                                @endif
                            </span>
                        </div>

                        <div class="summary-row">
                            <span class="s-key"><i class="fa-solid fa-utensils" style="width:16px;"></i> Tipe Pesanan</span>
                            <span class="s-val" style="font-weight:700;">
                                {{ $order->order_type === 'dine_in' ? 'Dine In (Makan di Tempat)' : 'Take Away (Bungkus)' }}
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
