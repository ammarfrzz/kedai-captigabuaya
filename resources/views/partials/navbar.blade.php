{{-- resources/views/partials/navbar.blade.php --}}
<header id="navbar" class="navbar" role="banner">
    <div class="container navbar__container">
        <div class="navbar__inner">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="navbar__logo" aria-label="Kedai Cap Tiga Buaya – Halaman Utama">
                <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo Kedai Cap Tiga Buaya" class="navbar__logo-img">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="navbar__nav" aria-label="Navigasi Utama">
                <a href="#beranda" class="navbar__link active" id="nav-beranda">Beranda</a>
                <a href="#tentang" class="navbar__link" id="nav-tentang">Tentang Kami</a>
                <a href="#kenapa-kami" class="navbar__link" id="nav-kenapa">Kenapa Pilih Kami</a>
                <a href="#cara-pemesanan" class="navbar__link" id="nav-pemesanan">Cara Pemesanan</a>
                <a href="#katalog" class="navbar__link" id="nav-katalog">Katalog</a>
                <a href="#galeri" class="navbar__link" id="nav-galeri">Galeri</a>
                <a href="#testimoni" class="navbar__link" id="nav-testimoni">Testimoni</a>
            </nav>

            {{-- CTA Button --}}
            <div class="navbar__action">
                <a href="#cara-pemesanan" class="navbar__cta" id="nav-pesan">Pesan Sekarang</a>
            </div>

            {{-- Hamburger Button (Mobile) --}}
            <button
                id="hamburger"
                class="navbar__hamburger"
                aria-label="Buka menu navigasi"
                aria-expanded="false"
                aria-controls="mobileDrawer"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </div>
</header>

{{-- Mobile Drawer Overlay --}}
<div id="mobileDrawer" class="navbar__drawer" role="dialog" aria-modal="true" aria-label="Menu navigasi mobile">
    <div class="navbar__drawer-panel">
        <button id="drawerClose" class="navbar__drawer-close" aria-label="Tutup menu">✕</button>

        <a href="#beranda" class="navbar__drawer-link">Beranda</a>
        <a href="#tentang" class="navbar__drawer-link">Tentang Kami</a>
        <a href="#kenapa-kami" class="navbar__drawer-link">Kenapa Pilih Kami</a>
        <a href="#cara-pemesanan" class="navbar__drawer-link">Cara Pemesanan</a>
        <a href="#katalog" class="navbar__drawer-link">Katalog</a>
        <a href="#galeri" class="navbar__drawer-link">Galeri</a>
        <a href="#testimoni" class="navbar__drawer-link">Testimoni</a>

        <a href="#cara-pemesanan" class="btn btn--primary btn--lg">Pesan Sekarang 🛒</a>
    </div>
</div>
