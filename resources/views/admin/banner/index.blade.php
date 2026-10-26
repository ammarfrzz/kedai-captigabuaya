@extends('admin.layouts.admin')

@section('title', 'Kelola Gambar')

@section('content')

@if(session('success'))
<div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; border-radius:var(--radius-md); padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:12px; font-weight:600; box-shadow:var(--shadow-sm);">
    <i class="fa-solid fa-circle-check" style="font-size:18px;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; border-radius:var(--radius-md); padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:12px; font-weight:600; box-shadow:var(--shadow-sm);">
    <i class="fa-solid fa-triangle-exclamation" style="font-size:18px;"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<div class="page-header">
    <div class="page-header-left">
        <h1>Kelola Gambar</h1>
        <p>Kelola semua foto di website yang meliputi beranda, gallery, dan bagian lainya secara langsung</p>
    </div>
</div>

<!-- FILTER TABS & SEARCH -->
<div class="toolbar" style="margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <div style="display:flex; gap:6px; flex-wrap:wrap; background:var(--surface); padding:4px; border:1px solid var(--border); border-radius:var(--radius-md);">
        <a href="{{ route('admin.banner.index', ['section' => 'semua']) }}" class="btn btn-sm {{ $sectionFilter === 'semua' ? 'btn-primary' : 'btn-outline' }}" style="border-radius:6px; font-weight:600;">
            Semua Bagian ({{ $stats['total'] }})
        </a>
        <a href="{{ route('admin.banner.index', ['section' => 'beranda']) }}" class="btn btn-sm {{ $sectionFilter === 'beranda' ? 'btn-primary' : 'btn-outline' }}" style="border-radius:6px; font-weight:600;">
            <i class="fa-solid fa-house"></i> Beranda / Hero
        </a>
        <a href="{{ route('admin.banner.index', ['section' => 'galeri']) }}" class="btn btn-sm {{ $sectionFilter === 'galeri' ? 'btn-primary' : 'btn-outline' }}" style="border-radius:6px; font-weight:600;">
            <i class="fa-solid fa-camera"></i> Galeri Foto
        </a>
        <a href="{{ route('admin.banner.index', ['section' => 'tentang']) }}" class="btn btn-sm {{ $sectionFilter === 'tentang' ? 'btn-primary' : 'btn-outline' }}" style="border-radius:6px; font-weight:600;">
            <i class="fa-solid fa-book-open"></i> Tentang Kami
        </a>
        <a href="{{ route('admin.banner.index', ['section' => 'kenapa-kami']) }}" class="btn btn-sm {{ $sectionFilter === 'kenapa-kami' ? 'btn-primary' : 'btn-outline' }}" style="border-radius:6px; font-weight:600;">
            <i class="fa-solid fa-star"></i> Kenapa Kami
        </a>
        <a href="{{ route('admin.banner.index', ['section' => 'cta']) }}" class="btn btn-sm {{ $sectionFilter === 'cta' ? 'btn-primary' : 'btn-outline' }}" style="border-radius:6px; font-weight:600;">
            <i class="fa-solid fa-map-pin"></i> Banner Kunjungan
        </a>
    </div>

    <div style="margin-left:auto; display:flex; align-items:center; gap:8px; font-size:12.5px; color:var(--text-3);">
        <i class="fa-solid fa-circle-info" style="color:var(--green-600);"></i> Perubahan foto langsung terlihat seketika di website customer.
    </div>
</div>

