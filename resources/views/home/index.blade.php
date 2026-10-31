@extends('layouts.app')

@section('title', 'Kedai Cap Tiga Buaya – Kehangatan Rasa Dalam Setiap Suapan')

@section('content')

{{-- =====================================================
     HERO SECTION
     ===================================================== --}}
<section id="beranda" class="hero" aria-label="Beranda – Hero">
    <div class="hero__bg">
        <img
            src="{{ \App\Models\LandingMedia::get('hero_bg', 'images/hero-bg.jpg') }}"
            alt="Suasana Kedai Cap Tiga Buaya"
            loading="eager"
            fetchpriority="high"
        >
        <div class="hero__overlay"></div>
    </div>

    <div class="container hero__container">
        <div class="hero__content">

            <h1 class="hero__title">
                <span class="hero__title-line-1">Rasa Otentik Kopitiam</span>
                <span class="hero__title-line-2">di Sudut Surabaya</span>
            </h1>
            
            <p class="hero__description">
                Kopitiam klasik dengan cita rasa khas Melayu, Hadirkan kehangatan kopi dan teman santapan terbaik untuk harimu <br>di Surabaya.
            </p>

        </div>

    </div>
</section>

{{-- =====================================================
     ABOUT SECTION — Warisan Rasa Tiga Generasi
     ===================================================== --}}
<section id="tentang" class="about section">
    @include('partials.decor-shapes', ['variant' => 'about'])
    <div class="container">
        <div class="about__grid">

            {{-- Image Side --}}
            <div class="about__images" data-reveal data-reveal-delay="0">
                <img
                    src="{{ \App\Models\LandingMedia::get('about_main', 'images/bgabout1.jpg') }}"
                    alt="Tentang Kedai Cap Tiga Buaya"
                    class="about__img-main"
                    loading="lazy"
                >
            </div>

            {{-- Text Side --}}
            <div class="about__content" data-reveal data-reveal-delay="150">
                <span class="about__eyebrow">Tentang Kami</span>
                <h2 class="text-section-title about__title">
                    Cerita rasa dari tiga sahabat
                </h2>
                <p class="text-body-lg about__desc">
                    Berawal dari obrolan tiga sahabat yang hobi ngopi bareng di sudut Kota Pahlawan, Cap Tiga Buaya lahir sebagai ruang temu yang ramah untuk siapa saja. Angka tiga melambangkan pertemanan kami yang erat, sementara Buaya adalah simbol kebanggaan kami sebagai arek Surabaya.
                </p>
                <p class="text-body-lg about__desc">
                    Terinspirasi dari tradisi kopitiam legendaris Malaysia, kami membawa racikan kopi saring otentik, seduhan teh tarik yang pas, serta sajian pelengkap yang akrab di lidah. Cap Tiga Buaya hadir bukan cuma sebagai tempat mengisi energi, tapi juga tempat lahirnya cerita, tawa, dan ide-ide baru bersama sahabat terdekatmu.
                </p>

                <div class="about__cta">
                    <a href="#katalog" class="btn btn--outline" id="about-btn-order">Lihat Menu Kami</a>
                    <a href="#cara-pemesanan" class="btn btn--primary" id="about-btn-menu">Cara Pemesanan</a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =====================================================
     WHY US SECTION — Kenapa Pilih Kami (Bento Grid Style)
     ===================================================== --}}
