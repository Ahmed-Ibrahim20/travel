<!-- Footer -->
<footer class="site-footer" role="contentinfo" aria-label="Footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand -->
                <div class="footer-section footer-brand">
                    <a
                        href="{{ route('interface.main') }}"
                        class="brand-inline"
                        aria-label="Dahab Dream homepage">
                        <img
                            src="{{ asset('assets/img/logo.png') }}"
                            alt="Dahab Dream logo"
                            width="56"
                            height="56" />
                        <div class="brand-text">
                            <div class="brand-name">Dahab Dream</div>
                            <div class="brand-sub">
                                Real trips · Fair prices · Trusted
                            </div>
                        </div>
                    </a>
                    <p class="brand-desc">
                        We craft hassle-free Red Sea trips — Hurghada, Sharm, Ain Sokhna
                        and more. Personalized service and 24/7 support.
                    </p>
                </div>

                <!-- Links -->
                <nav class="footer-section footer-links" aria-label="Quick links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('interface.main') }}#hero">{{ __('interface.nav.home') }}</a></li>
                        <li><a href="{{ route('interface.main') }}#destinations">{{ __('interface.nav.destinations') }}</a></li>
                        <li><a href="{{ route('interface.main') }}#popular">{{ __('interface.nav.tours') }}</a></li>
                        <li><a href="{{ route('interface.main') }}#testimonials">{{ __('interface.testimonials.title') }}</a></li>
                        <li><a href="{{ route('interface.main') }}#contact">{{ __('interface.nav.contact') }}</a></li>
                    </ul>
                </nav>

                <!-- Popular Trips -->
                <div class="footer-section footer-trips" aria-label="Popular trips">
                    <h4>{{ __('interface.popular_trips.title') }}</h4>
                    <ul class="trip-list">
                        <li>
                            <a href="#"><span>Hurghada — 4D/3N</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Sharm — 5D/4N</span></a>
                        </li>
                        <li>
                            <a href="#"><span>Ain Sokhna — 3D/2N</span></a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-section footer-contact" aria-label="Contact">
                    <h4>Contact & Newsletter</h4>
                    <div class="contact-lines">
                        <div class="c-row">
                            <i class="fa-solid fa-phone"></i><a href="tel:+201061558461">+20 106 155 8461</a>
                        </div>
                        <div class="c-row">
                            <i class="fa-solid fa-envelope"></i><a href="mailto:info@example.com">info@example.com</a>
                        </div>
                        <div class="c-row">
                            <i class="fa-solid fa-location-dot"></i> Dahab , Egypt
                        </div>
                    </div>

                    <div class="socials mt-3" aria-label="Social links">
                        <a href="https://www.facebook.com/share/16hqeN7ZB9/" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/dahab.dream.tour?igsh=Y29sd292bm1xZnMx" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom -->
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <div class="copyright">
                <small>&copy; 2025 Dahab Dream. All rights reserved.</small>
                <!-- <small>&copy; 2025 Ahmed Ibrahime All rights reserved.</small> -->
            </div>
            <div class="footer-meta">
                <div class="payments">
                    <img src="{{ asset('assets/img/pay-visa.webp') }}" alt="Visa" />
                </div>
                <div class="legal">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </div>
</footer>