<!-- MEDIA CARDS GRID -->
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(360px, 1fr)); gap:20px; margin-bottom:40px;">
    @forelse($filteredMedia as $media)
    <div style="background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; box-shadow:var(--shadow-sm); display:flex; flex-direction:column; transition:transform 0.2s, box-shadow 0.2s;">
        <!-- IMAGE PREVIEW HEADER -->
        <div style="position:relative; width:100%; height:200px; background:#1e293b; overflow:hidden;">
            <img src="{{ $media['url'] }}" alt="{{ $media['label'] }}" style="width:100%; height:100%; object-fit:cover; display:block;">
            <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);"></div>


            <!-- RASIO & DIMENSI OVERLAY -->
            <div style="position:absolute; bottom:10px; left:14px; right:14px; display:flex; justify-content:space-between; align-items:center; color:#fff; font-size:11.5px; opacity:0.9;">
                <span><i class="fa-solid fa-crop-simple"></i> Rasio: {{ $media['aspek_rasio'] }}</span>
                <span><i class="fa-regular fa-image"></i> {{ $media['dimensi_anjuran'] }}</span>
            </div>
        </div>

        <!-- DETAILS -->
        <div style="padding:18px 20px; flex:1; display:flex; flex-direction:column;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:6px;">
                <h3 style="font-size:15px; font-weight:700; color:var(--text-1); line-height:1.3;">
                    {{ $media['label'] }}
                </h3>
            </div>

            <p style="font-size:12.5px; color:var(--text-2); margin-bottom:16px; line-height:1.5;">
                {{ $media['deskripsi'] }}
            </p>

            @if(!empty($media['updated_at']))
            <div style="font-size:11.5px; color:var(--text-3); margin-bottom:14px; display:flex; align-items:center; gap:6px;">
                <i class="fa-solid fa-clock-rotate-left"></i> Terakhir diubah: <strong>{{ $media['updated_at'] }}</strong>
            </div>
            @endif

            <!-- ACTIONS -->
            <div style="margin-top:auto; padding-top:14px; border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:10px;">
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    style="flex:1;"
                    onclick="openEditModal('{{ $media['id'] }}', '{{ addslashes($media['label']) }}', '{{ addslashes($media['section_label']) }}', '{{ $media['url'] }}', '{{ $media['dimensi_anjuran'] }}', '{{ $media['aspek_rasio'] }}')"
                >
                    <i class="fa-solid fa-pen-to-square"></i> Ganti Gambar
                </button>

                @if(!empty($media['custom_url']))
                <form action="{{ route('admin.banner.reset') }}" method="POST" onsubmit="return confirm('Kembalikan gambar ini ke foto default bawaan?');" style="margin:0;">
                    @csrf
                    <input type="hidden" name="media_id" value="{{ $media['id'] }}">
                    <button type="submit" class="btn btn-outline btn-sm" style="color:#dc2626; border-color:#fecaca;" title="Reset ke Default Bawaan">
                        <i class="fa-solid fa-arrow-rotate-left"></i> Reset
                    </button>
                </form>
                @endif

                <button type="button" class="btn btn-outline btn-sm" title="Lihat Foto Ukuran Asli" onclick="openLightbox('{{ $media['url'] }}', '{{ addslashes($media['label']) }}')">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1; background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); padding:40px; text-align:center;">
        <i class="fa-solid fa-images" style="font-size:40px; color:var(--text-3); margin-bottom:12px;"></i>
        <h3 style="font-size:16px; font-weight:700;">Tidak ada gambar di kategori ini</h3>
        <p style="color:var(--text-2); font-size:13px; margin-top:6px;">Silakan pilih filter 'Semua Bagian' untuk melihat seluruh gambar landing page.</p>
    </div>
    @endforelse
</div>

<!-- MODAL GANTI GAMBAR -->
<div id="modalEditMedia" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(3px); z-index:9999; align-items:center; justify-content:center; padding:20px; overflow-y:auto;">
    <div style="background:var(--surface); border-radius:var(--radius-lg); width:100%; max-width:540px; box-shadow:var(--shadow-xl); border:1px solid var(--border); overflow:hidden; animation:modalFadeIn 0.2s ease-out; margin:auto;">
        
        <!-- MODAL HEADER -->
        <div style="padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background:var(--bg);">
            <div>
                <h3 style="font-size:16px; font-weight:700; color:var(--text-1);" id="modalTitle">Ganti Gambar</h3>
                <span id="modalSectionBadge" style="font-size:11.5px; color:var(--green-700); font-weight:600;">Bagian Landing Page</span>
            </div>
            <button type="button" onclick="closeEditModal()" style="background:none; border:none; font-size:18px; color:var(--text-3); cursor:pointer; padding:4px 8px; border-radius:4px;">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- MODAL BODY -->
        <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data" style="padding:22px 24px;">
            @csrf
            <input type="hidden" name="media_id" id="modalMediaId">

            <!-- PREVIEW BOX -->
            <div style="margin-bottom:18px;">
                <label class="form-label" style="font-size:12px; font-weight:700; text-transform:uppercase; color:var(--text-3);">Pratinjau Gambar Saat Ini</label>
                <div style="width:100%; height:160px; background:#0f172a; border-radius:var(--radius-md); overflow:hidden; border:1px solid var(--border); position:relative;">
                    <img id="modalPreviewImg" src="" style="width:100%; height:100%; object-fit:cover;">
                    <div id="modalHint" style="position:absolute; bottom:8px; right:10px; background:rgba(0,0,0,0.7); color:#fff; font-size:11px; padding:3px 8px; border-radius:4px;">
                        Anjuran: 800 x 600 px
                    </div>
                </div>
            </div>

            <!-- PILIH CARA GANTI: UPLOAD ATAU URL -->
            <div style="margin-bottom:16px;">
                <label class="form-label" style="font-weight:700;">Unggah File Gambar Baru (Komputer / HP)</label>
                <div style="border:2px dashed var(--border); border-radius:var(--radius-md); padding:16px; text-align:center; background:var(--bg); cursor:pointer;" onclick="document.getElementById('inputImageFile').click()">
                    <i class="fa-solid fa-cloud-arrow-up" style="font-size:28px; color:var(--green-600); margin-bottom:8px;"></i>
                    <div style="font-size:13px; font-weight:600; color:var(--text-1);" id="fileNameDisplay">Klik untuk memilih foto baru dari perangkat</div>
                    <div style="font-size:11px; color:var(--text-3); margin-top:4px;">Format didukung: JPG, PNG, WEBP, SVG (Maks. 5 MB)</div>
                </div>
                <input type="file" name="image_file" id="inputImageFile" accept="image/*" style="display:none;" onchange="handleFileSelected(this)">
            </div>

            <div style="text-align:center; margin:12px 0; font-size:12px; color:var(--text-3); font-weight:700;">
                ─── ATAU MENGGUNAKAN TAUTAN URL ───
            </div>

            <div class="form-group" style="margin-bottom:20px;">
                <label class="form-label" style="font-weight:700;">URL Gambar Langsung (Opsional)</label>
                <input type="url" name="custom_url" id="inputCustomUrl" class="form-control" placeholder="https://images.unsplash.com/... atau URL gambar eksternal">
                <div style="font-size:11px; color:var(--text-3); margin-top:4px;">Isi jika Anda ingin menggunakan foto dari internet (Unsplash, Imgur, Cloudinary, dll).</div>
            </div>

            <!-- MODAL ACTIONS -->
            <div style="display:flex; justify-content:flex-end; gap:10px; padding-top:14px; border-top:1px solid var(--border);">
                <button type="button" class="btn btn-outline" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Gambar
                </button>
            </div>
        </form>

    </div>