<section id="kenapa-kami" class="why-us section">
    @include('partials.decor-shapes', ['variant' => 'why-us'])
    <div class="container">

        <div class="why-us__header" data-reveal>
            <h2 class="why-us__title">
                Kenapa <span class="why-us__title-accent">Pilih Cap Tiga Buaya</span>
            </h2>
        </div>

        <div class="why-bento">

            {{-- 1. Card Top-Left: Bahan Segar & Rempah --}}
            <div class="why-bento__card why-bento__card--sand" data-reveal data-reveal-delay="0">
                <div class="why-bento__icon-badge" aria-hidden="true">
                    {{-- Icon Daun Rempah Alami --}}
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                    </svg>
                </div>
                <div class="why-bento__card-body">
                    <h3 class="why-bento__card-title">Kopi Saring & Teh Tarik Otentik</h3>
                    <p class="why-bento__card-desc">
                        Diseduh memakai teknik saring tradisional dengan pilihan racikan yang pas, sehingga menghadirkan aroma khas kopitiam melayu.
                    </p>
                </div>
            </div>

            {{-- 2. Card Top-Middle: Resep Warisan & Panci Masak Tradisional --}}
            <div class="why-bento__card why-bento__card--sand" data-reveal data-reveal-delay="100">
                <div class="why-bento__icon-badge" aria-hidden="true">
                    {{-- Icon Panci Masak Tradisional Berasap --}}
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 11h16a1 1 0 0 1 1 1v4a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5v-4a1 1 0 0 1 1-1Z"/>
                        <path d="M2 13h2"/>
                        <path d="M20 13h2"/>
                        <path d="M8 8c0-1.5 1-2 1-3.5"/>
                        <path d="M12 8c0-1.5 1-2 1-3.5"/>
                        <path d="M16 8c0-1.5 1-2 1-3.5"/>
                    </svg>
                </div>
                <div class="why-bento__card-body">
                    <h3 class="why-bento__card-title">Sajian Khas & Mengenyangkan</h3>
                    <p class="why-bento__card-desc">
                        Mulai dari gurihnya Nasi Lemak Ayam CTB dan Nasi Telur Barendo, hingga sedapnya Mie Nyemek dan Ropang Srikaya manis yang siap menemani waktu santaimu.
                    </p>
                </div>
            </div>

            {{-- 3. Card Bottom-Left Wide: Kualitas Rasa & Suasana Kedai --}}
            <div class="why-bento__card why-bento__card--wide" data-reveal data-reveal-delay="150">
                <img
                    src="{{ \App\Models\LandingMedia::get('why_bento_wide', 'images/whychooseus.JPG') }}"
                    alt="Suasana santap hangat di Kedai Cap Tiga Buaya"
                    class="why-bento__bg-img"
                    loading="lazy"
                >
                <div class="why-bento__card-overlay"></div>
                <div class="why-bento__wide-content">
                    <h3 class="why-bento__wide-title">Suasana Kedai yang Santai</h3>
                    <p class="why-bento__wide-desc">
                        Ruang temu yang ramah dan terbuka di Surabaya, pas untuk ngobrol santai bareng sahabat, nugas, atau sekadar rehat sejenak menikmati hari.
                    </p>
                </div>
            </div>

            {{-- 4. Card Right Tall: Pilihan Beragam & Pelayanan --}}
            <div class="why-bento__card why-bento__card--tall" data-reveal data-reveal-delay="200">
                <div class="why-bento__tall-glow" aria-hidden="true"></div>

                <div class="why-bento__tall-section why-bento__tall-section--top">
                    <h3 class="why-bento__tall-title">Rasa Ramah di Lidah & Dompet</h3>
                    <p class="why-bento__tall-desc">
                        Menghadirkan kenikmatan kuliner kopitiam berkualitas dengan harga yang terjangkau untuk semua kalangan dan arek-arek Surabaya.
                    </p>
                </div>

                <div class="why-bento__tall-section why-bento__tall-section--bottom">
                    <h3 class="why-bento__tall-title">Pelayanan Hangat Sepenuh Hati</h3>
                    <p class="why-bento__tall-desc">
                        Berakar dari kebiasaan nongkrong bareng, kami menyambut setiap pengunjung seperti kawan lama yang datang bertamu ke rumah sendiri.
                    </p>
                </div>
            </div>

        </div>

        {{-- Running Ticker Banner seperti di contoh referensi --}}
        <div class="why-us__ticker" aria-hidden="true">
            <div class="why-us__ticker-track">
                <span>Kopi Pekat, Cerita Hangat</span>
                <span class="why-us__ticker-icon">✦</span>
                <span>Cita Rasa Kopitiam Malaysia</span>
                <span class="why-us__ticker-icon">✦</span>
                <span>Tempat Nongkrong Santai di Surabaya</span>
                <span class="why-us__ticker-icon">✦</span>
                <span>Harga Ramah di Kantong</span>
                <span class="why-us__ticker-icon">✦</span>
                <span>Kedai Kopi Cap Tiga Buaya</span>
                <span class="why-us__ticker-icon">✦</span>
            </div>
        </div>

    </div>
</section>

{{-- =====================================================
     ORDER SECTION — Cara Pemesanan di Kedai Cap Tiga Buaya
     ===================================================== --}}
