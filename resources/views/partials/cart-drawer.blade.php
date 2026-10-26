{{-- =====================================================
     FLOATING CART TRIGGER & POPUP DRAWER
     Kedai Cap Tiga Buaya
     ===================================================== --}}

{{-- Floating Cart Trigger Button (Pojok Kanan Bawah) --}}
<button
    type="button"
    class="floating-cart-btn"
    id="floatingCartBtn"
    aria-label="Buka Keranjang Pesanan"
    aria-haspopup="dialog"
    title="Lihat Keranjang Pesanan"
>
    <div class="floating-cart-icon-wrap">
        <svg class="floating-cart-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span class="floating-cart-badge" id="floatingCartBadge">0</span>
    </div>
</button>

{{-- Cart Drawer Backdrop --}}
<div class="cart-drawer-backdrop" id="cartDrawerBackdrop"></div>

{{-- Cart Drawer (Slide-over Popup) --}}
<aside class="cart-drawer" id="cartDrawer" role="dialog" aria-modal="true" aria-labelledby="cartDrawerHeading">
    
    {{-- Drawer Header --}}
    <div class="cart-drawer__header">
        <div class="cart-drawer__title-wrap">
            <h2 class="cart-drawer__title" id="cartDrawerHeading">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#234E2F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Pesanan Kamu</span>
            </h2>
        </div>
        <button type="button" class="cart-drawer__close-btn" id="cartDrawerCloseBtn" aria-label="Tutup Keranjang">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    {{-- Drawer Body (Daftar Menu yang Ditambahkan) --}}
    <div class="cart-drawer__body" id="cartDrawerBody">
        {{-- Diisi secara dinamis oleh JavaScript --}}
    </div>

    {{-- Drawer Footer (Subtotal & Lanjut ke Pembayaran) --}}
    <div class="cart-drawer__footer" id="cartDrawerFooter">
        <div class="cart-drawer__summary-row">
            <span>Subtotal Menu</span>
            <strong id="cartDrawerSubtotal">Rp 0</strong>
        </div>
        <div class="cart-drawer__summary-row">
            <span>Biaya Layanan</span>
            <span style="color: #15803D; font-weight: 700;">Gratis</span>
        </div>
        <div class="cart-drawer__summary-row cart-drawer__summary-row--total">
            <span>Total Pembayaran</span>
            <span class="cart-drawer__summary-total-price" id="cartDrawerTotal">Rp 0</span>
        </div>

        <a href="{{ route('pembayaran') }}" class="cart-drawer__checkout-btn" id="cartDrawerCheckoutBtn">
            <span>Lanjut ke Pembayaran</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>

        <button type="button" class="cart-drawer__clear-btn" id="cartDrawerClearBtn">
            Kosongkan Keranjang
        </button>
    </div>

</aside>

{{-- Toast Notification saat item ditambahkan --}}
<div class="cart-toast" id="cartToast" role="status" aria-live="polite">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
    </svg>
    <span id="cartToastText">Menu berhasil ditambahkan!</span>
</div>
