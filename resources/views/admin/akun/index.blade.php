@extends('admin.layouts.admin')

@section('title', 'Pengaturan Akun Admin')

@section('content')

<!-- PROFILE HERO HEADER -->
<div class="account-hero-card">
    <div class="account-hero-bg"></div>
    <div class="account-hero-content">
        <div class="account-hero-avatar-wrap">
            <img src="{{ asset('images/avatar-budi.jpg') }}" alt="Foto Profil" id="avatar-preview">
            <button type="button" class="account-avatar-btn" onclick="document.getElementById('avatar-input').click()" title="Ganti Foto">
                <i class="fa-solid fa-camera"></i>
            </button>
            <input type="file" id="avatar-input" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
        </div>

        <div class="account-hero-info">
            <h2>Budi Santoso</h2>
            <p class="account-hero-desc">Kelola preferensi akun, kredensial autentikasi, dan pantau log aktivitas sistem operasional.</p>
        </div>
    </div>

    <!-- MODERN NAVIGATION BAR -->
    <div class="account-nav-bar">
        <button type="button" class="account-nav-item active" onclick="switchTab(this, 'tab-profil')">
            <i class="fa-regular fa-id-card"></i> Informasi Profil
        </button>
        <button type="button" class="account-nav-item" onclick="switchTab(this, 'tab-keamanan')">
            <i class="fa-solid fa-lock"></i> Keamanan &amp; Sandi
        </button>
        <button type="button" class="account-nav-item" onclick="switchTab(this, 'tab-log')">
            <i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas
        </button>
    </div>
</div>