<section id="cara-pemesanan" class="order section">
    @include('partials.decor-shapes', ['variant' => 'order'])
    <span id="pesan"></span>
    <div class="container">
        <div class="order__banner" data-reveal>

            {{-- Left Content --}}
            <div class="order__content">
                <h2 class="order__title">
                    Cara Pemesanan<br>
                    di Kedai Kami
                </h2>
                <p class="order__desc">
                    Nikmati sajian hangat khas Cap Tiga Buaya langsung di tempat (dine-in) maupun bungkus bawa pulang (takeaway) dengan mudah dan cepat.
                </p>
                <div class="order__platforms order__actions">
                    <a href="#katalog" class="order__platform-btn" id="order-btn-menu">
                        Lihat Menu
                    </a>
                    <a href="https://www.google.com/maps/place/Kedai+Cap+Tiga+Buaya/@-7.3214466,112.7399411,715m/data=!3m2!1e3!4b1!4m6!3m5!1s0x2dd7fb4dc4e7c851:0x6c4bf8055536605f!8m2!3d-7.3214466!4d112.7399411!16s%2Fg%2F11xs2ycj5l?entry=ttu&g_ep=EgoyMDI2MTAxNC4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener" class="order__platform-btn order__platform-btn--maps" id="order-btn-location">
                        Lokasi Kedai
                    </a>
                </div>
            </div>

            {{-- Right Steps Cards --}}
            <div class="order__steps">
                <div class="order-step">
                    <div class="order-step__number">01</div>
                    <div class="order-step__body">
                        <h3 class="order-step__title">PILIH TEMPAT & MENU</h3>
                        <p class="order-step__desc">Mampir langsung ke kedai, cari tempat duduk <br>yang paling nyaman lalu pesan dan tentukan menu andalanmu.</p>
                    </div>
                </div>

                <div class="order-step">
                    <div class="order-step__number">02</div>
                    <div class="order-step__body">
                        <h3 class="order-step__title">PESAN & BAYAR DI KASIR</h3>
                        <p class="order-step__desc">Tinggal sebut pesananmu ke kasir, terus bayar pakai Tunai, QRIS, atau Kartu Debit.</p>
                    </div>
                </div>

                <div class="order-step">
                    <div class="order-step__number">03</div>
                    <div class="order-step__body">
                        <h3 class="order-step__title">HIDANGAN DISAJIKAN</h3>
                        <p class="order-step__desc">Pesananmu langsung kami proses dan siap diantar <br> ke mejamu.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =====================================================
     MENU SECTION — Menu Istimewa Kami / Katalog
     ===================================================== --}}
