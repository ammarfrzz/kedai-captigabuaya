/**
 * Kedai Cap Tigabuaya — Main JavaScript
 * Navbar scroll, mobile drawer, animations on scroll, menu tabs
 */

import './bootstrap';

/* ── Navbar Scroll Effect ─────────────────────────── */
const navbar = document.getElementById('navbar');

if (navbar) {
    const handleScroll = () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // run on page load
}

/* ── Mobile Drawer ────────────────────────────────── */
const hamburger = document.getElementById('hamburger');
const drawer    = document.getElementById('mobileDrawer');
const drawerClose = document.getElementById('drawerClose');

if (hamburger && drawer) {
    const openDrawer = () => {
        drawer.classList.add('open');
        hamburger.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    const closeDrawer = () => {
        drawer.classList.remove('open');
        hamburger.classList.remove('open');
        document.body.style.overflow = '';
    };

    hamburger.addEventListener('click', openDrawer);

    if (drawerClose) drawerClose.addEventListener('click', closeDrawer);

    // Close on backdrop click
    drawer.addEventListener('click', (e) => {
        if (e.target === drawer) closeDrawer();
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDrawer();
    });
}

/* ── Hero Background Zoom on Load ────────────────── */
const hero = document.getElementById('beranda') || document.getElementById('hero');
if (hero) {
    window.addEventListener('load', () => {
        hero.classList.add('loaded');
    });
}

/* ── Intersection Observer — Reveal on Scroll ─────── */
const revealEls = document.querySelectorAll('[data-reveal]');

if (revealEls.length > 0) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = el.dataset.revealDelay || 0;
                setTimeout(() => {
                    el.classList.add('revealed');
                }, parseInt(delay));
                revealObserver.unobserve(el);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -50px 0px',
    });

    revealEls.forEach((el) => {
        el.classList.add('reveal-hidden');
        revealObserver.observe(el);
    });
}

/* ── Menu Tabs & Expandable Grid (Tampilkan 6 Menu Awal) ── */
const menuTabs = document.querySelectorAll('.menu-tab');
const menuCards = document.querySelectorAll('.menu-card[data-category]');
const btnToggleMenu = document.getElementById('btn-lihat-semua-menu');
const menuMoreWrap = document.querySelector('.menu-section__more');

if (menuCards.length > 0) {
    const INITIAL_VISIBLE_COUNT = 6;
    let isMenuExpanded = false;
    let currentCategory = 'semua';

    const renderCatalog = (animate = false) => {
        let matchedCount = 0;

        menuCards.forEach((card) => {
            const matchesCategory = (currentCategory === 'semua' || card.dataset.category === currentCategory);

            if (matchesCategory) {
                matchedCount++;
                const shouldShow = isMenuExpanded || (matchedCount <= INITIAL_VISIBLE_COUNT);
                if (shouldShow) {
                    card.style.display = '';
                    if (animate) {
                        card.style.animation = 'fadeInUp 0.35s ease both';
                    }
                } else {
                    card.style.display = 'none';
                }
            } else {
                card.style.display = 'none';
            }
        });

        // Update tombol Lihat Lebih Banyak Menu
        if (btnToggleMenu && menuMoreWrap) {
            if (matchedCount <= INITIAL_VISIBLE_COUNT) {
                menuMoreWrap.style.display = 'none';
            } else {
                menuMoreWrap.style.display = '';
                if (isMenuExpanded) {
                    btnToggleMenu.innerHTML = '<span>Tampilkan Lebih Sedikit ↑</span>';
                    btnToggleMenu.setAttribute('aria-expanded', 'true');
                } else {
                    const remainingCount = matchedCount - INITIAL_VISIBLE_COUNT;
                    btnToggleMenu.innerHTML = `<span>Lihat Menu Lainnya (+${remainingCount}) ↓</span>`;
                    btnToggleMenu.setAttribute('aria-expanded', 'false');
                }
            }
        }
    };

    // Event listener Tab Kategori
    if (menuTabs.length > 0) {
        menuTabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                menuTabs.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                });
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');

                currentCategory = tab.dataset.tab;
                renderCatalog(true);
            });
        });
    }

    // Event listener Tombol Toggle "Lihat Semua Menu"
    if (btnToggleMenu) {
        btnToggleMenu.addEventListener('click', () => {
            isMenuExpanded = !isMenuExpanded;
            renderCatalog(true);

            // Jika mengecilkan kembali ke 6, scroll halus ke header katalog
            if (!isMenuExpanded) {
                const katalogSection = document.getElementById('katalog');
                if (katalogSection) {
                    katalogSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }

    // Inisialisasi awal
    renderCatalog(false);
}

/* ── Number Counter Animation ─────────────────────── */
const counters = document.querySelectorAll('[data-counter]');

if (counters.length > 0) {
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            const el     = entry.target;
            const target = parseInt(el.dataset.counter, 10);
            const suffix = el.dataset.counterSuffix || '';
            const duration = 1800;
            const startTime = performance.now();

            const tick = (currentTime) => {
                const elapsed  = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased    = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                const value    = Math.floor(eased * target);

                el.textContent = value.toLocaleString('id-ID') + suffix;

                if (progress < 1) {
                    requestAnimationFrame(tick);
                }
            };

            requestAnimationFrame(tick);
            counterObserver.unobserve(el);
        });
    }, { threshold: 0.5 });

    counters.forEach(el => counterObserver.observe(el));
}