<!-- TAB CONTENTS -->
<div class="account-content-container">

    <!-- TAB 1: INFORMASI PROFIL -->
    <div id="tab-profil" class="account-tab-panel">
        <div class="account-box-card">
            <div class="account-box-header">
                <div class="box-header-icon">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div>
                    <h3>Detail Identitas Pribadi</h3>
                    <p>Informasi dasar untuk identifikasi personel admin pada sistem internal kedai.</p>
                </div>
            </div>
            <div class="account-box-body">
                <div class="form-grid-2">
                    <div class="account-form-group">
                        <label class="account-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-regular fa-user input-icon"></i>
                            <input type="text" class="account-input" value="Budi Santoso" placeholder="Masukkan nama lengkap">
                        </div>
                    </div>
                    <div class="account-form-group">
                        <label class="account-label">Username Sistem <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-at input-icon"></i>
                            <input type="text" class="account-input" value="budi.santoso-admin" placeholder="Username login">
                        </div>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="account-form-group">
                        <label class="account-label">Alamat Email Resmi <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-regular fa-envelope input-icon"></i>
                            <input type="email" class="account-input" value="budi.santoso@kedaicaptigabuaya.id" placeholder="nama@email.com">
                        </div>
                    </div>
                    <div class="account-form-group">
                        <label class="account-label">Nomor WhatsApp / Kontak <span class="text-danger">*</span></label>
                        <div class="input-with-icon">
                            <i class="fa-brands fa-whatsapp input-icon"></i>
                            <input type="text" class="account-input" value="+62 812-3456-7890" placeholder="+62 ...">
                        </div>
                    </div>
                </div>

                <div class="form-grid-2" style="margin-bottom:0;">
                    <div class="account-form-group" style="margin-bottom:0;">
                        <label class="account-label">STATUS ROLE</label>
                        <div class="input-with-icon">
                            <i class="fa-solid fa-building-user input-icon"></i>
                            <input type="text" class="account-input" value="Manajemen Pusat" placeholder="Departemen">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: KEAMANAN & SANDI -->
    <div id="tab-keamanan" class="account-tab-panel" style="display:none;">
        <div class="account-box-card">
            <div class="account-box-header">
                <div class="box-header-icon">
                    <i class="fa-solid fa-key"></i>
                </div>
                <div>
                    <h3>Perbarui Kata Sandi</h3>
                    <p>Disarankan mengganti password secara berkala dengan minimal 8 karakter kombinasi.</p>
                </div>
            </div>
            <div class="account-box-body">
                <div class="account-form-group" style="max-width:540px;">
                    <label class="account-label">Password Saat Ini <span class="text-danger">*</span></label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" class="account-input" placeholder="Masukkan password saat ini">
                    </div>
                </div>

                <div class="account-form-group" style="max-width:540px;">
                    <label class="account-label">Password Baru <span class="text-danger">*</span></label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <input type="password" class="account-input" placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <div class="account-form-group" style="max-width:540px; margin-bottom:0;">
                    <label class="account-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-check-double input-icon"></i>
                        <input type="password" class="account-input" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: LOG AKTIVITAS -->
    <div id="tab-log" class="account-tab-panel" style="display:none;">
        <div class="account-box-card">
            <div class="account-box-header">
                <div class="box-header-icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <h3>Riwayat Aktivitas Akun</h3>
                    <p>Catatan kronologis tindakan autentikasi dan operasional oleh akun ini.</p>
                </div>
            </div>
            <div class="account-box-body" style="padding-top:12px;">
                @php
                $logs = [
                    ['icon'=>'fa-right-to-bracket','color'=>'#16a34a','bg'=>'#dcfce7','action'=>'Login Berhasil ke Sistem','detail'=>'Chrome 118 – Windows 11 · IP 192.168.1.164','time'=>'24 Okt 2023, 10:45 WIB'],
                    ['icon'=>'fa-pen-to-square','color'=>'#2563eb','bg'=>'#dbeafe','action'=>'Update status pesanan ORD-20231024-089','detail'=>'Status: Menunggu Konfirmasi → Sedang Diproses','time'=>'24 Okt 2023, 13:02 WIB'],
                    ['icon'=>'fa-bowl-food','color'=>'#ea580c','bg'=>'#ffedd5','action'=>'Tambah menu baru: Es Teh Manis Heritage','detail'=>'Kategori Minuman · Harga Rp 8.000','time'=>'24 Okt 2023, 09:15 WIB'],
                    ['icon'=>'fa-right-from-bracket','color'=>'#ef4444','bg'=>'#fee2e2','action'=>'Keluar dari Sesi (Logout)','detail'=>'Sesi berakhir secara manual melalui navigasi profil','time'=>'23 Okt 2023, 18:30 WIB'],
                    ['icon'=>'fa-right-to-bracket','color'=>'#16a34a','bg'=>'#dcfce7','action'=>'Login Berhasil ke Sistem','detail'=>'Chrome 118 – Windows 11 · IP 192.168.1.164','time'=>'23 Okt 2023, 08:00 WIB'],
                ];
                @endphp

                <div class="activity-timeline">
                    @foreach($logs as $l)
                    <div class="timeline-row">
                        <div class="timeline-icon" style="background:{{ $l['bg'] }}; color:{{ $l['color'] }};">
                            <i class="fa-solid {{ $l['icon'] }}"></i>
                        </div>
                        <div class="timeline-main">
                            <div class="timeline-title">{{ $l['action'] }}</div>
                            <div class="timeline-sub">{{ $l['detail'] }}</div>
                        </div>
                        <div class="timeline-time">
                            <i class="fa-regular fa-clock"></i> {{ $l['time'] }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="text-align:center; margin-top:20px;">
                    <button class="btn btn-outline btn-sm" style="padding:8px 20px;">
                        <i class="fa-solid fa-arrows-rotate"></i> Muat Aktivitas Lainnya
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
/* ── ACCOUNT HERO ── */
.account-hero-card {
    position: relative;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: 24px;
}
.account-hero-bg {
    height: 60px;
    background: linear-gradient(180deg, var(--green-900) 0%, var(--green-800) 28px, transparent 28px);
    position: relative;
}
.account-hero-content {
    display: flex;
    align-items: center;
    gap: 22px;
    padding: 16px 28px 18px;
    position: relative;
    margin-top: -36px;
}
.account-hero-avatar-wrap {
    position: relative;
    flex-shrink: 0;
}
.account-hero-avatar-wrap img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
    display: block;
    background: #fff;
}
.account-avatar-btn {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 28px;
    height: 28px;
    background: var(--green-700);
    color: #fff;
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    transition: transform var(--transition), background var(--transition);
}
.account-avatar-btn:hover {
    background: var(--green-800);
    transform: scale(1.08);
}
.account-hero-info {
    flex: 1;
    min-width: 0;
    padding-top: 18px;
}
.account-hero-info h2 {
    font-size: 20px;
    font-weight: 800;
    color: var(--text-1);
    margin: 0 0 5px;
    letter-spacing: -0.2px;
    line-height: 1.2;
}
.account-hero-desc {
    font-size: 13px;
    color: var(--text-3);
    margin: 0;
    line-height: 1.5;
}