<section id="katalog" class="menu-section section">
    @include('partials.decor-shapes', ['variant' => 'menu'])
    <span id="menu"></span>
    <div class="container">

        <div class="section-header" data-reveal>
            <span class="section-header__eyebrow">Pilihan Menu</span>
            <h2 class="text-section-title section-header__title">Kedai Cap Tiga Buaya</h2>
            <p class="text-body section-header__subtitle">
                Temukan racikan kopi mantap, sajian gurih kaya rasa, sampai kudapan manis yang siap nemenin waktu nongkrongmu.   
            </p>
        </div>

        {{-- Tabs --}}  
        <div class="menu-section__tabs" role="tablist" aria-label="Kategori Menu">
            <button class="menu-tab active" data-tab="semua" role="tab" aria-selected="true" id="tab-semua">Semua</button>
            <button class="menu-tab" data-tab="makanan" role="tab" aria-selected="false" id="tab-makanan">Makanan</button>
            <button class="menu-tab" data-tab="kopi"    role="tab" aria-selected="false" id="tab-kopi">Kopi</button>
            <button class="menu-tab" data-tab="minuman" role="tab" aria-selected="false" id="tab-minuman">Minuman &amp; Soda</button>
            <button class="menu-tab" data-tab="kudapan" role="tab" aria-selected="false" id="tab-kudapan">Kudapan</button>
        </div>

        {{-- Menu Grid --}}
        <div class="menu-grid" id="menuGrid">

            @foreach ($menus as $index => $item)
            <article
                class="menu-card"
                data-category="{{ $item['kategori'] }}"
                data-reveal
                data-reveal-delay="{{ ($index % 6) * 80 }}"
                aria-label="{{ $item['nama'] }}"
                @if($index >= 6) style="display: none;" @endif
            >
                <div class="menu-card__img-wrap">
                    <img
                        src="{{ $item['gambar'] }}"
                        alt="Foto {{ $item['nama'] }}"
                        loading="lazy"
                    >
                    @if(!empty($item['terlaris']))
                    <div class="menu-card__medal" aria-label="Menu Terlaris (Best Seller)" title="Menu Terlaris (Best Seller)">
                        <div class="medal-icon-wrap">
                            <svg class="medal-svg" viewBox="0 0 24 24" width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 13.5L4.5 21.5L12 18.5L19.5 21.5L17 13.5" fill="#ef4444" stroke="#b91c1c" stroke-width="1.2" stroke-linejoin="round"/>
                                <path d="M12 13.5V18.5" stroke="#991b1b" stroke-width="1"/>
                                <circle cx="12" cy="8.5" r="6.5" fill="#f59e0b" stroke="#b45309" stroke-width="1.5"/>
                                <circle cx="12" cy="8.5" r="5" fill="#fde047"/>
                                <polygon points="12,5 13.2,7.5 15.8,7.8 13.9,9.6 14.4,12.2 12,10.9 9.6,12.2 10.1,9.6 8.2,7.8 10.8,7.5" fill="#b45309"/>
                            </svg>
                        </div>
                        <span class="medal-text">Best Seller</span>
                    </div>
                    @endif
                </div>
                <div class="menu-card__body">
                    <h3 class="menu-card__name">{{ $item['nama'] }}</h3>
                    @if(!empty($item['deskripsi']))
                    <p class="menu-card__desc">{{ str_replace('.', '', $item['deskripsi']) }}</p>
                    @endif
                    <div class="menu-card__footer">
                        <div class="menu-card__price">
                            Rp{{ number_format($item['harga'], 0, ',', '.') }}
                            <span>/ porsi</span>
                        </div>
                        <div class="menu-card__actions">
                            <button
                                type="button"
                                class="menu-card__btn-cart btn-add-cart"
                                data-id="{{ $item['id'] }}"
                                data-name="{{ $item['nama'] }}"
                                data-price="{{ $item['harga'] }}"
                                data-img="{{ $item['gambar'] }}"
                                aria-label="Tambah {{ $item['nama'] }} ke keranjang"
                                title="Tambah ke Keranjang"
                            >
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="8" cy="21" r="1"></circle>
                                    <circle cx="19" cy="21" r="1"></circle>
                                    <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                                    <line x1="12" y1="6" x2="12" y2="10"></line>
                                    <line x1="10" y1="8" x2="14" y2="8"></line>
                                </svg>
                            </button>

                            <button
                                type="button"
                                class="menu-card__order-btn btn-buy-now"
                                data-id="{{ $item['id'] }}"
                                data-name="{{ $item['nama'] }}"
                                data-price="{{ $item['harga'] }}"
                                data-img="{{ $item['gambar'] }}"
                                data-payment-url="{{ route('pembayaran') }}"
                                aria-label="Pesan {{ $item['nama'] }} sekarang"
                                title="Pesan Sekarang & Bayar"
                            >
                                Pesan
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach

        </div>

        {{-- View All Toggle --}}
        <div class="menu-section__more" data-reveal>
            <button type="button" class="btn btn--outline btn--lg" id="btn-lihat-semua-menu" aria-expanded="false">
                <span>Lihat Menu Lainnya (+{{ max(0, count($menus) - 6) }}) ↓</span>
            </button>
        </div>

    </div>
</section>

{{-- =====================================================
     GALLERY SECTION — Suasana & Sajian
     ===================================================== --}}
