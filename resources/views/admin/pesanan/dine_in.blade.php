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
    <div class="toolbar-search" style="max-width:380px;">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari No. Meja, Pesanan, Pelanggan..." id="order-search">
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
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $dineInOrders = [
                ['ord'=>'DIN-2023-0101','name'=>'Ahmad Subarjo','guest'=>2,'items'=>'2x Nasi Telur Barendo, 2x Kopi Butter','total'=>'Rp 72.000','id'=>89],
                ['ord'=>'DIN-2023-0102','name'=>'Siti Aminah','guest'=>3,'items'=>'2x Nasi Goreng Mawut, 1x Es Kopi Karamel, 2x Teh Tarik','total'=>'Rp 110.000','id'=>89],
                ['ord'=>'DIN-2023-0103','name'=>'Bambang Wijaya','guest'=>4,'items'=>'4x Mie Nyemek, 4x Soda Gembira, 1x Risol','total'=>'Rp 170.000','id'=>89],
                ['ord'=>'DIN-2023-0104','name'=>'Dewi Lestari','guest'=>2,'items'=>'2x Ropang Srikaya, 2x Kopi Tubruk Susu','total'=>'Rp 68.000','id'=>89],
                ['ord'=>'DIN-2023-0105','name'=>'Rudi Hermawan','guest'=>1,'items'=>'1x Nasi Lemak Ayam CTB, 1x Es Teh Manis','total'=>'Rp 37.000','id'=>89],
                ['ord'=>'DIN-2023-0106','name'=>'Farhan Ramadhan','guest'=>2,'items'=>'2x Kwetiau, 2x Es Kopi Uno','total'=>'Rp 82.000','id'=>89],
                ['ord'=>'DIN-2023-0107','name'=>'Anisa Putri','guest'=>3,'items'=>'1x Nasi Gila, 2x Ropang Keju, 3x Susu Matcha','total'=>'Rp 127.000','id'=>89],
            ];
            @endphp
            @foreach($dineInOrders as $p)
            <tr>
                <td>
                    <div style="font-weight:700; font-size:12.5px; color:#1a4d2b;">{{ $p['ord'] }}</div>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $p['name'] }}</div>
                    <div style="font-size:11.5px; color:var(--text-3);"><i class="fa-solid fa-utensils"></i> Makan di Tempat</div>
                </td>
                <td style="color:var(--text-2); font-size:12.5px; max-width:240px;">
                    <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $p['items'] }}">
                        {{ $p['items'] }}
                    </div>
                </td>
                <td style="font-weight:700; color:var(--green-700);">{{ $p['total'] }}</td>
                <td>
                    <a href="{{ route('admin.pesanan.show', ['id' => $p['id'], 'from' => 'dine_in']) }}" class="btn btn-primary btn-sm" style="background:var(--green-800); border-color:var(--green-800); color:#ffffff; font-weight:600; font-size:12px; white-space:nowrap; padding:6px 14px; border-radius:var(--radius-sm); text-decoration:none; display:inline-block;">
                        Detail Pembayaran
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-top:1px solid var(--border);">
        <span style="font-size:13px; color:var(--text-3);">Menampilkan 7 pesanan Dine In terbaru</span>
        <div class="pagination">
            <a href="#" class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></a>
            <a href="#" class="page-btn active">1</a>
            <a href="#" class="page-btn">2</a>
            <a href="#" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
        </div>
    </div>
</div>

@endsection
