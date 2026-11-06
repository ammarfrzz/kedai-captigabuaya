@extends('admin.layouts.admin')

@section('title', 'Kelola Menu')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Daftar Menu</h1>
        <p>Update harga, status, dan informasi menu restoran Anda.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Menu Baru
        </a>
    </div>
</div>

@if (session('success'))
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<!-- TOOLBAR -->
<div class="toolbar" style="display:flex; justify-content:space-between; align-items:center;">
    <div class="toolbar-search" style="max-width:380px;">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari nama menu..." id="menu-search">
    </div>
    <select class="toolbar-select" id="filter-category" style="margin-left:auto;">
        <option value="">Semua Kategori</option>
        <option value="makanan">Makanan</option>
        <option value="kopi">Kopi</option>
        <option value="minuman">Minuman &amp; Soda</option>
        <option value="kudapan">Kudapan</option>
    </select>
</div>

<!-- TABLE -->
<div class="table-wrap" style="margin-bottom:20px;">
    <table class="data-table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama Menu <i class="fa-solid fa-sort" style="opacity:.4; margin-left:4px;"></i></th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Tag</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="menu-table-body">
            @php
            $displayMenus = isset($menus) && count($menus) > 0 ? $menus : \App\Models\Menu::orderByDesc('terlaris')->orderBy('id', 'desc')->get();
            @endphp

            @foreach($displayMenus as $m)
            <tr class="menu-row" data-category="{{ $m->kategori ?? '' }}" data-name="{{ strtolower($m->nama ?? '') }}">
                <td>
                    @if(!empty($m->gambar))
                        <img src="{{ $m->gambar }}" alt="{{ $m->nama }}" style="width:46px; height:46px; border-radius:8px; object-fit:cover; border:1px solid var(--border); display:block;">
                    @else
                        <div class="menu-thumb">🍽️</div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:700; font-size:14px; color:var(--text-1);">{{ $m->nama }}</div>
                </td>
                <td>
                    <span class="badge" style="background:#f1f5f9; color:#334155; text-transform:capitalize; font-weight:600;">
                        {{ $m->kategori }}
                    </span>
                </td>
                <td style="font-weight:700; color:var(--green-700);">
                    Rp {{ number_format($m->harga, 0, ',', '.') }}
                </td>
                <td>
                    @if($m->terlaris)
                        <span class="badge" style="background:#fef3c7; color:#92400e; border:1px solid #fde68a; font-size:11.5px; gap:4px; font-weight:700;">
                            <i class="fa-solid fa-medal" style="color:#d97706;"></i> Best Seller
                        </span>
                    @else
                        <span style="color:var(--text-3); font-size:12px;">–</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('admin.menu.edit', $m->id) }}" class="icon-btn" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.menu.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ addslashes($m->nama) }}?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn" title="Hapus" style="color:#ef4444; border-color:#fecaca; background:none; cursor:pointer;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- PAGINATION ROW -->
    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; border-top:1px solid var(--border);">
        <span id="pagination-info" style="font-size:13px; color:var(--text-3);">Menampilkan 0 menu</span>
        <div class="pagination" id="pagination-controls">
            <!-- Buttons generated dynamically via JavaScript -->
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = Array.from(document.querySelectorAll('#menu-table-body .menu-row'));
    const searchInput = document.getElementById('menu-search');
    const categorySelect = document.getElementById('filter-category');
    const paginationControls = document.getElementById('pagination-controls');
    const paginationInfo = document.getElementById('pagination-info');

    const itemsPerPage = 11;
    let currentPage = 1;

    function getFilteredRows() {
        const query = (searchInput.value || '').trim().toLowerCase();
        const selectedCat = (categorySelect.value || '').toLowerCase();

        return rows.filter(row => {
            const rowCat = (row.getAttribute('data-category') || '').toLowerCase();
            const rowName = (row.getAttribute('data-name') || '').toLowerCase();

            const matchCat = !selectedCat || rowCat === selectedCat;
            const matchSearch = !query || rowName.includes(query);

            return matchCat && matchSearch;
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

        // Hide all rows first
        rows.forEach(row => row.style.display = 'none');

        // Show rows for current page
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

        for (let i = startIndex; i < endIndex; i++) {
            filtered[i].style.display = '';
        }

        // Update info text
        if (totalItems === 0) {
            paginationInfo.textContent = 'Tidak ada menu yang ditemukan';
        } else {
            paginationInfo.textContent = `Menampilkan ${startIndex + 1} - ${endIndex} dari ${totalItems} menu terdaftar`;
        }

        // Render pagination controls
        paginationControls.innerHTML = '';

        // Prev Button
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

        // Page Number Buttons
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

        // Next Button
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

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        renderTable();
    });

    categorySelect.addEventListener('change', () => {
        currentPage = 1;
        renderTable();
    });

    renderTable();
});
</script>
@endpush

@endsection