/* ── NAV BAR ── */
.account-nav-bar {
    display: flex;
    border-top: 1px solid var(--border);
    padding: 0 24px;
    background: #fafcfa;
    gap: 8px;
}
.account-nav-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 18px;
    border: none;
    background: transparent;
    color: var(--text-3);
    font-family: inherit;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2.5px solid transparent;
    transition: all var(--transition);
}
.account-nav-item:hover {
    color: var(--green-700);
}
.account-nav-item.active {
    color: var(--green-800);
    border-bottom-color: var(--green-700);
    background: rgba(45, 122, 64, 0.04);
}
.account-nav-item i {
    font-size: 14px;
}

/* ── BOX CARD ── */
.account-content-container {
    max-width: 100%;
}
.account-box-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}
.account-box-header {
    padding: 18px 24px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 14px;
}
.box-header-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #e8f5ec;
    color: var(--green-700);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.account-box-header h3 {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-1);
    margin: 0 0 2px;
}
.account-box-header p {
    font-size: 12.5px;
    color: var(--text-3);
    margin: 0;
}
.account-box-body {
    padding: 24px;
}

/* ── FORMS ── */
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.account-form-group {
    margin-bottom: 20px;
}
.account-label {
    display: block;
    font-size: 11.5px;
    font-weight: 700;
    color: var(--text-2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}
.account-label .text-danger {
    color: #ef4444;
}
.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
}
.input-icon {
    position: absolute;
    left: 14px;
    color: var(--green-700);
    font-size: 14px;
    pointer-events: none;
}
.account-input {
    width: 100%;
    padding: 11px 14px 11px 40px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: inherit;
    font-size: 13.5px;
    color: var(--text-1);
    background: var(--surface);
    outline: none;
    transition: all var(--transition);
}
.account-input:focus {
    border-color: var(--green-500);
    box-shadow: 0 0 0 3px rgba(45, 122, 64, 0.12);
}
.account-input.readonly {
    background: #f8faf9;
    color: var(--text-3);
    cursor: not-allowed;
    border-color: var(--border);
}

/* ── SETTING ROW TOGGLE ── */
.account-setting-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 16px;
    border-radius: var(--radius-sm);
    background: #f9fbf9;
    border: 1px solid var(--border);
    margin-bottom: 12px;
}
.setting-text .setting-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--text-1);
    margin-bottom: 3px;
}
.setting-text .setting-sub {
    font-size: 12.5px;
    color: var(--text-3);
    line-height: 1.4;
}

/* ── TIMELINE ── */
.activity-timeline {
    display: flex;
    flex-direction: column;
}
.timeline-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px 0;
    border-bottom: 1px solid var(--border);
}
.timeline-row:last-child {
    border-bottom: none;
}
.timeline-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}
.timeline-main {
    flex: 1;
    min-width: 0;
}
.timeline-title {
    font-size: 13.5px;
    font-weight: 600;
    color: var(--text-1);
    margin-bottom: 2px;
}
.timeline-sub {
    font-size: 12px;
    color: var(--text-3);
}
.timeline-time {
    font-size: 12px;
    color: var(--text-3);
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 5px;
}

@media (max-width: 768px) {
    .account-hero-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .account-hero-title-row {
        justify-content: center;
    }
    .account-meta-chips {
        justify-content: center;
    }
    .form-grid-2 {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@endsection

@section('footer_bar')
<span class="footer-bar-left" style="font-size:12.5px; color:var(--text-3);">
    <i class="fa-regular fa-clock"></i> Terakhir diperbarui oleh sistem pada 24 Okt 2023, 10:45 WIB
</span>
<button class="btn btn-outline" type="button">Batalkan Perubahan</button>
<button class="btn btn-primary" type="button"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
@endsection

@push('scripts')
<script>
function switchTab(btn, tabId) {
    document.querySelectorAll('.account-nav-item').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    ['tab-profil','tab-keamanan','tab-log'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = (id === tabId) ? 'block' : 'none';
        }
    });
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
