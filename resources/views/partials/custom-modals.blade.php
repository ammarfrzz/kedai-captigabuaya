{{-- =====================================================
     CUSTOM MODALS & TOP-BAR NOTIFICATION
     Kedai Cap Tiga Buaya
     1. Custom Alert / Confirm Modal (Pengganti alert() & confirm() browser)
     2. Pending Payment Reminder Hover Top Bar (Hitung Mundur 1 Menit & Hapus DB QRIS)
     ===================================================== --}}

{{-- ── 1. CUSTOM ALERT / CONFIRMATION MODAL ── --}}
<div id="ctbAlertModal" class="ctb-modal-overlay" style="display: none;" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="ctb-modal-card">
        <div class="ctb-modal-icon-wrap" id="ctbAlertIconWrap">
            {{-- Warning Icon (Default) --}}
            <svg id="ctbAlertIconWarning" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            {{-- Info Icon --}}
            <svg id="ctbAlertIconInfo" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#0284C7" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            {{-- Success Icon --}}
            <svg id="ctbAlertIconSuccess" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            {{-- Error Icon --}}
            <svg id="ctbAlertIconError" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </div>

        <h3 class="ctb-modal-title" id="ctbAlertTitle">Perhatian</h3>
        <p class="ctb-modal-message" id="ctbAlertMessage">Silakan periksa kembali formulir Anda.</p>

        <div class="ctb-modal-actions" id="ctbAlertActions">
            <button type="button" class="ctb-modal-btn ctb-modal-btn--primary" id="ctbAlertBtnClose">
                <span id="ctbAlertBtnText">Mengerti</span>
            </button>
            <button type="button" class="ctb-modal-btn ctb-modal-btn--secondary" id="ctbAlertBtnCancel" style="display: none;">
                <span id="ctbAlertBtnCancelText">Batal</span>
            </button>
        </div>
    </div>
</div>

{{-- ── 2. PENDING PAYMENT REMINDER (FLOATING CORNER HOVER 1 MENIT) ── --}}
<div id="ctbPendingPaymentBar" class="ctb-top-bar" style="display: none;" role="region" aria-label="Pengingat Pembayaran QRIS">
    <div class="ctb-top-bar__container">
        {{-- Header Baris 1: Sisa Waktu QRIS, Timer & Close --}}
        <div class="ctb-top-bar__header">
            <div class="ctb-top-bar__timer-box">
                <span class="ctb-top-bar__pulse-dot"></span>
                <span class="ctb-top-bar__label">Sisa Waktu QRIS:</span>
                <strong class="ctb-top-bar__digits" id="ctbTopBarDigits">01:00</strong>
            </div>
            <button type="button" class="ctb-top-bar__close" id="ctbTopBarClose" aria-label="Tutup Pengingat" title="Tutup">
                &times;
            </button>
        </div>

        {{-- Baris 2: Nomor Pesanan & Total --}}
        <div class="ctb-top-bar__body">
            <span class="ctb-top-bar__order-tag" id="ctbTopBarOrderNumber">#CTB-Pesanan</span>
            <span class="ctb-top-bar__total" id="ctbTopBarTotalAmount">Rp 0</span>
        </div>

        {{-- Baris 3: Tombol Aksi --}}
        <div class="ctb-top-bar__actions">
            <a href="{{ route('pembayaran.confirmation') }}" class="ctb-top-bar__btn ctb-top-bar__btn--pay" id="ctbTopBarBtnContinue">
                <span>Lanjutkan Bayar</span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
            <button type="button" class="ctb-top-bar__btn ctb-top-bar__btn--cancel" id="ctbTopBarBtnCancel" title="Batalkan Pesanan Ini">
                Batalkan
            </button>
        </div>
    </div>
</div>

{{-- ── STYLES UNTUK MODAL & HOVER TOP BAR ── --}}
<style>
/* ── Overlay Modal ────────────────────────────────────── */
.ctb-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(11, 34, 20, 0.72);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: ctbFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) both;
}

/* ── Modal Card ───────────────────────────────────────── */
.ctb-modal-card {
    background: #FFFFFF;
    width: 100%;
    max-width: 420px;
    border-radius: 20px;
    padding: 28px 24px 24px;
    text-align: center;
    position: relative;
    box-shadow: 0 20px 48px rgba(11, 34, 20, 0.32), 0 6px 14px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(22, 60, 36, 0.12);
    animation: ctbScaleIn 0.26s cubic-bezier(0.175, 0.885, 0.32, 1.2) both;
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

/* ── Icon Wrap ────────────────────────────────────────── */
.ctb-modal-icon-wrap {
    width: 60px;
    height: 60px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: #FEF3C7;
    border: 3px solid #FDE68A;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);
}

.ctb-modal-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: #16241b;
    margin: 0 0 8px;
    line-height: 1.25;
}

