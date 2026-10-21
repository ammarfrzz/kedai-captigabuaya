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

/* ── Menu Tabs ────────────────────────────────────── */
const menuTabs = document.querySelectorAll('.menu-tab');
const menuCards = document.querySelectorAll('.menu-card[data-category]');

if (menuTabs.length > 0) {
    menuTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            // Remove active from all tabs
            menuTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const category = tab.dataset.tab;

            menuCards.forEach((card) => {
                if (category === 'semua' || card.dataset.category === category) {
                    card.style.display = '';
                    card.style.animation = 'fadeInUp 0.4s ease both';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
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