<section id="galeri" class="gallery section section--bg">
    @include('partials.decor-shapes', ['variant' => 'gallery'])
    <div class="container">

        <div class="section-header" data-reveal>
            <span class="section-header__eyebrow">Galeri</span>
            <h2 class="text-section-title section-header__title">Suasana &amp; Sajian</h2>
            <p class="text-body section-header__subtitle">
                Sekilas pandang suasana kedai kami yang hangat dan hidangan yang menggugah selera.
            </p>
        </div>

        <div class="gallery__grid">

            @foreach ($galeri as $index => $item)
            <figure
                class="gallery__item"
                data-reveal
                data-reveal-delay="{{ $index * 120 }}"
            >
                <img
                    src="{{ $item['gambar'] }}"
                    alt="{{ $item['judul'] }}"
                    loading="lazy"
                >
                <div class="gallery__item-overlay">
                    <figcaption class="gallery__item-caption">{{ $item['judul'] }}</figcaption>
                </div>
            </figure>
            @endforeach

            {{-- Extra gallery items --}}
            <figure class="gallery__item" data-reveal data-reveal-delay="360">
                <img
                    src="{{ \App\Models\LandingMedia::get('gallery_4', 'images/Gallery4.jpg') }}"
                    alt="Minuman Segar Dingin"
                    loading="lazy"
                >
                <div class="gallery__item-overlay">
                    <figcaption class="gallery__item-caption">Minuman Segar</figcaption>
                </div>
            </figure>
            <figure class="gallery__item" data-reveal data-reveal-delay="480">
                <img
                    src="{{ \App\Models\LandingMedia::get('gallery_5', 'images/Gallery5.png') }}"
                    alt="Momen Nongkrong Hangat"
                    loading="lazy"
                >
                <div class="gallery__item-overlay">
                    <figcaption class="gallery__item-caption">Momen Hangat</figcaption>
                </div>
            </figure>

        </div>

    </div>
</section>

{{-- =====================================================
     TESTIMONIALS SECTION — Apa Kata Mereka?
     ===================================================== --}}
<section id="testimoni" class="testimonials section">
    @include('partials.decor-shapes', ['variant' => 'testimonials'])
    <div class="container">

        {{-- Section Header --}}
        <div class="testimonials__header" data-reveal>
            <h2 class="testimonials__title">Cerita Dari Sahabat</h2>
            <p class="testimonials__subtitle">Kesan hangat dari pelanggan yang sudah mampir ke Cap Tiga Buaya.</p>
        </div>

        {{-- Main Two-Column Layout --}}
        <div class="testimonials__wrapper" data-reveal data-reveal-delay="100">

            {{-- Left Column: Interactive Testimonial Carousel Card --}}
            <div class="testi-card-wrapper">
                <div class="testi-card-backdrop" aria-hidden="true"></div>
                <div class="testi-card-box">
                    {{-- Red Quote Badge --}}
                    <div class="testi-quote-badge" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                    </div>

                    {{-- Slides --}}
                    <div class="testi-slides" id="testiSlides">
                        @foreach ($testimoni as $index => $item)
                        <div class="testi-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                            <div class="testi-stars" aria-label="Rating 5 bintang">★★★★★</div>
                            <p class="testi-quote">“{{ $item['pesan'] }}”</p>
                            <div class="testi-divider"></div>
                            <div class="testi-author">
                                <img
                                    src="{{ $item['avatar'] }}"
                                    alt="Foto {{ $item['nama'] }}"
                                    class="testi-avatar"
                                    loading="lazy"
                                >
                                <div class="testi-author-info">
                                    <div class="testi-author-name">{{ strtoupper($item['nama']) }}</div>
                                    @if(!empty($item['role']))
                                    <div class="testi-author-role">{{ $item['role'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column: Content & CTA --}}
            <div class="testi-info-col">
                <p class="testi-cta-desc">
                    Kami percaya obrolan terbaik selalu lahir di meja kedai <br> yang hangat dan sederhana. Dari kawan yang datang buat nugas, melepas lelah sepulang kerja, sampai yang <br>sekedar kumpul bareng circle terdekat, pintu kami selalu terbuka buat kamu. <br><br>Pengalaman, cerita, sampai kritik &amp; saranmu akan <br>selalu jadi alasan kami untuk terus menyajikan yang <br>terbaik setiap harinya.
                </p>

                {{-- Review Button --}}
                <a href="https://www.google.com/maps/place/Kedai+Cap+Tiga+Buaya/@-7.3214466,112.7399411,715m/data=!3m2!1e3!4b1!4m6!3m5!1s0x2dd7fb4dc4e7c851:0x6c4bf8055536605f!8m2!3d-7.3214466!4d112.7399411!16s%2Fg%2F11xs2ycj5l?entry=ttu&g_ep=EgoyMDI2MTAxNC4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener" class="testi-review-btn" id="testi-btn-review">
                    <svg class="testi-heart-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#BE1E2D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <span>Beri Ulasan Kami</span>
                </a>
            </div>

        </div>

    </div>
</section>

{{-- =====================================================
     CTA BANNER — Kunjungi Kami & Rasakan Keajaibannya
     ===================================================== --}}
<section class="cta-section" aria-label="Ajakan kunjungi kedai">
    <div class="container">
        <div class="cta-banner" data-reveal>
            <div class="cta-banner__bg">
                <img
                    src="{{ \App\Models\LandingMedia::get('cta_bg', 'images/bgfooter.jpeg') }}"
                    alt="Suasana Kedai Cap Tiga Buaya"
                    loading="lazy"
                >
            </div>
            <div class="cta-banner__overlay"></div>

            <div class="cta-banner__content">
                <h2 class="cta-banner__title">
                    Kunjungi Kami &amp; Rasakan<br>
                    Sendiri Kehangatanya
                </h2>
                <p class="cta-banner__desc">
                    Jl. Jemursari IX No.9, Jemur Wonosari, Kec. Wonocolo, Surabaya, Jawa Timur 60237 Buka setiap hari buat nemenin sarapan santai, rehat siang, sampai obrolan malammu bareng kawan terdekat.
                </p>
                <div class="cta-banner__actions">
                    <a href="https://www.google.com/maps/place/Kedai+Cap+Tiga+Buaya/@-7.3214466,112.7399411,715m/data=!3m1!1e3!4m14!1m7!3m6!1s0x2dd7fb4dc4e7c851:0x6c4bf8055536605f!2sKedai+Cap+Tiga+Buaya!8m2!3d-7.3214466!4d112.7399411!16s%2Fg%2F11xs2ycj5l!3m5!1s0x2dd7fb4dc4e7c851:0x6c4bf8055536605f!8m2!3d-7.3214466!4d112.7399411!16s%2Fg%2F11xs2ycj5l?entry=ttu&g_ep=EgoyMDI2MTAxNC4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener" class="btn-cta-primary" id="cta-btn-maps">
                        <span>Petunjuk Arah</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/6287766102500" target="_blank" rel="noopener" class="btn-cta-outline" id="cta-btn-contact">
                        <span>Hubungi Kami</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ── Best Seller Medal Badge (Pojok Kanan Atas) ────────── */
.menu-card__medal {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 6;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 20%, #f59e0b 70%, #d97706 100%);
    color: #451a03;
    padding: 4px 11px 4px 6px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    box-shadow: 0 4px 14px rgba(180, 83, 9, 0.38), 0 2px 4px rgba(0, 0, 0, 0.15), inset 0 1px 1.5px rgba(255, 255, 255, 0.9);
    border: 1.5px solid #fde68a;
    backdrop-filter: blur(4px);
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease;
    user-select: none;
    pointer-events: none;
}

.menu-card:hover .menu-card__medal {
    transform: scale(1.06) rotate(-1deg);
    box-shadow: 0 6px 18px rgba(180, 83, 9, 0.48), 0 2px 6px rgba(0, 0, 0, 0.2);
}

.menu-card__medal .medal-icon-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    background: #ffffff;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2), inset 0 1px 1px rgba(255, 255, 255, 0.8);
    flex-shrink: 0;
}

