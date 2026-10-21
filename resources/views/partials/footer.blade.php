{{-- resources/views/partials/footer.blade.php --}}
<footer class="footer" id="kontak" role="contentinfo">
    <div class="container">

        {{-- Main Footer Grid --}}
        <div class="footer__main">

            {{-- Column 1: Brand Info --}}
            <div class="footer__brand-col">
                <h3 class="footer__brand-title">Kedai Cap Tiga Buaya</h3>
                <p class="footer__brand-desc">
                    Lahir dari kultur nongkrong arek Surabaya, <br>Cap Tiga Buaya hadir membawakan cita rasa otentik kopitiam yang ramah di lidah dan <br>selalu bikin kangen.
                </p>
            </div>

            {{-- Column 2: Hubungi Kami --}}
            <div class="footer__col">
                <h3 class="footer__col-title">Hubungi Kami</h3>
                <div class="footer__info-list">
                    <div class="footer__info-item">
                        <svg class="footer__info-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Jl. Jemursari IX No.9, Surabaya, Jawa Timur, Indonesia</span>
                    </div>
                    <div class="footer__info-item">
                        <svg class="footer__info-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <a href="tel:+6287766102500">+62 877-6610-2500</a>
                    </div>
                    <div class="footer__info-item">
                        <svg class="footer__info-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <a href="mailto:admin@kedaicaptigabuaya.id">admin@kedaicaptigabuaya.id</a>
                    </div>
                </div>
            </div>

            {{-- Column 3: Jam Operasional --}}
            <div class="footer__col">
                <h3 class="footer__col-title">Jam Operasional</h3>
                <div class="footer__schedule-box">
                    <svg class="footer__schedule-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <div class="footer__schedule-text">
                        <div>Senin – Jumat: 10:00 – 23:00</div>
                        <div>Sabtu – Minggu: 08:00 – 23:00</div>
                    </div>
                </div>
            </div>

            {{-- Column 4: Ikuti Kami --}}
            <div class="footer__col">
                <h3 class="footer__col-title">Ikuti Kami</h3>
                <div class="footer__social-row" aria-label="Media sosial kami">
                    <a href="https://www.instagram.com/captigabuaya/" class="footer__social-circle" aria-label="Instagram Kedai Cap Tiga Buaya" title="Instagram">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@captigabuaya" class="footer__social-circle" aria-label="TikTok Kedai Cap Tiga Buaya" title="TikTok">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.82 4.49 6.3 6.3 0 0 0 1.86-4.49V8.75a8.28 8.28 0 0 0 4.84 1.56V6.85a4.85 4.85 0 0 1-.93-.16z"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="footer__bottom">
            <p class="footer__copyright">
                &copy; {{ date('Y') }} Kedai Cap Tiga Buaya. Seluruh hak cipta dilindungi.
            </p>
            <div class="footer__bottom-links">
                <a href="#" class="footer__bottom-link">Kebijakan Privasi</a>
                <a href="#" class="footer__bottom-link">Syarat &amp; Ketentuan</a>
            </div>
        </div>

    </div>
</footer>