.ctb-modal-message {
    font-size: 0.875rem;
    color: #475569;
    line-height: 1.55;
    margin: 0 0 20px;
}

/* ── Modal Actions ────────────────────────────────────── */
.ctb-modal-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ctb-modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 13px 20px;
    border-radius: 10px;
    font-family: inherit;
    font-size: 0.925rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    box-sizing: border-box;
}

.ctb-modal-btn--primary {
    background-color: #1A4D2B;
    color: #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(26, 77, 43, 0.28);
}

.ctb-modal-btn--primary:hover {
    background-color: #133920;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(26, 77, 43, 0.38);
}

.ctb-modal-btn--secondary {
    background-color: #F1F5F9;
    color: #475569;
    border: 1px solid #CBD5E1;
}

.ctb-modal-btn--secondary:hover {
    background-color: #E2E8F0;
    color: #1E293B;
}

/* ── FLOATING CORNER HOVER WIDGET (POJOK KANAN, TIDAK MENUTUPI LAYAR) ── */
.ctb-top-bar {
    position: fixed;
    top: 85px;
    right: 24px;
    width: 320px;
    max-width: calc(100vw - 32px);
    z-index: 9999;
    background: linear-gradient(145deg, #1A4D2B 0%, #11381E 100%);
    color: #FFFFFF;
    box-shadow: 0 10px 28px rgba(11, 34, 20, 0.42), 0 2px 8px rgba(0, 0, 0, 0.15);
    border: 1.5px solid #EAB308;
    border-radius: 14px;
    padding: 12px 14px;
    animation: ctbSlideInRight 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.85rem;
    box-sizing: border-box;
}

.ctb-top-bar__container {
    display: flex;
    flex-direction: column;
    gap: 9px;
    width: 100%;
}

.ctb-top-bar__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.ctb-top-bar__timer-box {
    display: flex;
    align-items: center;
    gap: 7px;
}

.ctb-top-bar__pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #EF4444;
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    animation: ctbDotPulse 1.5s infinite;
    flex-shrink: 0;
}

.ctb-top-bar__label {
    color: #E2E8F0;
    font-weight: 600;
    font-size: 0.78rem;
    letter-spacing: 0.2px;
}

.ctb-top-bar__digits {
    font-family: 'Plus Jakarta Sans', monospace, sans-serif;
    font-size: 0.95rem;
    font-weight: 800;
    color: #FACC15;
    background: rgba(0, 0, 0, 0.35);
    padding: 2px 7px;
    border-radius: 5px;
    border: 1px solid rgba(250, 204, 21, 0.4);
    letter-spacing: 0.5px;
}

.ctb-top-bar__digits.is-urgent {
    color: #FCA5A5;
    border-color: #EF4444;
    animation: ctbBlink 0.8s infinite;
}

.ctb-top-bar__close {
    background: transparent;
    border: none;
    color: #94A3B8;
    font-size: 1.25rem;
    line-height: 1;
    cursor: pointer;
    padding: 2px 5px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.ctb-top-bar__close:hover {
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.15);
}

.ctb-top-bar__body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 4px 0 2px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.825rem;
}

.ctb-top-bar__order-tag {
    background: rgba(255, 255, 255, 0.15);
    padding: 2px 8px;
    border-radius: 5px;
    font-weight: 700;
    color: #FFFFFF;
    font-size: 0.775rem;
}

.ctb-top-bar__total {
    color: #4ADE80;
    font-weight: 800;
    font-size: 0.875rem;
}

.ctb-top-bar__actions {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 2px;
}

.ctb-top-bar__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 7px 12px;
    border-radius: 8px;
    font-family: inherit;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: all 0.2s ease;
    flex: 1;
    text-align: center;
}

.ctb-top-bar__btn--pay {
    background: #EAB308;
    color: #16361F !important;
}

.ctb-top-bar__btn--pay:hover {
    background: #FACC15;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(234, 179, 8, 0.35);
}

.ctb-top-bar__btn--cancel {
    background: rgba(239, 68, 68, 0.18);
    color: #FCA5A5;
    border: 1px solid rgba(239, 68, 68, 0.45);
    flex: 0 0 auto;
    padding: 7px 10px;
}

