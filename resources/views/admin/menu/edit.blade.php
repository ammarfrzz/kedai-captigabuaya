@extends('admin.layouts.admin')

@section('title', 'Edit Menu')

@section('content')

<a href="{{ route('admin.menu.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Menu
</a>

<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Menu</h1>
        <p>Perbarui informasi, harga, atau status menu yang sudah ada.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline">Batalkan</a>
        <button type="submit" form="form-edit-menu" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
        </button>
    </div>
</div>

<form id="form-edit-menu" action="{{ route('admin.menu.update', $menu->id ?? $id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    @if ($errors->any())
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 20px;">
            <strong><i class="fa-solid fa-circle-exclamation"></i> Terjadi kesalahan:</strong>
            <ul style="margin-left: 20px; margin-top: 6px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div style="display:grid; grid-template-columns:1fr 400px; gap:24px; align-items:stretch;">
    <!-- INFORMASI DASAR (KIRI) -->
    <div class="section-card" style="margin-bottom:0; display:flex; flex-direction:column;">
        <div class="section-card-header">
            <h3><i class="fa-solid fa-utensils" style="color:var(--green-600);"></i> Informasi Dasar</h3>
            <p>Nama menu, kategori, dan harga hidangan.</p>
        </div>
        <div class="section-card-body" style="flex:1;">
            @php
            $currentNama      = $menu->nama ?? '';
            $currentKategori  = strtolower($menu->kategori ?? 'makanan');
            $currentHarga     = $menu->harga ?? 0;
            $currentDeskripsi = $menu->deskripsi ?? '';
            $currentGambar    = $menu->gambar ?? 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&q=80';
            $currentTerlaris  = (bool) ($menu->terlaris ?? false);
            @endphp

            <div class="form-group">
                <label class="form-label">Nama Menu <span class="req">*</span></label>
                <input type="text" name="nama_menu" class="form-control" value="{{ $currentNama }}" id="nama_menu">
            </div>

            <div class="form-group">
                <label class="form-label">Kategori <span class="req">*</span></label>
                <select name="kategori" class="form-control" id="kategori">
                    <option value="makanan" {{ $currentKategori === 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="kopi" {{ $currentKategori === 'kopi' ? 'selected' : '' }}>Kopi</option>
                    <option value="minuman" {{ $currentKategori === 'minuman' ? 'selected' : '' }}>Minuman &amp; Soda</option>
                    <option value="kudapan" {{ $currentKategori === 'kudapan' ? 'selected' : '' }}>Kudapan</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Harga (RP) <span class="req">*</span></label>
                <input type="number" name="harga" class="form-control" value="{{ $currentHarga }}" id="harga">
            </div>

            <div class="form-group">
                <label class="form-label" for="deskripsi">Deskripsi Menu</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4">{{ $currentDeskripsi }}</textarea>
            </div>

            {{-- ── TAG BEST SELLER ── --}}
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Tag Produk</label>
                <div class="toggle-wrap">
                    <div class="toggle-info">
                        <div class="toggle-title">
                            <i class="fa-solid fa-fire" style="color:#f97316; margin-right:6px;"></i>
                            Best Seller
                        </div>
                        <div class="toggle-desc">Tandai menu ini sebagai produk terlaris / unggulan di daftar menu pelanggan.</div>
                    </div>
                    <label class="toggle">
                        <input type="checkbox" name="terlaris" value="1" id="toggle-terlaris"
                            {{ $currentTerlaris ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- FOTO MENU (KANAN) -->
    <div class="section-card" style="margin-bottom:0; display:flex; flex-direction:column; height:100%;">
        <div class="section-card-header">
            <h3><i class="fa-solid fa-image" style="color:var(--green-600);"></i> Foto Menu</h3>
            <p>Unggah foto hidangan.</p>
        </div>
        <div class="section-card-body" style="display:flex; flex-direction:column; align-items:center; text-align:center; padding:28px 20px 24px; flex:1;">
            <!-- PREVIEW GAMBAR ASLI DARI KATALOG (DIBESARKAN & KE ATAS) -->
            <div style="width:240px; height:175px; border-radius:12px; overflow:hidden; border:1px solid var(--border); margin-bottom:10px; background:#fff; box-shadow:var(--shadow-sm);">
                <img id="menu-photo-preview" src="{{ $currentGambar }}" alt="{{ $currentNama }}" style="width:100%; height:100%; object-fit:cover; display:block;">
            </div>

            <div style="font-weight:700; font-size:13px; color:var(--text-1); margin-bottom:14px;">Foto Menu Saat Ini</div>

            <!-- BUTTON GANTI FOTO -->
            <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('foto-input').click()" style="width:100%; max-width:230px; justify-content:center;">
                <i class="fa-solid fa-arrow-up-from-bracket"></i> Ganti Foto
            </button>
            <input type="file" id="foto-input" name="foto" accept="image/*" style="display:none;" onchange="previewSelectedImage(this)">

            <!-- INFORMASI PENGUNGGAHAN FOTO DI BAWAH BUTTON GANTI FOTO -->
            <div style="font-size:11.5px; color:var(--text-3); line-height:1.6; margin-top:16px; max-width:310px;">
                <i class="fa-solid fa-circle-info" style="color:var(--green-600);"></i> Format: JPG, PNG, atau WEBP. Rekomendasi rasio 4:3 atau 1:1 dengan ukuran maksimal 2 MB.
            </div>
        </div>
    </div>
</div>
</form>

@push('scripts')
<script>
function previewSelectedImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('menu-photo-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
