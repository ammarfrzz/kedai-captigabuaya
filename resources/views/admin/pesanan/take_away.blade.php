@extends('admin.layouts.admin')

@section('title', 'Pesanan Take Away')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Pesanan Take Away</h1>
        <p>Kelola pesanan bungkus bawa pulang (Take Away) pelanggan Kedai Cap Tiga Buaya.</p>
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
    <div class="toolbar-search" style="width:100%; max-width:340px;">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari No. Pesanan, Pelanggan..." id="order-search">
    </div>

    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-left:auto;">
        {{-- Filter Pembayaran --}}
        <select class="toolbar-select" id="filter-payment" style="font-size:12.5px;">
            <option value="">Semua Pembayaran</option>
            <option value="paid">🟢 Lunas</option>
            <option value="unpaid">🔴 Belum Lunas</option>
        </select>
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
                <th>Pembayaran</th>
                <th>Total Bayar</th>
                <th style="min-width:180px; text-align:right; padding-right:24px;">Aksi</th>
            </tr>
        </thead>
        <tbody id="order-table-body">
            @forelse($orders as $p)
            @php
                $itemsSummary = $p->items->map(fn($item) => "{$item->quantity}x {$item->menu_name}")->join(', ');
                $searchContent = strtolower("{$p->order_number} {$p->customer_name} {$p->customer_phone} {$itemsSummary}");
            @endphp
            <tr class="order-row" data-search="{{ $searchContent }}" data-payment="{{ $p->payment_status }}">
                <td>
                    <div style="font-weight:700; font-size:13px; color:#1a4d2b;">{{ $p->order_number }}</div>
                    <div style="font-size:11px; color:var(--text-3); margin-top:2px;">
                        <i class="fa-regular fa-clock"></i> {{ $p->created_at->format('H:i') }} WIB • {{ $p->created_at->translatedFormat('d M') }}
                    </div>
                </td>
                <td>
                    <div style="font-weight:600; font-size:13.5px; color:var(--text-1);">{{ $p->customer_name }}</div>
                    <div style="display:flex; align-items:center; gap:6px; margin-top:3px;">
                        <span class="badge" style="background:#fef3c7; color:#b45309; font-size:11px; font-weight:700;">
                            <i class="fa-solid fa-bag-shopping"></i> Take Away
                        </span>
                    </div>
                </td>
                <td style="color:var(--text-2); font-size:12.5px; max-width:240px;">
                    <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:500;" title="{{ $itemsSummary }}">
                        {{ $itemsSummary ?: 'Tidak ada item' }}
                    </div>
                    <div style="font-size:11px; color:var(--text-3); margin-top:2px;">
                        Total: {{ $p->items->sum('quantity') }} porsi
                    </div>
                </td>
                <td class="col-payment">
                    <div class="payment-badge-wrap">
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
                    <div class="payment-method-text" style="font-size:11px; color:var(--text-3); margin-top:3px; text-transform:uppercase; font-weight:600;">
                        {{ $p->payment_method ?: 'QRIS' }}
                    </div>
                    @if($p->payment_status !== 'paid')
                    <div class="btn-mark-paid-wrap" style="margin-top:6px;">
                        <button type="button" 
                                class="btn-mark-paid"
                                data-url="{{ route('admin.pesanan.markPaid', $p->id) }}"
                                data-order="{{ $p->order_number }}"
                                style="background:#16a34a; color:#ffffff; border:none; padding:4px 9px; font-size:10.5px; font-weight:700; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.15s ease;"
                                onmouseover="this.style.background='#15803d';"
                                onmouseout="this.style.background='#16a34a';"
                                title="Klik jika kasir sudah menerima uang tunai dari pelanggan">
                            <i class="fa-solid fa-check"></i>
                            <span>Terima Tunai</span>
                        </button>
                    </div>
                    @endif
                </td>
                <td style="font-weight:700; color:var(--green-700); font-size:14px; white-space:nowrap;">
                    Rp {{ number_format($p->total, 0, ',', '.') }}
                </td>
                <td style="white-space:nowrap; text-align:right; padding-right:24px;">
                    <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:8px;">
                        <a href="{{ route('admin.pesanan.show', ['id' => $p->id, 'from' => 'take_away']) }}" class="btn btn-primary btn-sm" style="background:var(--green-800); border-color:var(--green-800); color:#ffffff; font-weight:600; font-size:12px; white-space:nowrap; padding:6px 14px; border-radius:var(--radius-sm); text-decoration:none; display:inline-flex; align-items:center; gap:5px;">
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
            <tr id="empty-state-row">
                <td colspan="6" style="text-align:center; padding:40px 20px; color:var(--text-3);">
                    <i class="fa-solid fa-clipboard-list" style="font-size:30px; margin-bottom:10px; display:block; opacity:0.35;"></i>
                    <div style="font-weight:600; font-size:14px; color:var(--text-2);">Belum ada pesanan Take Away</div>
                    <div style="font-size:12.5px; margin-top:2px;">Pesanan bungkus bawa pulang akan muncul otomatis di sini.</div>
                </td>
            </tr>
            @endforelse
            <tr id="no-filter-match-row" style="display:none;">
                <td colspan="6" style="text-align:center; padding:40px 20px; color:var(--text-3);">
                    <i class="fa-solid fa-magnifying-glass" style="font-size:26px; margin-bottom:10px; display:block; opacity:0.35;"></i>
                    <div style="font-weight:600; font-size:14px; color:var(--text-2);">Tidak ada pesanan yang sesuai filter</div>
                    <div style="font-size:12.5px; margin-top:2px;">Coba gunakan kata kunci pencarian atau filter pembayaran lainnya.</div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- PAGINATION ROW -->
    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-top:1px solid var(--border);">
        <span id="pagination-info" style="font-size:13px; color:var(--text-3);">Menampilkan 0 pesanan</span>
        <div class="pagination" id="pagination-controls">
            <!-- Tombol halaman otomatis digenerate via JavaScript -->
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = Array.from(document.querySelectorAll('#order-table-body .order-row'));
    const searchInput = document.getElementById('order-search');
    const paymentSelect = document.getElementById('filter-payment');
    const paginationControls = document.getElementById('pagination-controls');
    const paginationInfo = document.getElementById('pagination-info');
    const noMatchRow = document.getElementById('no-filter-match-row');

    const itemsPerPage = 11;
    let currentPage = 1;

    function getFilteredRows() {
        const query = (searchInput.value || '').trim().toLowerCase();
        const selectedPayment = (paymentSelect.value || '').toLowerCase();

        return rows.filter(row => {
            const rowSearch = (row.getAttribute('data-search') || '').toLowerCase();
            const rowPayment = (row.getAttribute('data-payment') || '').toLowerCase();

            const matchPayment = !selectedPayment || rowPayment === selectedPayment;
            const matchSearch = !query || rowSearch.includes(query);

            return matchPayment && matchSearch;
        });
    }

    function renderTable() {
        const filtered = getFilteredRows();
        const totalItems = filtered.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }
        if (currentPage < 1) {
            currentPage = 1;
        }

        // Sembunyikan semua row pesanan
        rows.forEach(row => row.style.display = 'none');

        // Tampilkan row sesuai halaman aktif
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

        for (let i = startIndex; i < endIndex; i++) {
            filtered[i].style.display = '';
        }

        // Kelola pesan kosong
        if (noMatchRow) {
            noMatchRow.style.display = (rows.length > 0 && totalItems === 0) ? '' : 'none';
        }

        // Update info text
        if (totalItems === 0) {
            paginationInfo.textContent = rows.length === 0 ? 'Belum ada pesanan' : 'Tidak ada pesanan yang ditemukan';
        } else {
            paginationInfo.textContent = `Menampilkan ${startIndex + 1} - ${endIndex} dari ${totalItems} pesanan`;
        }

        // Render tombol pagination
        paginationControls.innerHTML = '';
        if (totalPages <= 1) {
            return;
        }

        // Tombol Sebelumnya
        const prevBtn = document.createElement('a');
        prevBtn.href = 'javascript:void(0)';
        prevBtn.className = `page-btn ${currentPage === 1 ? 'disabled' : ''}`;
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });
        paginationControls.appendChild(prevBtn);

        // Tombol Angka Halaman
        for (let p = 1; p <= totalPages; p++) {
            const pageBtn = document.createElement('a');
            pageBtn.href = 'javascript:void(0)';
            pageBtn.className = `page-btn ${p === currentPage ? 'active' : ''}`;
            pageBtn.textContent = p;
            pageBtn.addEventListener('click', ((page) => (e) => {
                e.preventDefault();
                currentPage = page;
                renderTable();
            })(p));
            paginationControls.appendChild(pageBtn);
        }

        // Tombol Selanjutnya
        const nextBtn = document.createElement('a');
        nextBtn.href = 'javascript:void(0)';
        nextBtn.className = `page-btn ${currentPage === totalPages ? 'disabled' : ''}`;
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });
        paginationControls.appendChild(nextBtn);
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            renderTable();
        });
    }

    if (paymentSelect) {
        paymentSelect.addEventListener('change', () => {
            currentPage = 1;
            renderTable();
        });
    }

    // Handler 1-Klik Kasir: Terima Tunai (Menggunakan Custom Modal Elegan)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-mark-paid');
        if (!btn) return;

        const orderNumber = btn.getAttribute('data-order');
        const url = btn.getAttribute('data-url');
        const row = btn.closest('.order-row');

        const executePayment = function() {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (row) {
                        row.setAttribute('data-payment', 'paid');
                        const badgeWrap = row.querySelector('.payment-badge-wrap');
                        if (badgeWrap) {
                            badgeWrap.innerHTML = `
                                <span class="badge" style="background:#dcfce7; color:#166534; font-size:11px; font-weight:700;">
                                    <i class="fa-solid fa-check"></i> Lunas
                                </span>
                            `;
                        }
                        const methodText = row.querySelector('.payment-method-text');
                        if (methodText && data.order && data.order.payment_method) {
                            methodText.textContent = data.order.payment_method;
                        }
                        const btnWrap = row.querySelector('.btn-mark-paid-wrap');
                        if (btnWrap) {
                            btnWrap.remove();
                        }
                    }
                } else {
                    if (window.showAdminAlert) {
                        window.showAdminAlert({
                            title: 'Gagal',
                            message: data.message || 'Gagal mengonfirmasi pembayaran.',
                            type: 'danger'
                        });
                    }
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Terima Tunai</span>';
                }
            })
            .catch(err => {
                console.error(err);
                if (window.showAdminAlert) {
                    window.showAdminAlert({
                        title: 'Terjadi Kesalahan',
                        message: 'Tidak dapat terhubung ke server. Silakan coba beberapa saat lagi.',
                        type: 'danger'
                    });
                }
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Terima Tunai</span>';
            });
        };

        if (typeof window.showAdminConfirm === 'function') {
            window.showAdminConfirm({
                title: 'Konfirmasi Terima Tunai',
                message: `Apakah Anda yakin uang tunai untuk pesanan #${orderNumber} sudah diterima dan status diubah menjadi LUNAS?`,
                type: 'success',
                confirmText: 'Ya, Tandai Lunas',
                cancelText: 'Batal',
                onConfirm: executePayment
            });
        } else {
            executePayment();
        }
    });

    renderTable();
});
</script>
@endpush

@endsection