/* ── Section Scroll Spy & Navbar Highlight ─────────── */
const SECTION_IDS = [
    'beranda',
    'tentang',
    'kenapa-kami',
    'cara-pemesanan',
    'katalog',
    'galeri',
    'testimoni',
];

const navLinks = document.querySelectorAll('.navbar__link[href^="#"]');
const drawerLinks = document.querySelectorAll('.navbar__drawer-link[href^="#"]');

let isProgrammaticScroll = false;
let scrollEndTimer = null;

const setActiveSection = (activeId) => {
    navLinks.forEach((link) => {
        if (link.getAttribute('href') === `#${activeId}`) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    drawerLinks.forEach((link) => {
        if (link.getAttribute('href') === `#${activeId}`) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
};

const updateScrollSpy = () => {
    if (isProgrammaticScroll) return;

    const scrollY = window.scrollY || window.pageYOffset;
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;

    // 1. Jika di posisi paling atas, selalu aktifkan 'beranda'
    if (scrollY < 60) {
        setActiveSection('beranda');
        return;
    }

    // 2. Jika scroll sudah hampir mencapai bawah halaman, aktifkan section terakhir ('testimoni')
    if (scrollY + windowHeight >= documentHeight - 80) {
        setActiveSection('testimoni');
        return;
    }

    // 3. Garis acuan fokus pembacaan: di bawah navbar yang fixed
    const navbarH = navbar ? navbar.offsetHeight : 70;
    const triggerLine = navbarH + 100;

    let currentId = 'beranda';

    for (let i = 0; i < SECTION_IDS.length; i++) {
        const id = SECTION_IDS[i];
        const el = document.getElementById(id);
        if (!el) continue;

        const rect = el.getBoundingClientRect();
        if (rect.top <= triggerLine) {
            currentId = id;
        }
    }

    setActiveSection(currentId);
};

// Throttle scroll events via requestAnimationFrame
let ticking = false;
window.addEventListener('scroll', () => {
    if (!ticking) {
        window.requestAnimationFrame(() => {
            updateScrollSpy();
            ticking = false;
        });
        ticking = true;
    }
}, { passive: true });

// Jalankan saat load awal
updateScrollSpy();

/* ── Smooth Scroll for Anchor Links ──────────────── */
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
        const href = anchor.getAttribute('href');
        if (!href || href === '#') return;

        const target = document.querySelector(href);
        if (!target) return;

        e.preventDefault();

        // Tutup mobile drawer jika sedang terbuka
        if (drawer && drawer.classList.contains('open')) {
            drawer.classList.remove('open');
            if (hamburger) hamburger.classList.remove('open');
            document.body.style.overflow = '';
        }

        const targetId = href.replace('#', '');
        setActiveSection(targetId);

        // Kunci update scroll spy selama animasi smooth scroll berjalan agar tidak jumping
        isProgrammaticScroll = true;
        clearTimeout(scrollEndTimer);
        scrollEndTimer = setTimeout(() => {
            isProgrammaticScroll = false;
            updateScrollSpy();
        }, 700);

        const navbarH = navbar ? navbar.offsetHeight : 70;
        const offsetTop = (href === '#beranda')
            ? 0
            : Math.max(0, target.getBoundingClientRect().top + window.scrollY - navbarH - 10);

        window.scrollTo({ top: offsetTop, behavior: 'smooth' });
    });
});

/* ── Reveal CSS (injected via JS) ─────────────────── */
const revealStyle = document.createElement('style');
revealStyle.textContent = `
    .reveal-hidden {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.65s cubic-bezier(0.4,0,0.2,1),
                    transform 0.65s cubic-bezier(0.4,0,0.2,1);
    }
    .revealed {
        opacity: 1 !important;
        transform: none !important;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: none; }
    }
`;
document.head.appendChild(revealStyle);

/* ── Floating Cart & Popup Drawer System ─────────── */
const CART_STORAGE_KEY = 'ctb_cart_items';

