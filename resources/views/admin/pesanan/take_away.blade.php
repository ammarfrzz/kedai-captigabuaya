@extends('admin.layouts.admin')

@section('title', 'Pesanan Take Away')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Pesanan Take Away</h1>
        <p>Kelola pesanan bungkus bawa pulang (Take Away) pelanggan Kedai Cap Tiga Buaya.</p>
    </div>
</div>

<!-- TOOLBAR -->
<div class="toolbar">
    <div class="toolbar-search" style="max-width:380px;">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari No. Pesanan, Pelanggan..." id="order-search">
    </div>
</div>

<!-- TABLE TAKE AWAY -->
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Menu Dipesan</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $takeAwayOrders = [
                ['ord'=>'TKW-2023-0501','name'=>'Hendro Kusuma','phone'=>'0812-3456-7890','items'=>'3x Kopi Butter, 2x Ropang Srikaya','total'=>'Rp 90.000','id'=>89],
                ['ord'=>'TKW-2023-0502','name'=>'Putri Ramadhani','phone'=>'0857-1122-3344','items'=>'2x Nasi Goreng Mawut, 2x Teh Tarik','total'=>'Rp 86.000','id'=>89],
                ['ord'=>'TKW-2023-0503','name'=>'Agus Setiawan','phone'=>'0819-9988-7766','items'=>'1x Nasi Telur Barendo, 1x Es Kopi Karamel 124','total'=>'Rp 42.000','id'=>89],
                ['ord'=>'TKW-2023-0504','name'=>'Reza Kurniawan','phone'=>'0878-5544-3322','items'=>'4x Es Teh Manis, 2x Kentang Goreng','total'=>'Rp 84.000','id'=>89],
                ['ord'=>'TKW-2023-0505','name'=>'Linda Wahyuni','phone'=>'0821-4433-2211','items'=>'2x Susu Matcha, 1x Risol (2 pcs)','total'=>'Rp 62.000','id'=>89],
                ['ord'=>'TKW-2023-0506','name'=>'Bayu Pratama','phone'=>'0813-8877-6655','items'=>'2x Mie Nyemek, 2x Soda Gembira','total'=>'Rp 76.000','id'=>89],
                ['ord'=>'TKW-2023-0507','name'=>'Maya Safitri','phone'=>'0852-3344-5566','items'=>'1x Nasi Lemak Ayam CTB, 1x Kopi Tubruk Susu','total'=>'Rp 41.000','id'=>89],
            ];
            @endphp
            @foreach($takeAwayOrders as $p)
            <tr>
                <td>
                    <div style="font-weight:700; font-size:12.5px; color:#1a4d2b;">{{ $p['ord'] }}</div>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $p['name'] }}</div>
                    <div style="font-size:11.5px; color:var(--text-3);"><i class="fa-solid fa-bag-shopping"></i> Bungkus Bawa Pulang</div>
                </td>
                <td style="color:var(--text-2); font-size:12.5px; max-width:240px;">
                    <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $p['items'] }}">
                        {{ $p['items'] }}
                    </div>
                </td>
                <td style="font-weight:700; color:var(--green-700);">{{ $p['total'] }}</td>
                <td>
                    <a href="{{ route('admin.pesanan.show', ['id' => $p['id'], 'from' => 'take_away']) }}" class="btn btn-primary btn-sm" style="background:var(--green-800); border-color:var(--green-800); color:#ffffff; font-weight:600; font-size:12px; white-space:nowrap; padding:6px 14px; border-radius:var(--radius-sm); text-decoration:none; display:inline-block;">
                        Detail Pembayaran
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-top:1px solid var(--border);">
        <span style="font-size:13px; color:var(--text-3);">Menampilkan 7 pesanan Take Away terbaru</span>
        <div class="pagination">
            <a href="#" class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></a>
            <a href="#" class="page-btn active">1</a>
            <a href="#" class="page-btn">2</a>
            <a href="#" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
        </div>
    </div>
</div>

@endsection