</div>

<!-- MODAL LIGHTBOX LIHAT GAMBAR ASLI (POPUP) -->
<div id="modalLightbox" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(6px); z-index:10000; align-items:center; justify-content:center; padding:24px;" onclick="closeLightbox(event)">
    <div style="position:relative; max-width:90vw; max-height:90vh; display:flex; flex-direction:column; align-items:center; animation:modalFadeIn 0.2s ease-out;" onclick="event.stopPropagation()">
        <!-- CLOSE BUTTON -->
        <button type="button" onclick="closeLightbox()" style="position:absolute; top:-40px; right:0; background:rgba(255,255,255,0.2); border:none; color:#fff; font-size:20px; width:36px; height:36px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background 0.2s;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- IMAGE WRAPPER -->
        <div style="border-radius:var(--radius-lg); overflow:hidden; box-shadow:0 20px 40px rgba(0,0,0,0.5); background:#000; display:flex; align-items:center; justify-content:center;">
            <img id="lightboxImg" src="" alt="Pratinjau Foto Asli" style="max-width:85vw; max-height:80vh; object-fit:contain; display:block;">
        </div>

        <!-- TITLE / CAPTION -->
        <div id="lightboxCaption" style="margin-top:12px; color:#fff; font-size:14px; font-weight:600; text-align:center; text-shadow:0 1px 3px rgba(0,0,0,0.8);"></div>
    </div>
</div>

@push('scripts')
<script>
    function openLightbox(url, title) {
        document.getElementById('lightboxImg').src = url;
        document.getElementById('lightboxCaption').textContent = title;
        const modal = document.getElementById('modalLightbox');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const modal = document.getElementById('modalLightbox');
        modal.style.display = 'none';
        document.getElementById('lightboxImg').src = '';
        document.body.style.overflow = '';
    }

    // Keyboard ESC to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
            closeEditModal();
        }
    });

    function openEditModal(id, label, sectionLabel, currentUrl, dimensi, rasio) {
        document.getElementById('modalMediaId').value = id;
        document.getElementById('modalTitle').textContent = 'Ganti ' + label;
        document.getElementById('modalSectionBadge').textContent = 'Bagian ' + sectionLabel;
        document.getElementById('modalPreviewImg').src = currentUrl;
        document.getElementById('modalHint').textContent = 'Anjuran: ' + dimensi + ' (' + rasio + ')';
        document.getElementById('fileNameDisplay').textContent = 'Klik untuk memilih foto baru dari perangkat';
        document.getElementById('inputImageFile').value = '';
        document.getElementById('inputCustomUrl').value = '';
        
        const modal = document.getElementById('modalEditMedia');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('modalEditMedia').style.display = 'none';
        document.body.style.overflow = '';
    }

    function handleFileSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById('fileNameDisplay').textContent = 'File dipilih: ' + file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
            
            // Preview file lokal
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('modalPreviewImg').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Close on outside click
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalEditMedia');
        if (e.target === modal) {
            closeEditModal();
        }
    });
</script>
<style>
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush

@endsection
