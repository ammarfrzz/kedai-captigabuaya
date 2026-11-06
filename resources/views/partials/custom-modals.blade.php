{{-- =====================================================
     CUSTOM MODALS & TOP-BAR NOTIFICATION
     Kedai Cap Tiga Buaya
     1. Custom Alert / Confirm Modal (Pengganti alert() & confirm() browser)
     
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

{{-- ── STYLES UNTUK CUSTOM MODAL ── --}}
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

/* ── Keyframes ────────────────────────────────────────── */
@keyframes ctbFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes ctbScaleIn {
    from { transform: scale(0.92) translateY(12px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
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

    window.confirm = function(msg) {
        // Fallback jika ada kode yang memanggil confirm() secara synchronous
        // Tapi sarankan memanggil showCustomConfirm langsung
        return false;
    };

    })();
</script>
