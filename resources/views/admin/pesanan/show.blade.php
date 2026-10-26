@extends('admin.layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')

@php
    $backRoute = (request('from') === 'take_away' || str_contains(url()->previous(), 'take-away')) 
        ? route('admin.pesanan.take_away') 
        : route('admin.pesanan.dine_in');
@endphp
<a href="{{ $backRoute }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat Pesanan
</a>

<!-- HEADER -->
<div class="page-header" style="margin-bottom:20px;">
    <div class="page-header-left">
        <h1 style="margin-bottom:0;">ORD-20231024-089</h1>
    </div>
    <div class="page-header-right">
        <div style="display:flex; gap:16px; align-items:center;">
            <span style="font-size:13px; color:var(--text-3);">
                <i class="fa-regular fa-calendar"></i> 24 Oktober 2023
            </span>
            <span style="font-size:13px; color:var(--text-3);">
                <i class="fa-regular fa-clock"></i> 12:45 WIB
            </span>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 300px; gap:20px; align-items:flex-start;">

    <!-- LEFT -->
    <div>
        <!-- RINCIAN PESANAN -->
        <div class="section-card" style="margin-bottom:16px;">
            <div class="section-card-header">
                <div>
                    <h3><i class="fa-solid fa-bag-shopping" style="color:var(--green-600);"></i> Rincian Pesanan</h3>
                    <p>Total 3 Menu Terpilih</p>
                </div>
            </div>
            <div class="section-card-body">

                <!-- ITEM 1 -->
                <div class="order-item">
                    <div class="order-item-img">
                        <img src="https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&q=80" alt="Nasi Telur Barendo" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                        <span class="qty-badge">2</span>
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">Nasi Telur Barendo</div>
                        <div class="order-item-sub">Rp 18.000</div>
                        <div class="order-note">
                            <i class="fa-regular fa-note-sticky"></i>
                            <span><strong>CATATAN KHUSUS</strong><br><em>"Tolong telurnya digoreng garing krispi."</em></span>
                        </div>
                    </div>
                    <div class="order-item-price">Rp 36.000</div>
                </div>

                <!-- ITEM 2 -->
                <div class="order-item">
                    <div class="order-item-img">
                        <img src="https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&q=80" alt="Nasi Goreng Mawut" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                        <span class="qty-badge">2</span>
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">Nasi Goreng Mawut</div>
                        <div class="order-item-sub">Rp 25.000</div>
                    </div>
                    <div class="order-item-price">Rp 50.000</div>
                </div>

                <!-- ITEM 3 -->
                <div class="order-item">
                    <div class="order-item-img">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&q=80" alt="Kopi Butter" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
                        <span class="qty-badge">2</span>
                    </div>
                    <div class="order-item-info">
                        <div class="order-item-name">Kopi Butter (Signature)</div>
                        <div class="order-item-sub">Rp 18.000</div>
                        <div class="order-note">
                            <i class="fa-regular fa-note-sticky"></i>
                            <span><strong>CATATAN KHUSUS</strong><br><em>"Panas, mentega jangan terlalu banyak."</em></span>
                        </div>
                    </div>
                    <div class="order-item-price">Rp 36.000</div>
                </div>

                <!-- TOTAL -->
                <div style="margin-top:20px; padding-top:8px;">
                    <table class="total-table">
                        <tr class="grand" style="border:none;">
                            <td style="border-top:none; padding-top:0;">Total Pembayaran</td>
                            <td style="border-top:none; padding-top:0;">Rp 122.000</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT -->
    <div>
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
                        👩
                    </div>
                    <div>
                        <div style="font-size:14.5px; font-weight:700;">Siti Aminah</div>
                        <div style="font-size:12px; color:var(--text-3);">ID Pelanggan: CUST-8221</div>
                    </div>
                </div>
                <div class="contact-row"><i class="fa-regular fa-envelope"></i> siti.aminah@email.com</div>
                <div class="contact-row"><i class="fa-solid fa-phone"></i> +62 812-3456-7890</div>
                <div class="contact-row" style="margin-top:4px;">
                    <i class="fa-solid fa-building-columns"></i>
                    <span>Pembayaran: <strong>Transfer Bank (BCA)</strong></span>
                </div>
                <button class="btn btn-outline" style="width:100%; justify-content:center; margin-top:14px;">
                    Hubungi Pelanggan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