// Reset keranjang jika pengguna me-refresh halaman (reload)
(() => {
    try {
        const perfEntries = performance.getEntriesByType('navigation');
        const isReload = (perfEntries.length > 0 && perfEntries[0].type === 'reload') ||
                         (window.performance && window.performance.navigation && window.performance.navigation.type === 1);
        if (isReload) {
            localStorage.removeItem(CART_STORAGE_KEY);
        }
    } catch (e) {
        // Fallback jika performance API tidak didukung
    }
})();

const getCart = () => {
    try {
        const stored = localStorage.getItem(CART_STORAGE_KEY);
        return stored ? JSON.parse(stored) : {};
    } catch (e) {
        return {};
    }
};

const saveCart = (cart) => {
    try {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
    } catch (e) {
        console.error('Gagal menyimpan keranjang:', e);
    }
};

const formatRupiah = (num) => 'Rp ' + Number(num).toLocaleString('id-ID');

const floatingCartBtn = document.getElementById('floatingCartBtn');
const floatingCartBadge = document.getElementById('floatingCartBadge');
const floatingCartTotal = document.getElementById('floatingCartTotal');
const cartDrawer = document.getElementById('cartDrawer');
const cartDrawerBackdrop = document.getElementById('cartDrawerBackdrop');
const cartDrawerCloseBtn = document.getElementById('cartDrawerCloseBtn');
const cartDrawerBody = document.getElementById('cartDrawerBody');
const cartDrawerSubtotal = document.getElementById('cartDrawerSubtotal');
const cartDrawerTotal = document.getElementById('cartDrawerTotal');
const cartDrawerItemCount = document.getElementById('cartDrawerItemCount');
const cartDrawerClearBtn = document.getElementById('cartDrawerClearBtn');
const cartDrawerCheckoutBtn = document.getElementById('cartDrawerCheckoutBtn');
const cartToast = document.getElementById('cartToast');
const cartToastText = document.getElementById('cartToastText');

let toastTimeout = null;
const showToast = (message) => {
    if (!cartToast || !cartToastText) return;
    cartToastText.textContent = message;
    cartToast.classList.add('show');
    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
        cartToast.classList.remove('show');
    }, 2200);
};