.ctb-top-bar__btn--cancel:hover {
    background: #DC2626;
    color: #FFFFFF;
    border-color: #DC2626;
}

@media (max-width: 640px) {
    .ctb-top-bar {
        top: 75px;
        right: 12px;
        width: calc(100vw - 24px);
    }
}

/* ── Keyframes ────────────────────────────────────────── */
@keyframes ctbSlideInRight {
    from { transform: translateX(120%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes ctbFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes ctbScaleIn {
    from { transform: scale(0.92) translateY(12px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
}

@keyframes ctbDotPulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
}

@keyframes ctbBlink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.45; }
}
</style>

{{-- ── JAVASCRIPT SYSTEM MODAL & HOVER TOP BAR ── --}}
<script>
(function() {
    // ══════════════════════════════════════════════════════════
    // 1. SYSTEM CUSTOM ALERT & CONFIRM
    // ══════════════════════════════════════════════════════════
    const alertModal = document.getElementById('ctbAlertModal');
    const alertTitle = document.getElementById('ctbAlertTitle');
    const alertMessage = document.getElementById('ctbAlertMessage');
    const alertBtnClose = document.getElementById('ctbAlertBtnClose');
    const alertBtnText = document.getElementById('ctbAlertBtnText');
    const alertBtnCancel = document.getElementById('ctbAlertBtnCancel');
    const alertBtnCancelText = document.getElementById('ctbAlertBtnCancelText');
    const alertIconWrap = document.getElementById('ctbAlertIconWrap');

    const iconWarning = document.getElementById('ctbAlertIconWarning');
    const iconInfo = document.getElementById('ctbAlertIconInfo');
    const iconSuccess = document.getElementById('ctbAlertIconSuccess');
    const iconError = document.getElementById('ctbAlertIconError');

    let alertCloseCallback = null;
    let alertCancelCallback = null;

    window.showCustomAlert = function(options) {
        if (typeof options === 'string') {
            options = { title: 'Perhatian', message: options, type: 'warning' };
        }

        const title = options.title || 'Perhatian';
        const message = options.message || '';
        const type = options.type || 'warning';
        const btnText = options.btnText || 'Mengerti';
        alertCloseCallback = options.onClose || null;
        alertCancelCallback = null;

        if (alertTitle) alertTitle.textContent = title;
        if (alertMessage) alertMessage.textContent = message;
        if (alertBtnText) alertBtnText.textContent = btnText;
        if (alertBtnCancel) alertBtnCancel.style.display = 'none';

        if (iconWarning) iconWarning.style.display = 'none';
        if (iconInfo) iconInfo.style.display = 'none';
        if (iconSuccess) iconSuccess.style.display = 'none';
        if (iconError) iconError.style.display = 'none';

        if (type === 'info') {
            if (iconInfo) iconInfo.style.display = 'block';
            if (alertIconWrap) {
                alertIconWrap.style.background = '#E0F2FE';
                alertIconWrap.style.borderColor = '#BAE6FD';
                alertIconWrap.style.boxShadow = '0 4px 12px rgba(2, 132, 199, 0.15)';
            }
        } else if (type === 'success') {
            if (iconSuccess) iconSuccess.style.display = 'block';
            if (alertIconWrap) {
                alertIconWrap.style.background = '#DCFCE7';
                alertIconWrap.style.borderColor = '#86EFAC';
                alertIconWrap.style.boxShadow = '0 4px 12px rgba(22, 163, 74, 0.15)';
            }
        } else if (type === 'error') {
            if (iconError) iconError.style.display = 'block';
            if (alertIconWrap) {
                alertIconWrap.style.background = '#FEE2E2';
                alertIconWrap.style.borderColor = '#FECACA';
                alertIconWrap.style.boxShadow = '0 4px 12px rgba(220, 38, 38, 0.15)';
            }
        } else {
            if (iconWarning) iconWarning.style.display = 'block';
            if (alertIconWrap) {
                alertIconWrap.style.background = '#FEF3C7';
                alertIconWrap.style.borderColor = '#FDE68A';
                alertIconWrap.style.boxShadow = '0 4px 12px rgba(217, 119, 6, 0.15)';
            }
        }

        if (alertModal) {
            alertModal.style.display = 'flex';
            alertModal.setAttribute('aria-hidden', 'false');
        }
        if (alertBtnClose) alertBtnClose.focus();
    };

    window.showCustomConfirm = function(options) {
        options = options || {};
        const title = options.title || 'Konfirmasi';
        const message = options.message || 'Apakah Anda yakin ingin melanjutkan?';
        const type = options.type || 'warning';
        const confirmText = options.confirmText || 'Ya, Lanjutkan';
        const cancelText = options.cancelText || 'Batal';

        alertCloseCallback = options.onConfirm || null;
        alertCancelCallback = options.onCancel || null;

        if (alertTitle) alertTitle.textContent = title;
        if (alertMessage) alertMessage.textContent = message;
        if (alertBtnText) alertBtnText.textContent = confirmText;
        if (alertBtnCancel) {
            alertBtnCancel.style.display = 'inline-flex';
            if (alertBtnCancelText) alertBtnCancelText.textContent = cancelText;
        }

        if (iconWarning) iconWarning.style.display = 'none';
        if (iconInfo) iconInfo.style.display = 'none';
        if (iconSuccess) iconSuccess.style.display = 'none';
        if (iconError) iconError.style.display = 'none';

        if (type === 'error') {
            if (iconError) iconError.style.display = 'block';
            if (alertIconWrap) {
                alertIconWrap.style.background = '#FEE2E2';
                alertIconWrap.style.borderColor = '#FECACA';
            }
        } else {
            if (iconWarning) iconWarning.style.display = 'block';
            if (alertIconWrap) {
                alertIconWrap.style.background = '#FEF3C7';
                alertIconWrap.style.borderColor = '#FDE68A';
            }
        }

        if (alertModal) {
            alertModal.style.display = 'flex';
            alertModal.setAttribute('aria-hidden', 'false');
        }
        if (alertBtnClose) alertBtnClose.focus();
    };

    const closeCustomAlert = function() {
        if (!alertModal) return;
        alertModal.style.display = 'none';
        alertModal.setAttribute('aria-hidden', 'true');
        if (typeof alertCloseCallback === 'function') {
            const cb = alertCloseCallback;
            alertCloseCallback = null;
            cb();
        }
    };

    const cancelCustomAlert = function() {
        if (!alertModal) return;
        alertModal.style.display = 'none';
        alertModal.setAttribute('aria-hidden', 'true');
        if (typeof alertCancelCallback === 'function') {
            const cb = alertCancelCallback;
            alertCancelCallback = null;
            cb();
        }
    };

    if (alertBtnClose) alertBtnClose.addEventListener('click', closeCustomAlert);
    if (alertBtnCancel) alertBtnCancel.addEventListener('click', cancelCustomAlert);
    if (alertModal) {
        alertModal.addEventListener('click', function(e) {
            if (e.target === alertModal) {
                if (alertBtnCancel && alertBtnCancel.style.display !== 'none') {
                    cancelCustomAlert();
                } else {
                    closeCustomAlert();
                }
            }
        });
    }

    window.alert = function(msg) {
        window.showCustomAlert({
            title: 'Perhatian',
            message: String(msg),
            type: 'warning'
        });
    };

    // ══════════════════════════════════════════════════════════
    // 2. HOVER TOP BAR REMINDER (1 MENIT & HAPUS DB QRIS)
    // ══════════════════════════════════════════════════════════
    const PENDING_STORAGE_KEY = 'ctb_pending_payment';
    const topBar = document.getElementById('ctbPendingPaymentBar');
    const topBarDigits = document.getElementById('ctbTopBarDigits');
    const topBarOrderNumber = document.getElementById('ctbTopBarOrderNumber');
    const topBarTotalAmount = document.getElementById('ctbTopBarTotalAmount');
    const topBarBtnContinue = document.getElementById('ctbTopBarBtnContinue');
    const topBarBtnCancel = document.getElementById('ctbTopBarBtnCancel');
    const topBarClose = document.getElementById('ctbTopBarClose');

    let barCountdownInterval = null;

    const formatRp = function(n) {
        return 'Rp ' + Number(n || 0).toLocaleString('id-ID');
    };

    // Fungsi panggil endpoint backend untuk menghapus pesanan QRIS dari DB
    const cancelOrderInDB = function(orderId, dbId) {
        return fetch("{{ route('pembayaran.cancel') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_number: orderId,
                order_id: dbId || null
            })
        }).catch(err => console.error('Gagal membatalkan pesanan di database:', err));
    };

    const checkPendingPayment = function() {
        if (!topBar) return;

        // Jangan munculkan top bar jika user sedang berada di halaman checkout / konfirmasi
        const currentPath = window.location.pathname;
        if (currentPath.includes('pembayaran') || currentPath.includes('konfirmasi')) {
            return;
        }

        let pendingData = null;
        try {
            const raw = localStorage.getItem(PENDING_STORAGE_KEY);
            if (raw) pendingData = JSON.parse(raw);
        } catch (e) {
            pendingData = null;
        }

        // Hanya aktif untuk pesanan QRIS yang belum selesai
        if (!pendingData || !pendingData.expiresAt || pendingData.paymentMethod !== 'qris') {
            return;
        }

        const now = Date.now();
        const diffMs = pendingData.expiresAt - now;

        // Jika waktu 1 menit sudah habis saat membuka halaman: hapus dari DB & bersihkan storage
        if (diffMs <= 0) {
            cancelOrderInDB(pendingData.orderId, pendingData.dbId);
            localStorage.removeItem(PENDING_STORAGE_KEY);
            sessionStorage.removeItem('ctb_current_order');
            localStorage.removeItem('ctb_cart_items');
            if (typeof window.updateCartUI === 'function') window.updateCartUI();
            return;
        }

        // Tampilkan Hover Top Bar (tidak menutupi layar)
        if (topBarOrderNumber) topBarOrderNumber.textContent = '#' + (pendingData.orderId || 'Pesanan');
        if (topBarTotalAmount) topBarTotalAmount.textContent = formatRp(pendingData.total);
        if (topBarBtnContinue && pendingData.url) {
            topBarBtnContinue.href = pendingData.url;
        }

        topBar.style.display = 'block';

        // Hitung mundur 1 menit (60 detik)
        const updateTimer = function() {
            const remainingMs = pendingData.expiresAt - Date.now();
            if (remainingMs <= 0) {
                clearInterval(barCountdownInterval);
                if (topBarDigits) {
                    topBarDigits.textContent = '00:00';
                    topBarDigits.classList.add('is-urgent');
                }

                // Hapus pesanan QRIS dari database saat waktu habis
                cancelOrderInDB(pendingData.orderId, pendingData.dbId);
                localStorage.removeItem(PENDING_STORAGE_KEY);
                sessionStorage.removeItem('ctb_current_order');
                localStorage.removeItem('ctb_cart_items');
                if (typeof window.updateCartUI === 'function') window.updateCartUI();

                if (topBarBtnContinue) {
                    topBarBtnContinue.textContent = 'Waktu Habis';
                    topBarBtnContinue.href = '{{ url("/#katalog") }}';
                }

                setTimeout(() => {
                    topBar.style.display = 'none';
                }, 3500);
                return;
            }

            const remainingSec = Math.floor(remainingMs / 1000);
            const m = Math.floor(remainingSec / 60);
            const s = remainingSec % 60;

            if (topBarDigits) {
                topBarDigits.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                if (remainingSec < 20) {
                    topBarDigits.classList.add('is-urgent');
                } else {
                    topBarDigits.classList.remove('is-urgent');
                }
            }
        };

        updateTimer();
        clearInterval(barCountdownInterval);
        barCountdownInterval = setInterval(updateTimer, 1000);
    };

    if (topBarClose) {
        topBarClose.addEventListener('click', function() {
            if (topBar) topBar.style.display = 'none';
            clearInterval(barCountdownInterval);
        });
    }

    if (topBarBtnCancel) {
        topBarBtnCancel.addEventListener('click', function() {
            let pendingData = null;
            try {
                const raw = localStorage.getItem(PENDING_STORAGE_KEY);
                if (raw) pendingData = JSON.parse(raw);
            } catch (e) {}

            window.showCustomConfirm({
                title: 'Batalkan Pesanan QRIS?',
                message: 'Pesanan ini belum dibayar dan akan langsung dihapus dari antrean sistem.',
                type: 'warning',
                confirmText: 'Ya, Batalkan Pesanan',
                cancelText: 'Lanjutkan Bayar',
                onConfirm: function() {
                    if (pendingData) {
                        cancelOrderInDB(pendingData.orderId, pendingData.dbId);
                    }
                    localStorage.removeItem(PENDING_STORAGE_KEY);
                    sessionStorage.removeItem('ctb_current_order');
                    localStorage.removeItem('ctb_cart_items');
                    if (typeof window.updateCartUI === 'function') window.updateCartUI();
                    clearInterval(barCountdownInterval);
                    if (topBar) topBar.style.display = 'none';

                    window.showCustomAlert({
                        title: 'Pesanan Dibatalkan',
                        message: 'Pesanan QRIS berhasil dibatalkan dan telah dihapus dari sistem.',
                        type: 'info'
                    });
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkPendingPayment);
    } else {
        checkPendingPayment();
    }
})();
</script>
