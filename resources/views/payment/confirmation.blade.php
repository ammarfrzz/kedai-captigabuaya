<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Pembayaran &amp; Pesanan – Kedai Cap Tiga Buaya</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Typography: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite([
        'resources/css/app.css',
        'resources/css/components/payment.css',
    ])
</head>
<body class="payment-page confirmation-page">

    {{-- Top Header --}}
    <header class="payment-header">
        <div class="payment-header__container">
            <div class="payment-header__brand">
                <img
                    src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}"
                    alt="Logo Kedai Cap Tiga Buaya"
                    class="payment-header__logo"
                >
                <span class="payment-header__title">Kedai Cap Tiga Buaya</span>
            </div>

            <a href="{{ url('/') }}" class="payment-header__back-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Halaman Utama</span>
            </a>
        </div>
    </header>

    {{-- Main Confirmation Content --}}
    <main class="payment-main confirmation-main">
        <div class="confirmation-container" id="confirmationContainer">
            
            {{-- Status Banner Atas --}}
            <div class="confirm-hero-card">
                <div class="confirm-hero-icon" id="confirmHeroIcon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h1 class="confirm-hero-title" id="confirmHeroTitle">Pesanan Sedang Diproses</h1>
                <p class="confirm-hero-subtitle" id="confirmHeroSubtitle">
                    Pesananmu telah tercatat ke antrean dapur Kedai Cap Tiga Buaya.
                </p>
            </div>

            {{-- Grid Dua Kolom: Instruksi Pembayaran (Kiri) & Ringkasan Struk (Kanan) --}}
            <div class="confirmation-grid">

                {{-- Kolom Kiri: Instruksi Berdasarkan Metode Bayar --}}
                <div class="confirm-instructions-col">

                    {{-- 1. Blok Khusus QRIS Dinamis --}}
                    <div class="confirm-card confirm-card--qris" id="qrisSection" style="display: none;">
                        <div class="confirm-card__header">
                            <div class="confirm-card__header-left">
                                <span class="qris-tag-badge">QRIS</span>
                                <div>
                                    <h2 class="confirm-card__title">Pindai QRIS</h2>
                                    <span class="confirm-card__sub">Nominal tagihan otomatis</span>
                                </div>
                            </div>
                        </div>

                        {{-- Box Merchant & Nominal --}}
                        <div class="qris-merchant-box">
                            <span class="qris-merchant-name">KEDAI CAP TIGA BUAYA</span>
                            <span class="qris-nmid">NMID: ID1024391823901 • A01</span>
                            <div class="qris-amount-badge">
                                <span class="qris-amount-label">Nominal</span>
                                <strong class="qris-amount-value" id="qrisConfirmAmount">Rp 0</strong>
                            </div>
                        </div>

                        {{-- QR Code Display --}}
                        <div class="qris-code-wrapper">
                            <div class="qris-code-frame">
                                <img
                                    id="qrisConfirmImg"
                                    src=""
                                    alt="QRIS Dinamis Cap Tiga Buaya"
                                    class="qris-qr-image"
                                >
                                <div class="qris-qr-center-logo">
                                    <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="CTB">
                                </div>
                            </div>
                        </div>

                        {{-- Timer Countdown --}}
                        <div class="qris-meta-bar">
                            <div class="qris-timer-box">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span>Sisa Waktu :<strong id="qrisConfirmTimer">05:00</strong></span>
                            </div>
                            <button type="button" class="qris-refresh-btn" id="btnRefreshConfirmQris">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <polyline points="1 20 1 14 7 14"></polyline>
                                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                </svg>
                                <span>Segarkan QR</span>
                            </button>
                        </div>

                        {{-- Panduan Bayar QRIS --}}
                        <div class="qris-guide-box">
                            <h3 class="qris-guide-heading">Langkah Pembayaran:</h3>
                            <div class="qris-step-item">
                                <span class="qris-step-num">1</span>
                                <span>Buka aplikasi m-Banking (BCA, Mandiri, BRI, BNI) atau e-Wallet (GoPay, DANA, OVO, ShopeePay)</span>
                            </div>
                            <div class="qris-step-item">
                                <span class="qris-step-num">2</span>
                                <span>Pilih menu <strong>Scan / QRIS</strong> lalu scan kode QR di atas</span>
                            </div>
                            <div class="qris-step-item">
                                <span class="qris-step-num">3</span>
                                <span>Periksa nama merchant <strong>KEDAI CAP TIGA BUAYA</strong> dan nominal pembayaran</span>
                            </div>
                            <div class="qris-step-item">
                                <span class="qris-step-num">4</span>
                                <span>Setelah sukses, sistem kasir kami akan menerima verifikasi secara langsung</span>
                            </div>
                        </div>

                        <div class="qris-wallet-chips">
                            <span class="wallet-chip">BCA</span>
                            <span class="wallet-chip">Mandiri</span>
                            <span class="wallet-chip">BRImo</span>
                            <span class="wallet-chip">GoPay</span>
                            <span class="wallet-chip">DANA</span>
                            <span class="wallet-chip">ShopeePay</span>
                            <span class="wallet-chip">OVO</span>
                        </div>
                    </div>

                    {{-- 2. Blok Khusus Tunai di Kasir --}}
                    <div class="confirm-card confirm-card--cash" id="cashSection" style="display: none;">
                        <div class="confirm-card__header">
                            <div class="confirm-card__header-left">
                                <div class="cash-icon-badge">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                        <circle cx="12" cy="12" r="2"></circle>
                                        <path d="M6 12h.01M18 12h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="confirm-card__title">Pembayaran Tunai / Debit di Kasir</h2>
                                    <span class="confirm-card__sub">Silakan selesaikan transaksi di meja kasir</span>
                                </div>
                            </div>
                        </div>

                        <div class="cash-alert-box">
                            <div class="cash-queue-badge">
                                <span class="cash-queue-label">KODE TRANSAKSI ANDA</span>
                                <strong class="cash-queue-id" id="cashTransId">#CTB-XXXX</strong>
                            </div>
                            <p class="cash-alert-text">
                                Sebutkan <strong>Kode Transaksi</strong> atau <strong>Nama Pelanggan</strong> ke kasir kami untuk memproses struk fisik dan pembayaran.
                            </p>
                        </div>

                        {{-- Panduan Kasir --}}
                        <div class="qris-guide-box">
                            <h3 class="qris-guide-heading">Petunjuk Pembayaran Kasir:</h3>
                            <div class="qris-step-item">
                                <span class="qris-step-num">1</span>
                                <span>Kunjungi meja kasir Kedai Cap Tiga Buaya</span>
                            </div>
                            <div class="qris-step-item">
                                <span class="qris-step-num">2</span>
                                <span>Tunjukkan kode transaksi atau sebutkan nama pelanggan <strong id="cashGuideCustName">-</strong></span>
                            </div>
                            <div class="qris-step-item">
                                <span class="qris-step-num">3</span>
                                <span>Bayar dengan uang tunai (disarankan uang pas) atau kartu debit (BCA, Mandiri, BRI, dll)</span>
                            </div>
                            <div class="qris-step-item">
                                <span class="qris-step-num">4</span>
                                <span>Simpan struk kasir yang diberikan dan pesanan akan diantar ke mejamu</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tips / Catatan Pelayanan --}}
                    <div class="confirm-info-banner">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#234E2F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <p>
                            Butuh bantuan dengan pesananmu? Jangan ragu untuk langsung bertanya pada staf kami di outlet
                        </p>
                    </div>

                </div>

                {{-- Kolom Kanan: Rincian Struk Digital & Aksi --}}
                <div class="confirm-receipt-col">
                    <div class="confirm-receipt-card">
                        
                        <div class="receipt-card-header">
                            <div class="receipt-brand">
                                <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo CTB" class="receipt-logo">
                                <div>
                                    <span class="receipt-outlet">Kedai Cap Tiga Buaya</span>
                                    <span class="receipt-loc">Surabaya, Jawa Timur</span>
                                </div>
                            </div>
                        </div>

                        <div class="receipt-box">
                            <div class="receipt-row">
                                <span>No. Transaksi</span>
                                <strong id="rcptId">-</strong>
                            </div>
                            <div class="receipt-row">
                                <span>Waktu Pemesanan</span>
                                <strong id="rcptDate">-</strong>
                            </div>
                            <div class="receipt-row">
                                <span>Nama Pelanggan</span>
                                <strong id="rcptName">-</strong>
                            </div>
                            <div class="receipt-row">
                                <span>Tipe Pesanan</span>
                                <strong id="rcptType">-</strong>
                            </div>
                            <div class="receipt-row">
                                <span>Metode Bayar</span>
                                <strong id="rcptPayment">-</strong>
                            </div>
                            <div class="receipt-row" id="rcptNotesRow" style="display: none;">
                                <span>Catatan</span>
                                <strong id="rcptNotes" style="font-weight: 500; font-style: italic; color: #4B5563;">-</strong>
                            </div>

                            <div class="receipt-divider"></div>

                            {{-- Daftar Item Pesanan --}}
                            <div class="receipt-items-list" id="rcptItems">
                                {{-- Diisi JS --}}
                            </div>

                            <div class="receipt-divider"></div>

                            <div class="receipt-total-row">
                                <span>TOTAL BAYAR</span>
                                <span id="rcptTotal">Rp 0</span>
                            </div>
                        </div>

                        <div class="confirm-actions">
                            <button type="button" class="confirm-btn-print" onclick="window.print()">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                                <span>Cetak / Simpan Struk</span>
                            </button>

                            <a href="{{ url('/') }}" class="confirm-btn-home">
                                <span>Pesan Menu Lain / Selesai</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Interactive Confirmation Logic JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formatRupiah = (num) => 'Rp ' + Number(num).toLocaleString('id-ID');

            // Ambil order data dari sessionStorage
            let order = null;
            try {
                const stored = sessionStorage.getItem('ctb_current_order');
                if (stored) {
                    order = JSON.parse(stored);
                }
            } catch (e) {
                order = null;
            }

            // Jika tidak ada data pesanan (misal direct url access tanpa pesan dulu)
            if (!order || !order.items || Object.keys(order.items).length === 0) {
                document.getElementById('confirmationContainer').innerHTML = `
                    <div style="background: #FFFFFF; border-radius: 16px; padding: 3rem 2rem; text-align: center; max-width: 520px; margin: 3rem auto; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #E5E7EB;">
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem;">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <h2 style="font-size: 1.35rem; font-weight: 800; color: #111827; margin-bottom: 0.5rem;">Tidak Ada Pesanan Aktif</h2>
                        <p style="color: #6B7280; font-size: 0.925rem; margin-bottom: 1.75rem;">Anda belum melakukan checkout pesanan. Silakan pilih menu nikmat kami terlebih dahulu.</p>
                        <a href="{{ url('/#katalog') }}" class="payment-header__back-btn" style="display: inline-flex; justify-content: center; background: #234E2F; color: #FFFFFF; padding: 0.85rem 1.75rem; border-radius: 9999px; text-decoration: none; font-weight: 700;">
                            Lihat Menu Sekarang
                        </a>
                    </div>
                `;
                return;
            }

            // Elemen Struk
            const rcptId = document.getElementById('rcptId');
            const rcptDate = document.getElementById('rcptDate');
            const rcptName = document.getElementById('rcptName');
            const rcptType = document.getElementById('rcptType');
            const rcptPayment = document.getElementById('rcptPayment');
            const rcptNotesRow = document.getElementById('rcptNotesRow');
            const rcptNotes = document.getElementById('rcptNotes');
            const rcptItems = document.getElementById('rcptItems');
            const rcptTotal = document.getElementById('rcptTotal');

            // Hero elements
            const confirmHeroIcon = document.getElementById('confirmHeroIcon');
            const confirmHeroTitle = document.getElementById('confirmHeroTitle');
            const confirmHeroSubtitle = document.getElementById('confirmHeroSubtitle');

            // Section Boxes
            const qrisSection = document.getElementById('qrisSection');
            const cashSection = document.getElementById('cashSection');

            // Isi Data Struk
            rcptId.textContent = order.id;
            rcptDate.textContent = order.date;
            rcptName.textContent = order.customerName;
            rcptType.textContent = order.orderTypeText;
            rcptPayment.textContent = order.paymentMethod;

            if (order.notes) {
                rcptNotesRow.style.display = 'flex';
                rcptNotes.textContent = order.notes;
            }

            // Render Items di Struk
            let itemsHtml = '';
            let total = 0;
            Object.keys(order.items).forEach(k => {
                const item = order.items[k];
                const itemTotal = item.price * item.qty;
                total += itemTotal;
                itemsHtml += `
                    <div class="receipt-item-row">
                        <span>${item.name} &times; ${item.qty}</span>
                        <strong>${formatRupiah(itemTotal)}</strong>
                    </div>
                `;
            });

            rcptItems.innerHTML = itemsHtml;
            rcptTotal.textContent = formatRupiah(total);

            // Cek Metode Pembayaran (QRIS Dinamis vs Tunai di Kasir)
            const isQRIS = order.paymentMethod && order.paymentMethod.toLowerCase().includes('qris');

            if (isQRIS) {
                // Tampilkan Card QRIS Dinamis
                qrisSection.style.display = 'block';
                cashSection.style.display = 'none';

                confirmHeroTitle.textContent = 'Pembayaran QRIS';
                confirmHeroSubtitle.textContent = 'Pindai kode QRIS di bawah ini menggunakan aplikasi e-Wallet atau Mobile Banking kamu.';
                confirmHeroIcon.innerHTML = `
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                `;
                confirmHeroIcon.style.background = '#DCFCE7';
                confirmHeroIcon.style.color = '#16A34A';

                // Setup Dynamic QRIS Code
                const qrisConfirmAmount = document.getElementById('qrisConfirmAmount');
                const qrisConfirmImg = document.getElementById('qrisConfirmImg');
                const qrisConfirmTimer = document.getElementById('qrisConfirmTimer');
                const btnRefreshConfirmQris = document.getElementById('btnRefreshConfirmQris');

                qrisConfirmAmount.textContent = formatRupiah(total);

                function generateDynamicQrisPayload(amount) {
                    const merchantName = "KEDAI CAP TIGA BUAYA";
                    const city = "SURABAYA";
                    const nmid = "ID1024391823901";
                    const formattedAmt = String(amount);
                    return `00020101021226500016ID.CO.QRIS.WWW01189360099900000000000215${nmid}52045812530336054${String(formattedAmt.length).padStart(2, '0')}${formattedAmt}5802ID59${String(merchantName.length).padStart(2, '0')}${merchantName}60${String(city.length).padStart(2, '0')}${city}6304`;
                }

                function loadQrImage() {
                    const payload = generateDynamicQrisPayload(total);
                    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=10&data=${encodeURIComponent(payload)}`;
                    qrisConfirmImg.src = qrUrl;
                    qrisConfirmImg.style.opacity = '1';
                    qrisConfirmImg.style.filter = 'none';
                }

                loadQrImage();

                // Countdown Timer 5 menit
                let timeRemaining = 300;
                let timerInterval = null;

                function updateCountdown() {
                    const m = Math.floor(timeRemaining / 60);
                    const s = timeRemaining % 60;
                    qrisConfirmTimer.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                    qrisConfirmTimer.style.color = timeRemaining < 60 ? '#BE1E2D' : '#15803D';
                }

                function startTimer() {
                    clearInterval(timerInterval);
                    timeRemaining = 300;
                    updateCountdown();

                    timerInterval = setInterval(() => {
                        timeRemaining--;
                        if (timeRemaining <= 0) {
                            clearInterval(timerInterval);
                            qrisConfirmTimer.textContent = 'Kedaluwarsa (Silakan Segarkan)';
                            qrisConfirmTimer.style.color = '#BE1E2D';
                            qrisConfirmImg.style.opacity = '0.35';
                            qrisConfirmImg.style.filter = 'grayscale(100%)';
                        } else {
                            updateCountdown();
                        }
                    }, 1000);
                }

                startTimer();

                btnRefreshConfirmQris.addEventListener('click', () => {
                    loadQrImage();
                    startTimer();
                });

            } else {
                // Tampilkan Card Kasir Tunai / Debit
                qrisSection.style.display = 'none';
                cashSection.style.display = 'block';

                confirmHeroTitle.textContent = 'Pesanan Berhasil Dicatat';
                confirmHeroSubtitle.textContent = 'Silakan lakukan pembayaran langsung ke meja kasir untuk mengambil struk fisik dan menyelesaikan pesanan.';
                
                // Ubah logo ceklis menjadi hijau (#DCFCE7 background, #16A34A icon)
                confirmHeroIcon.innerHTML = `
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                `;
                confirmHeroIcon.style.background = '#DCFCE7';
                confirmHeroIcon.style.color = '#16A34A';

                document.getElementById('cashTransId').textContent = order.id;
                document.getElementById('cashGuideCustName').textContent = order.customerName;
            }
        });
    </script>
</body>
</html>