const updateCartUI = () => {
    const cart = getCart();
    const itemKeys = Object.keys(cart);
    let totalItems = 0;
    let subtotal = 0;

    itemKeys.forEach(k => {
        totalItems += cart[k].qty;
        subtotal += (cart[k].price * cart[k].qty);
    });

    // Update Floating Button
    if (floatingCartBadge) {
        floatingCartBadge.textContent = totalItems;
    }
    if (floatingCartTotal) {
        floatingCartTotal.textContent = formatRupiah(subtotal);
    }
    if (cartDrawerItemCount) {
        cartDrawerItemCount.textContent = `${totalItems} Menu`;
    }
    if (cartDrawerSubtotal) {
        cartDrawerSubtotal.textContent = formatRupiah(subtotal);
    }
    if (cartDrawerTotal) {
        cartDrawerTotal.textContent = formatRupiah(subtotal);
    }

    if (cartDrawerCheckoutBtn) {
        if (totalItems === 0) {
            cartDrawerCheckoutBtn.style.opacity = '0.5';
            cartDrawerCheckoutBtn.style.pointerEvents = 'none';
        } else {
            cartDrawerCheckoutBtn.style.opacity = '1';
            cartDrawerCheckoutBtn.style.pointerEvents = 'auto';
        }
    }

    // Render Drawer Body
    if (cartDrawerBody) {
        if (itemKeys.length === 0) {
            cartDrawerBody.innerHTML = `
                <div class="cart-empty-state">
                    <div class="cart-empty-icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <h3 class="cart-empty-title">Keranjang Kamu Masih Kosong</h3>
                    <p class="cart-empty-desc">Belum ada makanan atau minuman yang kamu tambahkan. Yuk intip pilihan menu lezat kami!</p>
                    <button type="button" class="cart-empty-btn" id="btnCartExploreMenu">
                        Lihat Menu Sekarang
                    </button>
                </div>
            `;

            const btnExplore = document.getElementById('btnCartExploreMenu');
            if (btnExplore) {
                btnExplore.addEventListener('click', () => {
                    closeCartDrawer();
                    const katalogSection = document.getElementById('katalog');
                    if (katalogSection) {
                        katalogSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
        } else {
            let html = '';
            itemKeys.forEach(k => {
                const item = cart[k];
                const itemTotal = item.price * item.qty;
                html += `
                    <div class="cart-item">
                        <img src="${item.img}" alt="${item.name}" class="cart-item__img">
                        <div class="cart-item__details">
                            <h4 class="cart-item__name">${item.name}</h4>
                            <div class="cart-item__price">${formatRupiah(item.price)} &times; ${item.qty} = <strong>${formatRupiah(itemTotal)}</strong></div>
                            <div class="cart-item__actions">
                                <div class="cart-item__qty-control">
                                    <button type="button" class="cart-item__qty-btn btn-cart-minus" data-id="${k}" aria-label="Kurangi jumlah">−</button>
                                    <span class="cart-item__qty-val">${item.qty}</span>
                                    <button type="button" class="cart-item__qty-btn btn-cart-plus" data-id="${k}" aria-label="Tambah jumlah">+</button>
                                </div>
                                <button type="button" class="cart-item__remove-btn btn-cart-remove" data-id="${k}" title="Hapus menu">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            cartDrawerBody.innerHTML = html;

            // Attach event listeners ke tombol dynamic dalam cart drawer
            cartDrawerBody.querySelectorAll('.btn-cart-minus').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const c = getCart();
                    if (c[id]) {
                        if (c[id].qty > 1) {
                            c[id].qty -= 1;
                        } else {
                            delete c[id];
                        }
                        saveCart(c);
                        updateCartUI();
                    }
                });
            });

            cartDrawerBody.querySelectorAll('.btn-cart-plus').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const c = getCart();
                    if (c[id]) {
                        c[id].qty += 1;
                        saveCart(c);
                        updateCartUI();
                    }
                });
            });

            cartDrawerBody.querySelectorAll('.btn-cart-remove').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    const c = getCart();
                    if (c[id]) {
                        delete c[id];
                        saveCart(c);
                        updateCartUI();
                    }
                });
            });
        }
    }
};

const openCartDrawer = () => {
    if (cartDrawer && cartDrawerBackdrop) {
        updateCartUI();
        cartDrawer.classList.add('active');
        cartDrawerBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
};

const closeCartDrawer = () => {
    if (cartDrawer && cartDrawerBackdrop) {
        cartDrawer.classList.remove('active');
        cartDrawerBackdrop.classList.remove('active');
        document.body.style.overflow = '';
    }
};

// Event listener tombol open/close cart
if (floatingCartBtn) {
    floatingCartBtn.addEventListener('click', openCartDrawer);
}
if (cartDrawerCloseBtn) {
    cartDrawerCloseBtn.addEventListener('click', closeCartDrawer);
}
if (cartDrawerBackdrop) {
    cartDrawerBackdrop.addEventListener('click', closeCartDrawer);
}
if (cartDrawerClearBtn) {
    cartDrawerClearBtn.addEventListener('click', () => {
        if (confirm('Apakah kamu yakin ingin mengosongkan seluruh pesanan di keranjang?')) {
            saveCart({});
            updateCartUI();
            showToast('Keranjang telah dikosongkan');
        }
    });
}

// Close via ESC
window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && cartDrawer && cartDrawer.classList.contains('active')) {
        closeCartDrawer();
    }
});

// Event listener Tambah ke Keranjang (Tombol icon keranjang +)
document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const price = parseInt(btn.dataset.price, 10);
        const img = btn.dataset.img;

        const cart = getCart();
        if (cart[id]) {
            cart[id].qty += 1;
        } else {
            cart[id] = { id, name, price, img, qty: 1 };
        }

        saveCart(cart);
        updateCartUI();

        // Bounce badge
        if (floatingCartBadge) {
            floatingCartBadge.classList.remove('cart-badge-bounce');
            void floatingCartBadge.offsetWidth; // trigger reflow
            floatingCartBadge.classList.add('cart-badge-bounce');
        }

        // Visual feedback pada icon button
        btn.classList.add('added');
        setTimeout(() => {
            btn.classList.remove('added');
        }, 800);

        showToast(`${name} ditambahkan ke keranjang!`);
    });
});

// Event listener "Pesan Sekarang" (Langsung arahkan ke Halaman Pembayaran hanya membawa menu ini saja)
document.querySelectorAll('.btn-buy-now').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const price = parseInt(btn.dataset.price, 10);
        const img = btn.dataset.img;

        // Hanya pesan menu yang diklik saat ini (tidak menggabungkan isi keranjang sebelumnya)
        const singleItemCart = {};
        singleItemCart[id] = { id, name, price, img, qty: 1 };

        saveCart(singleItemCart);

        const paymentUrl = btn.dataset.paymentUrl || '/pembayaran';
        window.location.href = paymentUrl;
    });
});

// Inisialisasi awal UI keranjang saat halaman dibuka
updateCartUI();
