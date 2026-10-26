<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kedai Cap Tigabuaya – Warisan rasa tiga generasi dengan cita rasa autentik Indonesia. Nikmati nasi uduk, rendang, dan berbagai hidangan lezat kami.">
    <meta name="keywords" content="kedai makan, nasi uduk, rendang, masakan Indonesia, warung makan, pesan makanan">
    <meta name="author" content="Kedai Cap Tigabuaya">

    <!-- Open Graph -->
    <meta property="og:title" content="Kedai Cap Tigabuaya – Kehangatan Rasa Dalam Setiap Suapan">
    <meta property="og:description" content="Warisan rasa tiga generasi dengan cita rasa autentik Indonesia.">
    <meta property="og:type" content="website">

    <title>@yield('title', 'Kedai Cap Tigabuaya – Kehangatan Rasa Dalam Setiap Suapan')</title>

    <!-- Typography: Plus Jakarta Sans (Clean Modern Sans) & Playfair Display (Luxury Editorial Serif matching reference) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite([
        'resources/css/app.css',
        'resources/css/components/navbar.css',
        'resources/css/components/hero.css',
        'resources/css/components/sections.css',
        'resources/css/components/footer.css',
        'resources/css/components/cart.css',
        'resources/js/app.js',
    ])

    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Floating Cart & Popup Drawer --}}
    @include('partials.cart-drawer')

    @stack('scripts')
</body>
</html>