.menu-card__medal .medal-svg {
    display: block;
    width: 16px;
    height: 16px;
}

.menu-card__medal .medal-text {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #451a03;
    font-weight: 800;
    line-height: 1;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.7);
}
</style>
@endpush

@push('scripts')
<script>
    // Testimonial Auto-Rotation (every 4 seconds)
    const testiSlides = document.querySelectorAll('.testi-slide');
    const testiBox = document.querySelector('.testi-card-box');
    if (testiSlides.length > 1) {
        let currentTestiIdx = 0;
        let testiInterval = null;

        const showNextTesti = () => {
            testiSlides[currentTestiIdx].classList.remove('active');
            currentTestiIdx = (currentTestiIdx + 1) % testiSlides.length;
            testiSlides[currentTestiIdx].classList.add('active');
        };

        const startTestiTimer = () => {
            stopTestiTimer();
            testiInterval = setInterval(showNextTesti, 4000);
        };

        const stopTestiTimer = () => {
            if (testiInterval) {
                clearInterval(testiInterval);
                testiInterval = null;
            }
        };

        startTestiTimer();

        if (testiBox) {
            testiBox.addEventListener('mouseenter', stopTestiTimer);
            testiBox.addEventListener('mouseleave', startTestiTimer);
        }
    }
</script>
@endpush
