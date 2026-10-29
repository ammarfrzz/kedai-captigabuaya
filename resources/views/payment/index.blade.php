<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran &amp; Checkout – Kedai Cap Tiga Buaya</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Typography: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite([
        'resources/css/app.css',
        'resources/css/components/payment.css',
    ])
</head>
<body class="payment-page">

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

            <a href="{{ url('/#katalog') }}" class="payment-header__back-btn" id="paymentBackBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Kembali Pilih Menu</span>
            </a>
        </div>
    </header>

    {{-- Main Checkout Content --}}
    <main class="payment-main">
        <div class="payment-grid">

            {{-- ── LEFT COLUMN: Form Data & Metode Pembayaran ── --}}
            <div class="payment-left-col">

                {{-- 1. Data Pemesan --}}
                <div class="payment-card">
                    <div class="payment-card__header">
                        <div class="payment-card__icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <h2 class="payment-card__title">1. Data Pemesan</h2>
                    </div>

                    <div class="payment-form-group">
                        <label for="custName" class="payment-label">Nama Pelanggan <span style="color: #BE1E2D;">*</span></label>
                        <input
                            type="text"
                            id="custName"
                            class="payment-input"
                            placeholder="Contoh: Dinda Kirana"
                            required
                        >
                    </div>

                    <div class="payment-form-group" id="tableGroup">
                        <label for="custTable" class="payment-label">Nomor Meja <span style="color: #BE1E2D;">*</span></label>
                        <input
                            type="text"
                            id="custTable"
                            class="payment-input"
                            placeholder="Contoh: 08 (atau lihat stiker meja)"
                            required
                        >
                    </div>

                    <div class="payment-form-group">
                        <label for="custNotes" class="payment-label">Catatan Pesanan (Opsional)</label>
                        <textarea
                            id="custNotes"
                            class="payment-textarea"
                            rows="2"
                            placeholder="Misal: Kopi tubruk gulanya sedikit saja, buat makanan sambalnya dipisah..."
                            style="resize: none;"
                        ></textarea>
                    </div>

                    <div class="payment-form-group">
                        <span class="payment-label">Tipe Pesanan <span style="color: #BE1E2D;">*</span></span>
                        <div class="payment-type-toggle" role="radiogroup" aria-label="Tipe Pesanan">
                            <button type="button" class="payment-type-btn active" data-type="dine-in" role="radio" aria-checked="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 2v20M14 2v4a2 2 0 0 0 2 2h4M6 2v7a3 3 0 0 0 3 3v10M6 2h6M6 6h6"></path>
                                </svg>
                                <span>Makan Sini (Dine-in)</span>
                            </button>
                            <button type="button" class="payment-type-btn" data-type="take-away" role="radio" aria-checked="false">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                <span>Bungkus (Takeaway)</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 2. Pilihan Metode Pembayaran --}}
                <div class="payment-card">
                    <div class="payment-card__header">
                        <div class="payment-card__icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </div>
                        <h2 class="payment-card__title">2. Metode Pembayaran</h2>
                    </div>

                    <div class="payment-methods" id="paymentMethodsGroup">

                        {{-- Metode 1: QRIS Dinamis --}}
                        <label class="payment-method-item" for="payQRIS">
                            <div class="payment-method-header">
                                <div class="payment-method-left">
                                    <input type="radio" name="paymentMethod" id="payQRIS" value="QRIS Dinamis" class="payment-radio">
                                    <div class="payment-method-text-wrap">
                                        <span class="payment-method-name">QRIS</span>
                                        <span class="payment-method-subtext">BCA, Mandiri, BRI, GoPay, DANA, OVO, ShopeePay</span>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-method-desc">
                                Kode QR &amp; instruksi pembayaran akan langsung ditampilkan di halaman konfirmasi setelah klik tombol bayar
                            </div>
                        </label>

                        {{-- Metode 2: Tunai / Kasir --}}
                        <label class="payment-method-item" for="payCash">
                            <div class="payment-method-header">
                                <div class="payment-method-left">
                                    <input type="radio" name="paymentMethod" id="payCash" value="Tunai di Kasir" class="payment-radio">
                                    <div class="payment-method-text-wrap">
                                        <span class="payment-method-name">Bayar ke Kasir (Tunai / Debit)</span>
                                        <span class="payment-method-subtext">Uang tunai pas atau kartu debit di meja kasir</span>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-method-desc">
                                Nomor antrean dan rincian pesanan akan disiapkan untuk ditunjukkan ke kasir saat mengambil struk fisik
                            </div>
                        </label>

                    </div>
                </div>

            </div>

            {{-- ── RIGHT COLUMN: Ringkasan Pesanan & Tombol Checkout ── --}}
            <aside class="payment-right-col">
                <div class="payment-summary-card">
                    <div class="payment-card__header">
                        <div class="payment-card__icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <h2 class="payment-card__title">Ringkasan Pesanan</h2>
                    </div>

                    {{-- Items List from LocalStorage --}}
                    <div class="payment-items-list" id="paymentItemsList">
                        {{-- Diisi secara dinamis via JS --}}
                    </div>

                    {{-- Kalkulasi Total --}}
                    <div class="payment-calc-rows">
                        <div class="payment-calc-row">
                            <span>Subtotal Menu</span>
                            <strong id="calcSubtotal">Rp 0</strong>
                        </div>
                        <div class="payment-calc-row">
                            <span>Biaya Layanan</span>
                            <span style="color: #15803D; font-weight: 700;">Gratis</span>
                        </div>
                        <div class="payment-calc-row payment-calc-row--grand">
                            <span>Total Pembayaran</span>
                            <span class="payment-grand-total" id="calcGrandTotal">Rp 0</span>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="button" class="payment-btn-submit" id="btnConfirmPayment">
                        <span>Bayar & Konfirmasi</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                </div>
            </aside>

        </div>
    </main>

    {{-- Interactive Checkout JS Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const CART_STORAGE_KEY = 'ctb_cart_items';
            const formatRupiah = (num) => 'Rp ' + Number(num).toLocaleString('id-ID');

            // Ambil keranjang dari localStorage
            let cart = {};
            try {
                const stored = localStorage.getItem(CART_STORAGE_KEY);
                if (stored) {
                    cart = JSON.parse(stored);
                }
            } catch (e) {
                cart = {};
            }

            const paymentItemsList = document.getElementById('paymentItemsList');
            const calcSubtotal = document.getElementById('calcSubtotal');
            const calcGrandTotal = document.getElementById('calcGrandTotal');
            const btnConfirmPayment = document.getElementById('btnConfirmPayment');
            const custNameInput = document.getElementById('custName');
            const custTableInput = document.getElementById('custTable');
            const tableGroup = document.getElementById('tableGroup');
            const custNotesInput = document.getElementById('custNotes');

            // Modal elements
            const receiptModal = document.getElementById('receiptModal');
            const rcptId = document.getElementById('rcptId');
            const rcptDate = document.getElementById('rcptDate');
            const rcptName = document.getElementById('rcptName');
            const rcptType = document.getElementById('rcptType');
            const rcptPayment = document.getElementById('rcptPayment');
            const rcptItems = document.getElementById('rcptItems');
            const rcptTotal = document.getElementById('rcptTotal');
            const btnReceiptFinish = document.getElementById('btnReceiptFinish');

            let orderType = 'dine-in';
            let selectedMethod = null;

            // 1. Render items pesanan
            function renderItems() {
                const keys = Object.keys(cart);
                if (keys.length === 0) {
                    paymentItemsList.innerHTML = `
                        <div style="text-align: center; padding: 2rem 1rem; color: #6B7280;">
                            <p style="margin-bottom: 1rem;">Belum ada menu yang dipilih.</p>
                            <a href="{{ url('/#katalog') }}" class="payment-header__back-btn">Pilih Menu Sekarang</a>
                        </div>
                    `;
                    calcSubtotal.textContent = 'Rp 0';
                    calcGrandTotal.textContent = 'Rp 0';
                    btnConfirmPayment.disabled = true;
                    return;
                }

                btnConfirmPayment.disabled = false;
                let html = '';
                let subtotal = 0;

                keys.forEach(k => {
                    const item = cart[k];
                    const itemTotal = item.price * item.qty;
                    subtotal += itemTotal;

                    html += `
                        <div class="payment-summary-item">
                            <img src="${item.img}" alt="${item.name}" class="payment-summary-item__img">
                            <div class="payment-summary-item__info">
                                <h4 class="payment-summary-item__name">${item.name}</h4>
                                <span class="payment-summary-item__qty">${item.qty} &times; ${formatRupiah(item.price)}</span>
                            </div>
                            <span class="payment-summary-item__total">${formatRupiah(itemTotal)}</span>
                        </div>
                    `;
                });

                paymentItemsList.innerHTML = html;
                calcSubtotal.textContent = formatRupiah(subtotal);
                calcGrandTotal.textContent = formatRupiah(subtotal);
            }

            renderItems();

            // 2. Toggle Tipe Pesanan (Dine-in / Takeaway)
            const typeButtons = document.querySelectorAll('.payment-type-btn');
            typeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    typeButtons.forEach(b => {
                        b.classList.remove('active');
                        b.setAttribute('aria-checked', 'false');
                    });
                    btn.classList.add('active');
                    btn.setAttribute('aria-checked', 'true');
                    orderType = btn.dataset.type;

                    if (orderType === 'takeaway' || orderType === 'take-away' || orderType === 'take_away') {
                        tableGroup.style.display = 'none';
                    } else {
                        tableGroup.style.display = 'block';
                    }
                });
            });

            // 3. Toggle Metode Pembayaran
            const methodLabels = document.querySelectorAll('.payment-method-item');

            methodLabels.forEach(label => {
                label.addEventListener('click', () => {
                    methodLabels.forEach(l => l.classList.remove('active'));
                    label.classList.add('active');
                    const radio = label.querySelector('input[type="radio"]');
                    radio.checked = true;
                    selectedMethod = radio.value;
                });
            });

            // 4. Konfirmasi & Bayar Pesanan -> Simpan data & Redirect ke Halaman Konfirmasi
            btnConfirmPayment.addEventListener('click', () => {
                const customerName = custNameInput.value.trim();
                if (!customerName) {
                    custNameInput.focus();
                    custNameInput.style.borderColor = '#BE1E2D';
                    alert('Silakan masukkan nama pelanggan terlebih dahulu!');
                    setTimeout(() => {
                        custNameInput.style.borderColor = '';
                    }, 2000);
                    return;
                }

                if (orderType === 'dine-in') {
                    const tableNo = custTableInput.value.trim();
                    if (!tableNo) {
                        custTableInput.focus();
                        custTableInput.style.borderColor = '#BE1E2D';
                        alert('Silakan masukkan nomor meja terlebih dahulu!');
                        setTimeout(() => {
                            custTableInput.style.borderColor = '';
                        }, 2000);
                        return;
                    }
                }

                // Validasi Metode Pembayaran Wajib Dipilih
                if (!selectedMethod) {
                    const methodsGroup = document.getElementById('paymentMethodsGroup');
                    if (methodsGroup) {
                        methodsGroup.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        methodLabels.forEach(l => {
                            l.style.borderColor = '#BE1E2D';
                        });
                        setTimeout(() => {
                            methodLabels.forEach(l => {
                                if (!l.classList.contains('active')) {
                                    l.style.borderColor = '';
                                }
                            });
                        }, 2000);
                    }
                    alert('Silakan pilih salah satu Metode Pembayaran terlebih dahulu!');
                    return;
                }

                if (Object.keys(cart).length === 0) {
                    alert('Keranjang belanja Anda kosong. Silakan pilih menu terlebih dahulu.');
                    return;
                }

                const tableNo = custTableInput.value.trim();
                const notes = custNotesInput.value.trim();
                const typeText = orderType === 'dine-in' ? `Makan Sini (Meja ${tableNo})` : 'Bawa Pulang (Takeaway)';

                // Format waktu realtime saat ini
                const now = new Date();
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const day = String(now.getDate()).padStart(2, '0');
                const month = months[now.getMonth()];
                const year = now.getFullYear();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const formattedDate = `${day} ${month} ${year}, ${hours}:${minutes} WIB`;

                // Format items array untuk backend
                let totalAmount = 0;
                const itemsPayload = Object.keys(cart).map(k => {
                    const itemTotal = cart[k].price * cart[k].qty;
                    totalAmount += itemTotal;
                    return {
                        id: cart[k].id,
                        name: cart[k].name,
                        price: cart[k].price,
                        qty: cart[k].qty,
                        notes: cart[k].notes || null
                    };
                });

                // Disable submit button saat proses
                btnConfirmPayment.disabled = true;
                btnConfirmPayment.innerHTML = `<span>Memproses Pesanan...</span>`;

                // Kirim data pesanan ke backend API
                fetch("{{ route('pembayaran.checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        customer_name: customerName,
                        order_type: orderType,
                        table_number: tableNo,
                        notes: notes,
                        payment_method: selectedMethod,
                        items: itemsPayload
                    })
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();
                    } catch (e) {
                        throw new Error(`Server returned status ${res.status}`);
                    }

                    if (!res.ok || !data.success) {
                        const errorMsg = data.message || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Terjadi kesalahan saat memproses pesanan.');
                        throw new Error(errorMsg);
                    }

                    return data;
                })
                .then(data => {
                    const transactionId = data.order.id;

                    // Siapkan payload pesanan untuk disimpan ke sessionStorage (supaya aman dari reload)
                    const orderData = {
                        id: transactionId,
                        date: formattedDate,
                        customerName: customerName,
                        orderType: orderType,
                        orderTypeText: typeText,
                        tableNo: tableNo,
                        notes: notes,
                        paymentMethod: selectedMethod,
                        items: cart,
                        subtotal: totalAmount,
                        total: totalAmount,
                        createdAt: Date.now()
                    };

                    sessionStorage.setItem('ctb_current_order', JSON.stringify(orderData));

                    // Bersihkan keranjang belanja
                    localStorage.removeItem(CART_STORAGE_KEY);

                    // Arahkan ke halaman konfirmasi pembayaran
                    window.location.href = "{{ route('pembayaran.confirmation') }}";
                })
                .catch(err => {
                    console.error('Checkout error:', err);
                    alert(err.message || 'Gagal mengirim pesanan. Silakan periksa koneksi Anda.');
                    btnConfirmPayment.disabled = false;
                    btnConfirmPayment.innerHTML = `
                        <span>Bayar &amp; Konfirmasi</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12" 5 19 12 12 19"></polyline>
                        </svg>
                    `;
                });
            });
        });
    </script>
</body>
</html>
