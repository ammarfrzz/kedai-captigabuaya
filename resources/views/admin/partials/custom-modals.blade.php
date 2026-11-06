{{-- =====================================================
     ADMIN CUSTOM MODAL SYSTEM (ALERT & CONFIRM)
     Kedai Cap Tiga Buaya - Dashboard Admin
     Pengganti window.alert() dan window.confirm() browser
     ===================================================== --}}
<div id="adminModalOverlay" class="admin-modal-overlay" style="display: none;" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="admin-modal-card">
        {{-- Icon Wrap --}}
        <div class="admin-modal-icon-wrap" id="adminModalIconWrap">
            {{-- Danger Icon (Default for Deletions) --}}
            <svg id="adminModalIconDanger" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            {{-- Warning Icon --}}
            <svg id="adminModalIconWarning" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            {{-- Info Icon --}}
            <svg id="adminModalIconInfo" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#0284C7" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            {{-- Success Icon --}}
            <svg id="adminModalIconSuccess" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>

        <h3 class="admin-modal-title" id="adminModalTitle">Konfirmasi Hapus</h3>
        <p class="admin-modal-message" id="adminModalMessage">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>

        <div class="admin-modal-actions">
            <button type="button" class="admin-modal-btn admin-modal-btn--confirm" id="adminModalBtnConfirm">
                <span id="adminModalBtnConfirmText">Ya, Hapus</span>
            </button>
            <button type="button" class="admin-modal-btn admin-modal-btn--cancel" id="adminModalBtnCancel">
                <span id="adminModalBtnCancelText">Batal</span>
            </button>
        </div>
    </div>
</div>

<style>
.admin-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: adminFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.admin-modal-card {
    background: #FFFFFF;
    width: 100%;
    max-width: 420px;
    border-radius: 18px;
    padding: 28px 24px 22px;
    text-align: center;
    position: relative;
    box-shadow: 0 24px 50px rgba(15, 23, 42, 0.25), 0 8px 16px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(226, 232, 240, 0.9);
    animation: adminScaleIn 0.24s cubic-bezier(0.175, 0.885, 0.32, 1.2) both;
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-sizing: border-box;
}

.admin-modal-icon-wrap {
    width: 58px;
    height: 58px;
    margin: 0 auto 16px;
    border-radius: 50%;
    background: #FEE2E2;
    border: 3px solid #FECACA;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.15);
    transition: all 0.2s ease;
}

.admin-modal-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.25rem;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 8px;
    line-height: 1.3;
}

.admin-modal-message {
    font-size: 0.885rem;
    color: #64748B;
    line-height: 1.55;
    margin: 0 0 22px;
}

.admin-modal-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.admin-modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 12px 18px;
    border-radius: 10px;
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    border: none;
    transition: all 0.18s ease;
    box-sizing: border-box;
}

.admin-modal-btn--confirm {
    background-color: #DC2626;
    color: #FFFFFF !important;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.28);
}

.admin-modal-btn--confirm:hover {
    background-color: #B91C1C;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.38);
}

.admin-modal-btn--confirm.btn-green {
    background-color: #1A4D2B;
    box-shadow: 0 4px 12px rgba(26, 77, 43, 0.28);
}

.admin-modal-btn--confirm.btn-green:hover {
    background-color: #133920;
    box-shadow: 0 6px 16px rgba(26, 77, 43, 0.38);
}

.admin-modal-btn--confirm.btn-amber {
    background-color: #D97706;
    box-shadow: 0 4px 12px rgba(217, 119, 6, 0.28);
}

.admin-modal-btn--confirm.btn-amber:hover {
    background-color: #B45309;
    box-shadow: 0 6px 16px rgba(217, 119, 6, 0.38);
}

.admin-modal-btn--cancel {
    background-color: #F8FAFC;
    color: #475569;
    border: 1px solid #E2E8F0;
}

.admin-modal-btn--cancel:hover {
    background-color: #F1F5F9;
    color: #0F172A;
}

@keyframes adminFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes adminScaleIn {
    from { transform: scale(0.92) translateY(10px); opacity: 0; }
    to { transform: scale(1) translateY(0); opacity: 1; }
}
</style>

