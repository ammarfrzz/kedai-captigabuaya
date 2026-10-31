@extends('admin.layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')

<a href="{{ route('admin.menu.index') }}" class="back-link">
    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Menu
</a>

<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Menu Baru</h1>
        <p>Isi detail di bawah ini untuk menambahkan hidangan baru ke dalam daftar menu restoran.</p>
    </div>
    <div class="page-header-right">
        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline">Batalkan</a>
        <button type="submit" form="form-tambah-menu" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Menu
        </button>
    </div>
</div>

<form id="form-tambah-menu" action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

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
            <p>Nama menu, kategori, dan harga hidangan baru.</p>
        </div>
        <div class="section-card-body" style="flex:1;">
            <div class="form-group">
                <label class="form-label" for="nama_menu">Nama Menu <span class="req">*</span></label>
                <input type="text" id="nama_menu" name="nama_menu" class="form-control"
                    placeholder="Contoh: Nasi Goreng Spesial">
            </div>

            <div class="form-group">
                <label class="form-label" for="kategori">Kategori <span class="req">*</span></label>
                <select id="kategori" name="kategori" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <option value="makanan">Makanan</option>
                    <option value="kopi">Kopi</option>
                    <option value="minuman">Minuman &amp; Soda</option>
                    <option value="kudapan">Kudapan</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="harga">Harga (RP) <span class="req">*</span></label>
                <input type="number" id="harga" name="harga" class="form-control"
                    placeholder="0" min="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="deskripsi">Deskripsi Menu</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4"
                    placeholder="Jelaskan bahan-bahan, rasa, atau keunikan menu ini..."></textarea>
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
                        <input type="checkbox" name="terlaris" value="1" id="toggle-terlaris">
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
            <!-- PREVIEW GAMBAR (DIBESARKAN & KE ATAS) -->
            <div id="preview-container" style="width:240px; height:175px; border-radius:12px; overflow:hidden; border:1.5px dashed var(--border); margin-bottom:10px; background:#f8faf9; display:flex; align-items:center; justify-content:center;">
                <div id="preview-placeholder" style="display:flex; flex-direction:column; align-items:center; gap:6px; color:var(--text-3);">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size:32px;"></i>
                    <span style="font-size:12px;">Belum ada foto</span>
                </div>
                <img id="menu-photo-preview" src="" alt="Preview Menu" style="width:100%; height:100%; object-fit:cover; display:none;">
            </div>

            <div style="font-weight:700; font-size:13px; color:var(--text-1); margin-bottom:14px;">Foto Menu Baru</div>

            <!-- BUTTON PILIH/GANTI FOTO -->
            <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('foto-input').click()" style="width:100%; max-width:230px; justify-content:center;">
                <i class="fa-solid fa-arrow-up-from-bracket"></i> Pilih Foto
            </button>
            <input type="file" id="foto-input" name="foto" accept="image/*" style="display:none;" onchange="previewFoto(this)">

            <!-- INFORMASI PENGUNGGAHAN FOTO DI BAWAH BUTTON -->
            <div style="font-size:11.5px; color:var(--text-3); line-height:1.6; margin-top:16px; max-width:310px;">
                <i class="fa-solid fa-circle-info" style="color:var(--green-600);"></i> Format: JPG, PNG, atau WEBP. Rekomendasi rasio 4:3 atau 1:1 dengan ukuran maksimal 2 MB.
            </div>
        </div>
    </div>

</div>
</form>

@endsection

@push('scripts')
<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.getElementById('menu-photo-preview');
            const placeholder = document.getElementById('preview-placeholder');
            const container = document.getElementById('preview-container');

            previewImg.src = e.target.result;
            previewImg.style.display = 'block';
            placeholder.style.display = 'none';
            container.style.borderStyle = 'solid';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
