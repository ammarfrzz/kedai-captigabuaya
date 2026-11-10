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

    <!-- Midtrans Snap JS -->
    <script src="{{ $snapUrl ?? 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey ?? config('midtrans.client_key') }}"></script>
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

            <a href="{{ url('/') }}" class="payment-header__back-btn" id="btnHeaderHome">
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
        <div class="confirmation-container" id="confirmationContainer" style="max-width: 680px; margin: 0 auto; padding: 1.5rem 1rem 3rem;">
            
            {{-- Status Banner Atas --}}
            <div class="confirm-hero-card" style="margin-bottom: 1.5rem;">
                <div class="confirm-hero-icon" id="confirmHeroIcon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h1 class="confirm-hero-title" id="confirmHeroTitle">Pesanan Sedang Diproses</h1>
                <p class="confirm-hero-subtitle" id="confirmHeroSubtitle">
                    Pesananmu telah tercatat ke antrean dapur Kedai Cap Tiga Buaya.
                </p>

                {{-- Banner Khusus Tunai di Kasir --}}
                <div id="cashBanner" style="display: none; margin-top: 1.25rem; background: #F8FAF9; border: 1.5px dashed #CBD5E1; border-radius: 12px; padding: 1rem 1.25rem; text-align: center;">
                    <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #64748B; letter-spacing: 0.05em; margin-bottom: 2px;">KODE TRANSAKSI KASIR</span>
                    <strong id="cashTransId" style="font-size: 1.4rem; font-weight: 900; color: #234E2F; font-family: monospace; letter-spacing: 0.04em;">#CTB-XXXX</strong>
                    <p style="font-size: 0.85rem; color: #475569; margin: 0.35rem 0 0;">
                        Tunjukkan kode transaksi ini ke kasir untuk menyelesaikan pembayaran dan mengambil pesanan.
                    </p>
                </div>

                {{-- Tombol Buka Midtrans Snap Jika Ditutup / Belum Lunas --}}
                <div id="midtransActionArea" style="display: none; margin-top: 1.25rem;">
                    <button type="button" class="confirm-btn-primary" id="btnPayMidtransSnap" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 13px 20px; font-size: 14.5px; font-weight: 800; background: #234E2F; color: #ffffff; border: none; border-radius: 9999px; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 14px rgba(35, 78, 47, 0.28);">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                        <span>Buka Pembayaran Midtrans</span>
                    </button>
                    <span style="display: block; font-size: 11.5px; color: #64748B; margin-top: 6px; text-align: center;">
                        <i class="fa-solid fa-lock" style="font-size: 10px;"></i> Pembayaran aman &amp; otomatis terverifikasi
                    </span>
                </div>
            </div>

            {{-- Kartu Detail & Struk Pembayaran (Centered Single Column) --}}
            <div class="confirm-receipt-card" style="position: static; box-shadow: 0 4px 24px rgba(0,0,0,0.05); border-radius: 20px; padding: 2rem;">
                
                <div class="receipt-card-header" style="border-bottom: 1.5px dashed #E2E8F0; padding-bottom: 1.25rem;">
                    <div class="receipt-brand">
                        <img src="{{ asset('images/logo.png') }}?v={{ filemtime(public_path('images/logo.png')) }}" alt="Logo CTB" class="receipt-logo" style="width: 40px; height: 40px;">
                        <div>
                            <span class="receipt-outlet" style="font-size: 1.05rem;">Kedai Cap Tiga Buaya</span>
                            <span class="receipt-loc">Surabaya, Jawa Timur</span>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <span id="paymentStatusBadge" style="display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 800; letter-spacing: 0.04em; background: #FEF3C7; color: #B45309; text-transform: uppercase;">
                            MENUNGGU BAYAR
                        </span>
                    </div>
                </div>

                <div class="receipt-box" style="margin-top: 1.25rem;">
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
                        <span>Metode Pembayaran</span>
                        <strong id="rcptPayment">-</strong>
                    </div>
                    <div class="receipt-row" id="rcptNotesRow" style="display: none;">
                        <span>Catatan</span>
                        <strong id="rcptNotes" style="font-weight: 500; font-style: italic; color: #4B5563;">-</strong>
                    </div>

                    <div class="receipt-divider" style="margin: 1.25rem 0; border-top: 1px dashed #E2E8F0;"></div>

                    {{-- Daftar Item Pesanan --}}
                    <div class="receipt-items-list" id="rcptItems" style="display: flex; flex-direction: column; gap: 0.65rem;">
                        {{-- Diisi JS --}}
                    </div>

                    <div class="receipt-divider" style="margin: 1.25rem 0; border-top: 1px dashed #E2E8F0;"></div>

                    <div class="receipt-total-row" style="font-size: 1.15rem; font-weight: 900; color: #0F172A; display: flex; justify-content: space-between; align-items: center;">
                        <span>TOTAL TAGIHAN</span>
                        <span id="rcptTotal" style="color: #234E2F; font-size: 1.35rem;">Rp 0</span>
                    </div>
                </div>

                <div class="confirm-actions" style="margin-top: 2rem;">
                    <button type="button" class="confirm-btn-print" onclick="window.print()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        <span>Cetak / Simpan Struk</span>
                    </button>

                    <a href="{{ url('/') }}" class="confirm-btn-home" id="btnConfirmHome" style="display: none;">
                        <span>Pesan Menu Lain / Selesai</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>

                    <button type="button" class="confirm-btn-cancel-qris" id="btnCancelOrderPage" style="display: none; width: 100%; margin-top: 6px; padding: 10px; background: transparent; color: #DC2626; border: 1.5px solid #FCA5A5; border-radius: 9999px; font-family: inherit; font-weight: 700; cursor: pointer; font-size: 0.85rem; transition: all 0.2s;">
                        Batalkan Pesanan Ini
                    </button>
                </div>

            </div>

        </div>
    </main>

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

            // Cek Metode Pembayaran (Online/Midtrans vs Tunai di Kasir)
            const isOnline = order.paymentMethod && (order.paymentMethod.toLowerCase().includes('qris') || order.paymentMethod.toLowerCase().includes('online') || order.paymentMethod.toLowerCase().includes('midtrans'));
            let isOrderPaid = false;
            const btnCancelPage = document.getElementById('btnCancelOrderPage');
            const cashBanner = document.getElementById('cashBanner');
            const midtransArea = document.getElementById('midtransActionArea');
            const statusBadge = document.getElementById('paymentStatusBadge');
            const btnConfirmHome = document.getElementById('btnConfirmHome');

            if (isOnline) {
                if (btnCancelPage) btnCancelPage.style.display = 'block';
                if (cashBanner) cashBanner.style.display = 'none';
                if (midtransArea) midtransArea.style.display = 'block';
                if (btnConfirmHome) btnConfirmHome.style.display = 'none';

                confirmHeroTitle.textContent = 'Menunggu Pembayaran';
                confirmHeroSubtitle.textContent = 'Silakan selesaikan pembayaran melalui jendela Midtrans. Status pesanan akan otomatis terverifikasi.';
                confirmHeroIcon.innerHTML = `
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                `;
                confirmHeroIcon.style.background = '#FEF3C7';
                confirmHeroIcon.style.color = '#D97706';

                if (statusBadge) {
                    statusBadge.textContent = 'MENUNGGU BAYAR';
                    statusBadge.style.background = '#FEF3C7';
                    statusBadge.style.color = '#B45309';
                }

                // ── Integrasi Midtrans Snap Popup ──
                const btnPayMidtrans = document.getElementById('btnPayMidtransSnap');
                function triggerSnapPayment() {
                    const snapToken = order.snap_token;
                    if (!snapToken) {
                        fetch("{{ route('pembayaran.status') }}?order_number=" + encodeURIComponent(order.id))
                            .then(res => res.json())
                            .then(data => {
                                if (data.snap_token) {
                                    order.snap_token = data.snap_token;
                                    sessionStorage.setItem('ctb_current_order', JSON.stringify(order));
                                    triggerSnapPayment();
                                }
                            })
                            .catch(console.error);
                        return;
                    }

                    if (typeof window.snap !== 'undefined' && window.snap.pay) {
                        window.snap.pay(snapToken, {
                            onSuccess: function(result) {
                                console.log('Midtrans Payment Success:', result);
                                isOrderPaid = true;
                                checkOrderStatusImmediate();
                            },
                            onPending: function(result) {
                                console.log('Midtrans Payment Pending:', result);
                            },
                            onError: function(result) {
                                console.error('Midtrans Payment Error:', result);
                                alert('Pembayaran gagal atau dibatalkan.');
                            },
                            onClose: function() {
                                console.log('Customer closed Midtrans popup');
                            }
                        });
                    } else {
                        setTimeout(triggerSnapPayment, 500);
                    }
                }

                if (btnPayMidtrans) {
                    btnPayMidtrans.addEventListener('click', triggerSnapPayment);
                }

                // Buka popup Midtrans secara mulus
                setTimeout(() => {
                    triggerSnapPayment();
                }, 500);

                function checkOrderStatusImmediate() {
                    if (!order.id) return;
                    fetch("{{ route('pembayaran.status') }}?order_number=" + encodeURIComponent(order.id))
                        .then(res => res.json())
                        .then(resData => {
                            if (resData.payment_status === 'paid') {
                                isOrderPaid = true;
                                clearInterval(statusPollInterval);

                                confirmHeroTitle.textContent = 'Pembayaran Berhasil!';
                                confirmHeroSubtitle.textContent = 'Terima kasih, pembayaran pesanan kamu telah lunas dan sedang disiapkan dapur.';
                                confirmHeroIcon.innerHTML = `
                                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                `;
                                confirmHeroIcon.style.background = '#DCFCE7';
                                confirmHeroIcon.style.color = '#16A34A';

                                if (statusBadge) {
                                    statusBadge.textContent = 'LUNAS';
                                    statusBadge.style.background = '#DCFCE7';
                                    statusBadge.style.color = '#15803D';
                                }

                                if (midtransArea) midtransArea.style.display = 'none';
                                if (btnCancelPage) btnCancelPage.style.display = 'none';
                                if (btnConfirmHome) btnConfirmHome.style.display = 'flex';
                                localStorage.removeItem('ctb_pending_payment');
                            }
                        })
                        .catch(console.error);
                }

                const statusPollInterval = setInterval(checkOrderStatusImmediate, 3000);

            } else {
                // Tampilkan Kasir Tunai
                if (cashBanner) cashBanner.style.display = 'block';
                if (midtransArea) midtransArea.style.display = 'none';
                if (btnCancelPage) btnCancelPage.style.display = 'none';
                if (btnConfirmHome) btnConfirmHome.style.display = 'flex';

                confirmHeroTitle.textContent = 'Pesanan Berhasil Dicatat';
                confirmHeroSubtitle.textContent = 'Silakan lakukan pembayaran langsung ke meja kasir untuk mengambil struk fisik dan menyelesaikan pesanan.';

                confirmHeroIcon.innerHTML = `
                    <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                `;
                confirmHeroIcon.style.background = '#DCFCE7';
                confirmHeroIcon.style.color = '#16A34A';

                if (statusBadge) {
                    statusBadge.textContent = 'BAYAR DI KASIR';
                    statusBadge.style.background = '#E0F2FE';
                    statusBadge.style.color = '#0369A1';
                }

                const cashTransEl = document.getElementById('cashTransId');
                if (cashTransEl) cashTransEl.textContent = order.id;
            }

            // Saat customer menekan "Pesan Menu Lain / Selesai", hapus status pending payment
            const btnHome = document.querySelector('.confirm-btn-home');
            if (btnHome) {
                btnHome.addEventListener('click', () => {
                    localStorage.removeItem('ctb_pending_payment');
                    sessionStorage.removeItem('ctb_current_order');
                });
            }

            // Fungsi batalkan pesanan ke backend & redirect ke halaman utama
            const handleCancelOrder = function() {
                window.showCustomConfirm({
                    title: 'Batalkan Pesanan QRIS?',
                    message: 'Pesanan ini belum dibayar dan akan langsung dihapus dari sistem antrean dapur.',
                    type: 'warning',
                    confirmText: 'Ya, Batalkan Pesanan',
                    cancelText: 'Lanjutkan Bayar',
                    onConfirm: function() {
                        fetch("{{ route('pembayaran.cancel') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                order_number: order.id,
                                order_id: order.dbId || null
                            })
                        }).finally(() => {
                            localStorage.removeItem('ctb_pending_payment');
                            sessionStorage.removeItem('ctb_current_order');
                            window.location.href = "{{ url('/') }}";
                        });
                    }
                });
            };

            // Tombol Batalkan Pesanan QRIS di Halaman Konfirmasi
            if (btnCancelPage) {
                btnCancelPage.addEventListener('click', handleCancelOrder);
            }

            // Tombol "Halaman Utama" di Header Pojok Kanan Atas
            const btnHeaderHome = document.getElementById('btnHeaderHome');
            if (btnHeaderHome) {
                btnHeaderHome.addEventListener('click', (e) => {
                    // Hanya munculkan popup konfirmasi pembatalan jika pesanan ONLINE dan statusnya MASIH BELUM LUNAS
                    if (isOnline && !isOrderPaid) {
                        e.preventDefault();
                        handleCancelOrder();
                    } else {
                        // Jika sudah Lunas atau metode Tunai di Kasir, langsung izinkan kembali ke beranda tanpa popup
                        localStorage.removeItem('ctb_pending_payment');
                        sessionStorage.removeItem('ctb_current_order');
                    }
                });
            }
        });
    </script>

    {{-- Custom Modals & Reminder Popup --}}
    @include('partials.custom-modals')
</body>
</html>