<script>
(function() {
    const modalOverlay = document.getElementById('adminModalOverlay');
    const modalTitle = document.getElementById('adminModalTitle');
    const modalMessage = document.getElementById('adminModalMessage');
    const btnConfirm = document.getElementById('adminModalBtnConfirm');
    const btnConfirmText = document.getElementById('adminModalBtnConfirmText');
    const btnCancel = document.getElementById('adminModalBtnCancel');
    const btnCancelText = document.getElementById('adminModalBtnCancelText');
    const iconWrap = document.getElementById('adminModalIconWrap');

    const iconDanger = document.getElementById('adminModalIconDanger');
    const iconWarning = document.getElementById('adminModalIconWarning');
    const iconInfo = document.getElementById('adminModalIconInfo');
    const iconSuccess = document.getElementById('adminModalIconSuccess');

    let onConfirmCallback = null;
    let onCancelCallback = null;

    window.showAdminConfirm = function(options) {
        options = options || {};
        const title = options.title || 'Konfirmasi';
        const message = options.message || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
        const type = options.type || 'danger'; // danger, warning, success, info
        const confirmText = options.confirmText || 'Ya, Lanjutkan';
        const cancelText = options.cancelText || 'Batal';

        onConfirmCallback = options.onConfirm || null;
        onCancelCallback = options.onCancel || null;

        if (modalTitle) modalTitle.textContent = title;
        if (modalMessage) modalMessage.textContent = message;
        if (btnConfirmText) btnConfirmText.textContent = confirmText;
        if (btnCancelText) btnCancelText.textContent = cancelText;

        if (btnCancel) btnCancel.style.display = 'inline-flex';

        // Reset icons
        if (iconDanger) iconDanger.style.display = 'none';
        if (iconWarning) iconWarning.style.display = 'none';
        if (iconInfo) iconInfo.style.display = 'none';
        if (iconSuccess) iconSuccess.style.display = 'none';

        // Reset button colors
        if (btnConfirm) btnConfirm.classList.remove('btn-green', 'btn-amber');

        if (type === 'danger') {
            if (iconDanger) iconDanger.style.display = 'block';
            if (iconWrap) {
                iconWrap.style.background = '#FEE2E2';
                iconWrap.style.borderColor = '#FECACA';
                iconWrap.style.boxShadow = '0 4px 14px rgba(220, 38, 38, 0.15)';
            }
        } else if (type === 'warning') {
            if (iconWarning) iconWarning.style.display = 'block';
            if (btnConfirm) btnConfirm.classList.add('btn-amber');
            if (iconWrap) {
                iconWrap.style.background = '#FEF3C7';
                iconWrap.style.borderColor = '#FDE68A';
                iconWrap.style.boxShadow = '0 4px 14px rgba(217, 119, 6, 0.15)';
            }
        } else if (type === 'success') {
            if (iconSuccess) iconSuccess.style.display = 'block';
            if (btnConfirm) btnConfirm.classList.add('btn-green');
            if (iconWrap) {
                iconWrap.style.background = '#DCFCE7';
                iconWrap.style.borderColor = '#86EFAC';
                iconWrap.style.boxShadow = '0 4px 14px rgba(22, 163, 74, 0.15)';
            }
        } else {
            if (iconInfo) iconInfo.style.display = 'block';
            if (btnConfirm) btnConfirm.classList.add('btn-green');
            if (iconWrap) {
                iconWrap.style.background = '#E0F2FE';
                iconWrap.style.borderColor = '#BAE6FD';
                iconWrap.style.boxShadow = '0 4px 14px rgba(2, 132, 199, 0.15)';
            }
        }

        if (modalOverlay) {
            modalOverlay.style.display = 'flex';
            modalOverlay.setAttribute('aria-hidden', 'false');
        }
        if (btnConfirm) btnConfirm.focus();
    };

    window.closeAdminModal = function() {
        if (!modalOverlay) return;
        modalOverlay.style.display = 'none';
        modalOverlay.setAttribute('aria-hidden', 'true');
        onConfirmCallback = null;
        onCancelCallback = null;
    };

    if (btnConfirm) {
        btnConfirm.addEventListener('click', function() {
            const cb = onConfirmCallback;
            window.closeAdminModal();
            if (typeof cb === 'function') cb();
        });
    }

    if (btnCancel) {
        btnCancel.addEventListener('click', function() {
            const cb = onCancelCallback;
            window.closeAdminModal();
            if (typeof cb === 'function') cb();
        });
    }

    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                window.closeAdminModal();
            }
        });
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalOverlay && modalOverlay.style.display !== 'none') {
            window.closeAdminModal();
        }
    });

    // Otomatis tangani semua form yang memiliki atribut data-confirm="Pesan konfirmasi..."
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form && form.dataset && form.dataset.confirm) {
            e.preventDefault();
            const message = form.dataset.confirm;
            const title = form.dataset.confirmTitle || 'Konfirmasi Tindakan';
            const type = form.dataset.confirmType || 'danger';
            const btnText = form.dataset.confirmBtn || 'Ya, Lanjutkan';

            window.showAdminConfirm({
                title: title,
                message: message,
                type: type,
                confirmText: btnText,
                cancelText: 'Batal',
                onConfirm: function() {
                    delete form.dataset.confirm;
                    form.submit();
                }
            });
        }
    });
})();
</script>

