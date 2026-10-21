{{-- =====================================================
     MEMPHIS RED DECORATIVE BACKGROUND SHAPES
     Warna merah tegas (#B91C1C), tidak menjadi merah muda/pink.
     Ditata rapi di tepi luar dengan jarak vertikal lega
     sehingga seimbang, tidak terlalu sepi dan tidak berdempet.
     ===================================================== --}}
@php
    $variant = $variant ?? 'default';
@endphp

<div class="section-decor" aria-hidden="true">

@if ($variant === 'about')
    {{-- Sisi Kiri Atas: Organic Blob --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-slow" style="top: 16%; left: 1.5%;">
        <svg width="54" height="54" viewBox="0 0 70 70" fill="none">
            <path d="M52 14C63 24 68 41 61 53C54 65 37 68 23 64C9 60 0 47 3 34C6 21 21 8 36 6C43 5 48 9 52 14Z" fill="currentColor"/>
        </svg>
    </div>

    {{-- Sisi Kiri Bawah: Zigzag Waves --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-reverse" style="top: 72%; left: 1.5%;">
        <svg width="50" height="32" viewBox="0 0 64 42" fill="none">
            <path d="M2 8L12 2L22 8L32 2L42 8L52 2L62 8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 20L12 14L22 20L32 14L42 20L52 14L62 20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 32L12 26L22 32L32 26L42 32L52 26L62 32" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    {{-- Sisi Kanan Atas: Tilted Diamond --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-reverse" style="top: 24%; right: 1.5%;">
        <svg width="28" height="28" viewBox="0 0 34 34" fill="none">
            <rect x="17" y="2" width="20" height="20" rx="3" transform="rotate(45 17 2)" fill="currentColor"/>
        </svg>
    </div>

    {{-- Sisi Kanan Bawah: Cross "X" --}}
    <div class="decor-shape decor-shape--stroke decor-shape--spin-slow" style="top: 76%; right: 1.8%;">
        <svg width="28" height="28" viewBox="0 0 36 36" fill="none">
            <path d="M6 6L30 30M30 6L6 30" stroke="currentColor" stroke-width="3.2" stroke-linecap="round"/>
        </svg>
    </div>

@elseif ($variant === 'why-us')
    {{-- Sisi Kiri Atas: Striped Square --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 18%; left: 1.5%;">
        <svg width="44" height="44" viewBox="0 0 50 50" fill="none">
            <mask id="sq-mask-why-2" x="0" y="0" width="50" height="50">
                <rect width="50" height="50" rx="4" fill="white"/>
            </mask>
            <g mask="url(#sq-mask-why-2)">
                <line x1="-10" y1="10" x2="10" y2="-10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="-5" y1="20" x2="20" y2="-5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="0" y1="30" x2="30" y2="0" stroke="currentColor" stroke-width="2.4"/>
                <line x1="5" y1="40" x2="40" y2="5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="10" y1="50" x2="50" y2="10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="20" y1="55" x2="55" y2="20" stroke="currentColor" stroke-width="2.4"/>
                <line x1="30" y1="60" x2="60" y2="30" stroke="currentColor" stroke-width="2.4"/>
            </g>
        </svg>
    </div>

    {{-- Sisi Kiri Bawah: Solid Dot --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-reverse" style="top: 76%; left: 2%;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9" fill="currentColor"/>
        </svg>
    </div>

    {{-- Sisi Kanan Atas: Hollow Ring --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-reverse" style="top: 22%; right: 1.5%;">
        <svg width="42" height="42" viewBox="0 0 48 48" fill="none">
            <circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="4.2"/>
        </svg>
    </div>

    {{-- Sisi Kanan Bawah: Right Triangle --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-slow" style="top: 74%; right: 1.5%;">
        <svg width="30" height="30" viewBox="0 0 38 38" fill="none">
            <path d="M4 34L34 34L34 4Z" fill="currentColor"/>
        </svg>
    </div>

@elseif ($variant === 'order')
    {{-- Sisi Kiri Atas: Zigzag Waves --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 22%; left: 1.8%;">
        <svg width="50" height="32" viewBox="0 0 64 42" fill="none">
            <path d="M2 8L12 2L22 8L32 2L42 8L52 2L62 8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 20L12 14L22 20L32 14L42 20L52 14L62 20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 32L12 26L22 32L32 26L42 32L52 26L62 32" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    {{-- Sisi Kiri Bawah: Cross "X" --}}
    <div class="decor-shape decor-shape--stroke decor-shape--spin-slow" style="top: 70%; left: 2%;">
        <svg width="26" height="26" viewBox="0 0 36 36" fill="none">
            <path d="M6 6L30 30M30 6L6 30" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- Sisi Kanan Atas: Hollow Ring --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 24%; right: 1.8%;">
        <svg width="40" height="40" viewBox="0 0 48 48" fill="none">
            <circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="4"/>
        </svg>
    </div>

    {{-- Sisi Kanan Bawah: Tilted Diamond --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-reverse" style="top: 72%; right: 1.8%;">
        <svg width="26" height="26" viewBox="0 0 34 34" fill="none">
            <rect x="17" y="2" width="20" height="20" rx="3" transform="rotate(45 17 2)" fill="currentColor"/>
        </svg>
    </div>

@elseif ($variant === 'menu')
    {{-- Sisi Kiri Atas: Hollow Ring --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 18%; left: 1.5%;">
        <svg width="42" height="42" viewBox="0 0 48 48" fill="none">
            <circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="4.2"/>
        </svg>
    </div>

    {{-- Sisi Kiri Tengah: Organic Blob --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-reverse" style="top: 50%; left: 1.2%;">
        <svg width="48" height="48" viewBox="0 0 70 70" fill="none">
            <path d="M52 14C63 24 68 41 61 53C54 65 37 68 23 64C9 60 0 47 3 34C6 21 21 8 36 6C43 5 48 9 52 14Z" fill="currentColor"/>
        </svg>
    </div>

    {{-- Sisi Kiri Bawah: Striped Square --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 82%; left: 1.5%;">
        <svg width="42" height="42" viewBox="0 0 50 50" fill="none">
            <mask id="sq-mask-menu-2" x="0" y="0" width="50" height="50">
                <rect width="50" height="50" rx="4" fill="white"/>
            </mask>
            <g mask="url(#sq-mask-menu-2)">
                <line x1="-10" y1="10" x2="10" y2="-10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="-5" y1="20" x2="20" y2="-5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="0" y1="30" x2="30" y2="0" stroke="currentColor" stroke-width="2.4"/>
                <line x1="5" y1="40" x2="40" y2="5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="10" y1="50" x2="50" y2="10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="20" y1="55" x2="55" y2="20" stroke="currentColor" stroke-width="2.4"/>
            </g>
        </svg>
    </div>

    {{-- Sisi Kanan Atas: Zigzag Waves --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-reverse" style="top: 20%; right: 1.5%;">
        <svg width="50" height="32" viewBox="0 0 64 42" fill="none">
            <path d="M2 8L12 2L22 8L32 2L42 8L52 2L62 8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 20L12 14L22 20L32 14L42 20L52 14L62 20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 32L12 26L22 32L32 26L42 32L52 26L62 32" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    {{-- Sisi Kanan Tengah: Tilted Diamond --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-slow" style="top: 52%; right: 1.5%;">
        <svg width="28" height="28" viewBox="0 0 34 34" fill="none">
            <rect x="17" y="2" width="20" height="20" rx="3" transform="rotate(45 17 2)" fill="currentColor"/>
        </svg>
    </div>

    {{-- Sisi Kanan Bawah: Cross "X" --}}
    <div class="decor-shape decor-shape--stroke decor-shape--spin-slow" style="top: 82%; right: 1.8%;">
        <svg width="28" height="28" viewBox="0 0 36 36" fill="none">
            <path d="M6 6L30 30M30 6L6 30" stroke="currentColor" stroke-width="3.2" stroke-linecap="round"/>
        </svg>
    </div>

@elseif ($variant === 'gallery')
    {{-- Sisi Kiri Atas: Solid Dot --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-slow" style="top: 24%; left: 2%;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="9" fill="currentColor"/>
        </svg>
    </div>

    {{-- Sisi Kiri Bawah: Cross "X" --}}
    <div class="decor-shape decor-shape--stroke decor-shape--spin-slow" style="top: 70%; left: 1.8%;">
        <svg width="26" height="26" viewBox="0 0 36 36" fill="none">
            <path d="M6 6L30 30M30 6L6 30" stroke="currentColor" stroke-width="3.2" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- Sisi Kanan Atas: Striped Square --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-reverse" style="top: 25%; right: 1.5%;">
        <svg width="40" height="40" viewBox="0 0 50 50" fill="none">
            <mask id="sq-mask-gal-2" x="0" y="0" width="50" height="50">
                <rect width="50" height="50" rx="4" fill="white"/>
            </mask>
            <g mask="url(#sq-mask-gal-2)">
                <line x1="-10" y1="10" x2="10" y2="-10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="-5" y1="20" x2="20" y2="-5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="0" y1="30" x2="30" y2="0" stroke="currentColor" stroke-width="2.4"/>
                <line x1="5" y1="40" x2="40" y2="5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="10" y1="50" x2="50" y2="10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="20" y1="55" x2="55" y2="20" stroke="currentColor" stroke-width="2.4"/>
            </g>
        </svg>
    </div>

    {{-- Sisi Kanan Bawah: Hollow Ring --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 72%; right: 1.5%;">
        <svg width="38" height="38" viewBox="0 0 48 48" fill="none">
            <circle cx="24" cy="24" r="18" stroke="currentColor" stroke-width="4"/>
        </svg>
    </div>

@elseif ($variant === 'testimonials')
    {{-- Sisi Kiri Atas: Cross "X" --}}
    <div class="decor-shape decor-shape--stroke decor-shape--spin-slow" style="top: 20%; left: 1.8%;">
        <svg width="28" height="28" viewBox="0 0 36 36" fill="none">
            <path d="M6 6L30 30M30 6L6 30" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- Sisi Kiri Bawah: Striped Square --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-reverse" style="top: 72%; left: 1.5%;">
        <svg width="42" height="42" viewBox="0 0 50 50" fill="none">
            <mask id="sq-mask-testi-2" x="0" y="0" width="50" height="50">
                <rect width="50" height="50" rx="4" fill="white"/>
            </mask>
            <g mask="url(#sq-mask-testi-2)">
                <line x1="-10" y1="10" x2="10" y2="-10" stroke="currentColor" stroke-width="2.4"/>
                <line x1="-5" y1="20" x2="20" y2="-5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="0" y1="30" x2="30" y2="0" stroke="currentColor" stroke-width="2.4"/>
                <line x1="5" y1="40" x2="40" y2="5" stroke="currentColor" stroke-width="2.4"/>
                <line x1="10" y1="50" x2="50" y2="10" stroke="currentColor" stroke-width="2.4"/>
            </g>
        </svg>
    </div>

    {{-- Sisi Kanan Atas: Zigzag Waves --}}
    <div class="decor-shape decor-shape--stroke decor-shape--float-slow" style="top: 22%; right: 1.5%;">
        <svg width="50" height="32" viewBox="0 0 64 42" fill="none">
            <path d="M2 8L12 2L22 8L32 2L42 8L52 2L62 8" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 20L12 14L22 20L32 14L42 20L52 14L62 20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 32L12 26L22 32L32 26L42 32L52 26L62 32" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    {{-- Sisi Kanan Bawah: Organic Blob --}}
    <div class="decor-shape decor-shape--fill decor-shape--float-reverse" style="top: 70%; right: 1.5%;">
        <svg width="50" height="50" viewBox="0 0 70 70" fill="none">
            <path d="M52 14C63 24 68 41 61 53C54 65 37 68 23 64C9 60 0 47 3 34C6 21 21 8 36 6C43 5 48 9 52 14Z" fill="currentColor"/>
        </svg>
    </div>
@endif

</div>
