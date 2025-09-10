@extends('layouts.interface')

@section('title', 'Sun & Sea Tours — Egypt Trips')
@section('description', 'Book trips to Hurghada, Sharm El-Sheikh, and Ain Sokhna. Easy booking, fair prices, trusted by travelers.')

@section('content')

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />

    <!-- Swiper -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

    <!-- Icons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
    <!-- Navbar -->
    <header class="navbar-wrapper fixed-top shadow-sm">
        <nav class="navbar navbar-expand-lg py-2 bg-white">
            <div class="container">
                <!-- Logo -->
                <a
                    class="navbar-brand fw-bold d-flex align-items-center me-4"
                    href="#">
                    <img src="assets/img/logo.png" alt="Logo" width="48" class="me-2" />
                    <span class="brand-text text-primary">Sun & Sea Tours</span>
                </a>

                <!--  Language Dropdown (قبل أيقونة النافبار) -->
                <div class="dropdown d-lg-none me-2">
                    <button
                        class="btn btn-outline-primary dropdown-toggle d-flex align-items-center"
                        type="button"
                        id="languageDropdownMobile"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-globe me-1"></i>
                        <span class="d-none d-sm-inline">{{ strtoupper($locale ?? 'en') }}</span>
                    </button>
                    <ul
                        class="dropdown-menu dropdown-menu-end shadow-sm"
                        aria-labelledby="languageDropdownMobile">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}">English</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'de']) }}">Deutsch</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'fr']) }}">Français</a></li>
                    </ul>
                </div>

                <!-- Toggler -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#nav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links -->
                <div id="nav" class="collapse navbar-collapse">
                    <!-- Left side (links) -->
                    <ul class="navbar-nav ms-0 me-auto">
                        <li class="nav-item">
                            <a href="#hero" class="nav-link active" data-i18n="nav.home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#destinations" class="nav-link" data-i18n="nav.trips">Trips</a>
                        </li>
                        <li class="nav-item">
                            <a href="#popular" class="nav-link" data-i18n="nav.popular">Popular</a>
                        </li>
                        <li class="nav-item">
                            <a href="#testimonials" class="nav-link" data-i18n="nav.testimonials">Testimonials</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="nav-link" data-i18n="nav.contact">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Right side (desktop language + CTA) -->
                <div class="d-none d-lg-flex align-items-center ms-auto">
                    <!-- Language Dropdown Desktop -->
                    <div class="dropdown me-2">
                        <button
                            class="btn btn-outline-primary dropdown-toggle d-flex align-items-center"
                            type="button"
                            id="languageDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-globe me-1"></i>
                            <span class="d-none d-sm-inline language-display">{{ strtoupper($locale ?? 'en') }}</span>
                        </button>
                        <ul
                            class="dropdown-menu dropdown-menu-end shadow-sm"
                            aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'de']) }}">Deutsch</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'fr']) }}">Français</a></li>
                        </ul>
                    </div>

                    <!-- CTA -->
                    <!-- <a href="#contact" class="btn btn-cta ms-2">Book Now</a> -->
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero -->
        <section
            id="hero"
            class="hero-section position-relative text-white text-center">
            <img src="assets/img/hero.jpg" class="hero-bg" alt="Beach" />
            <div class="hero-content container mt-5 pt-5">
                <h1 class="display-4 fw-bold mt-5">{{ __('interface.hero.title') }}</h1>
                <p class="lead mb-4">
                    {{ __('interface.hero.subtitle') }}
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#contact" class="btn btn-primary btn-lg">{{ __('interface.hero.book_now') }}</a>
                    <a href="#destinations" class="btn btn-outline-light btn-lg">{{ __('interface.hero.explore_trips') }}</a>
                </div>
            </div>
        </section>
        <!-- Destinations -->
        <section id="destinations" class="py-5 container">
            <div class="text-center mb-5">
                <h2 class="fw-bold fs-1">{{ __('interface.destinations.title') }}</h2>
                <p class="text-muted fs-5">{{ __('interface.destinations.subtitle') }}</p>
            </div>

            <div class="row g-4">
                @foreach($destinations as $destination)
                <div class="col-md-4">
                    <div class="destination-section mb-4">
                        <!-- Destination Card -->
                        <a
                            href="{{ route('interface.tours', $destination->slug) }}"
                            class="card destination-card border-0 shadow-sm text-decoration-none">
                            <div class="image-wrapper">
                                <img
                                    src="{{ asset($destination->image) }}"
                                    class="card-img-top"
                                    alt="{{ $destination->getTranslatedName() }}" />
                                <div class="overlay">
                                    <h4 class="overlay-text">{{ $destination->getTranslatedName() }} {{ __('Trips') }}</h4>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Popular Trips (Swiper) -->
        <section id="popular" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold text-primary">{{ __('interface.popular_trips.title') }}</h2>
                    <p class="text-muted">
                        {{ __('interface.popular_trips.subtitle') }}
                    </p>
                </div>

                <div class="swiper trips-swiper">
                    <div class="swiper-wrapper">
                        @foreach($popularTours as $tour)
                        <div class="swiper-slide">
                            <div class="card trip-card shadow-sm border-0 h-100">
                                <div class="trip-img-wrapper">
                                    @php
                                        $images = is_array($tour->image) ? $tour->image : [$tour->image];
                                        $firstImage = $images[0] ?? 'assets/images/default-tour.jpg';
                                    @endphp
                                    <img src="{{ $firstImage }}" class="card-img-top fixed-img" alt="{{ $tour->getTranslatedTitle() }}" />
                                    <span class="trip-badge">{{ __('interface.popular') }}</span>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">{{ $tour->getTranslatedTitle() }}</h5>
                                    <p class="card-text text-muted mb-2">{{ Str::limit($tour->getTranslatedDescription(), 60) }}</p>
                                    @if($tour->ratePlans->count() > 0)
                                        <p class="price fw-bold text-primary">${{ $tour->ratePlans->first()->price }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Swiper Controls -->
                    <div class="swiper-pagination mt-3"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimonials" class="py-5 position-relative">
            <div class="container">
                <!-- Header -->
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold" data-i18n="testimonials.title">What Our Clients Say</h2>
                    <p class="text-muted mb-0" data-i18n="testimonials.subtitle">
                        Real travelers. Real stories. Verified reviews.
                    </p>
                </div>

                <div class="row g-4 align-items-start">
                    <!-- Left: Rating Summary / Trust -->
                    <div class="col-lg-4" data-aos="fade-right">
                        <div class="t-summary p-4 rounded-4 shadow-sm bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="display-5 fw-bold me-3 text-primary">4.9</div>
                                <div>
                                    <div
                                        class="t-stars small mb-1"
                                        aria-label="Rating: 4.9 out of 5">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                    </div>
                                    <small class="text-muted" data-i18n="testimonials.basedOn">Based on 1,240 reviews</small>
                                </div>
                            </div>

                            <hr class="my-3" />

                            <div class="d-grid gap-2">
                                <div
                                    class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted" data-i18n="testimonials.service">Service</span>
                                    <div class="t-bar"><span style="width: 95%"></span></div>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted" data-i18n="testimonials.value">Value</span>
                                    <div class="t-bar"><span style="width: 92%"></span></div>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between">
                                    <span class="text-muted" data-i18n="testimonials.organization">Organization</span>
                                    <div class="t-bar"><span style="width: 96%"></span></div>
                                </div>
                            </div>

                            <div class="mt-4 d-flex flex-wrap gap-2">
                                <span class="badge t-badge"><i class="fa-solid fa-shield-check me-1"></i> <span data-i18n="testimonials.verifiedAgency">Verified
                                        Agency</span></span>
                                <span class="badge t-badge"><i class="fa-solid fa-globe me-1"></i> <span data-i18n="testimonials.redSeaTrips">Red Sea Trips</span></span>
                                <span class="badge t-badge"><i class="fa-regular fa-clock me-1"></i> <span data-i18n="testimonials.support24">24/7 Support</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Testimonials Slider -->
                    <div class="col-lg-8" data-aos="fade-left">
                        <div class="swiper t-swiper">
                            <div class="swiper-wrapper">
                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <article class="t-card rounded-4 shadow-sm bg-white">
                                        <header class="d-flex align-items-center">
                                            <img
                                                src="assets/img/clients/ahmed.jpg"
                                                alt="Ahmed"
                                                class="t-avatar" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bold">Ahmed M.</h6>
                                                <small class="text-muted">Cairo • Hurghada Adventure</small>
                                            </div>
                                            <span class="ms-auto chip-verified"><i class="fa-solid fa-circle-check me-1"></i>Verified
                                                Traveler</span>
                                        </header>

                                        <div class="t-stars mt-3" aria-hidden="true">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>

                                        <p class="t-text mt-3">
                                            “Everything was smooth & professional. Snorkeling was
                                            breathtaking and the team was super helpful. Highly
                                            recommended!”
                                        </p>

                                        <footer
                                            class="d-flex align-items-center justify-content-between mt-3">
                                            <span class="t-trip-tag"><i class="fa-solid fa-location-dot me-1"></i>
                                                Hurghada • 4D/3N</span>
                                            <small class="text-muted">June 2025</small>
                                        </footer>
                                    </article>
                                </div>

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <article class="t-card rounded-4 shadow-sm bg-white">
                                        <header class="d-flex align-items-center">
                                            <img
                                                src="assets/img/clients/sara.jpg"
                                                alt="Sara"
                                                class="t-avatar" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bold">Sara K.</h6>
                                                <small class="text-muted">Giza • Sharm Deluxe</small>
                                            </div>
                                            <span class="ms-auto chip-verified"><i class="fa-solid fa-circle-check me-1"></i>Verified
                                                Traveler</span>
                                        </header>

                                        <div class="t-stars mt-3">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star-half-stroke"></i>
                                        </div>

                                        <p class="t-text mt-3">
                                            “Great value and perfectly organized itinerary. Hotel
                                            choice and transfers were spot on. Will book again!”
                                        </p>

                                        <footer
                                            class="d-flex align-items-center justify-content-between mt-3">
                                            <span class="t-trip-tag"><i class="fa-solid fa-location-dot me-1"></i> Sharm •
                                                5D/4N</span>
                                            <small class="text-muted">May 2025</small>
                                        </footer>
                                    </article>
                                </div>

                                <!-- Slide -->
                                <div class="swiper-slide">
                                    <article class="t-card rounded-4 shadow-sm bg-white">
                                        <header class="d-flex align-items-center">
                                            <img
                                                src="assets/img/clients/omar.jpg"
                                                alt="Omar"
                                                class="t-avatar" />
                                            <div class="ms-3">
                                                <h6 class="mb-0 fw-bold">Omar A.</h6>
                                                <small class="text-muted">Alexandria • Sokhna Escape</small>
                                            </div>
                                            <span class="ms-auto chip-verified"><i class="fa-solid fa-circle-check me-1"></i>Verified
                                                Traveler</span>
                                        </header>

                                        <div class="t-stars mt-3">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                            <i class="fa-regular fa-star"></i>
                                        </div>

                                        <p class="t-text mt-3">
                                            “Family trip done right. Kids loved the beach day & boat
                                            ride. Friendly crew and clean buses.”
                                        </p>

                                        <footer
                                            class="d-flex align-items-center justify-content-between mt-3">
                                            <span class="t-trip-tag"><i class="fa-solid fa-location-dot me-1"></i> Ain
                                                Sokhna • 3D/2N</span>
                                            <small class="text-muted">April 2025</small>
                                        </footer>
                                    </article>
                                </div>
                            </div>

                            <!-- Controls -->
                            <div class="swiper-pagination mt-3"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- decorative soft gradient -->
            <div class="t-bg"></div>
        </section>

        <!-- Contact (upgraded) -->
        <section id="contact" class="py-5 position-relative">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold text-primary">{{ __('interface.latest.title') }}</h2>
                    <p class="text-muted">
                        {{ __('interface.latest.subtitle') }}
                    </p>
                </div>

                <div class="row g-4 align-items-center mt-4">
                    <!-- Left: Contact Info -->
                    <div class="col-lg-5" data-aos="fade-right">
                        <div class="contact-card p-4 rounded-4 shadow-sm bg-white h-100">
                            <h5 class="fw-bold mb-3" data-i18n="contact.getInTouch">Get in touch</h5>

                            <p class="text-muted mb-3" data-i18n="contact.description">
                                Call us, send a message or fill the booking form and our
                                travel expert will contact you within 24 hours.
                            </p>

                            <div class="mb-3 d-flex align-items-start">
                                <i class="fa-solid fa-phone fa-lg text-primary me-3"></i>
                                <div>
                                    <div class="small text-muted" data-i18n="contact.phone">Phone</div>
                                    <a
                                        href="tel:+201000000000"
                                        class="d-block fw-semibold text-dark">+20 100 000 0000</a>
                                </div>
                            </div>

                            <div class="mb-3 d-flex align-items-start">
                                <i class="fa-solid fa-envelope fa-lg text-primary me-3"></i>
                                <div>
                                    <div class="small text-muted" data-i18n="contact.email">Email</div>
                                    <a
                                        href="mailto:info@example.com"
                                        class="d-block fw-semibold text-dark">info@example.com</a>
                                </div>
                            </div>

                            <div class="mb-3 d-flex align-items-start">
                                <i
                                    class="fa-solid fa-location-dot fa-lg text-primary me-3"></i>
                                <div>
                                    <div class="small text-muted" data-i18n="contact.office">Office</div>
                                    <div class="fw-semibold text-dark">Mit Abid, Egypt</div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="small text-muted mb-2" data-i18n="contact.openingHours">Opening Hours</div>
                                <div class="d-flex gap-3 flex-wrap">
                                    <span class="badge hour-badge">Mon–Fri: 08:00–18:00</span>
                                    <span class="badge hour-badge">Sat: 09:00–14:00</span>
                                    <span class="badge hour-badge">Sun: Closed</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-outline-primary w-100" id="callNowBtn">
                                    <i class="fa-solid fa-phone me-2"></i><span data-i18n="contact.callNow">Call Now</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Booking Form -->
                    <div class="col-lg-7" data-aos="fade-left">
                        <div class="booking-card p-4 rounded-4 shadow-sm bg-white">
                            <form id="bookingForm" class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted" data-i18n="contact.fullName">Full name</label>
                                    <input
                                        required
                                        type="text"
                                        class="form-control form-control-lg"
                                        name="name"
                                        placeholder="Your full name"
                                        data-i18n-placeholder="contact.yourFullName" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-muted" data-i18n="contact.phone">Phone</label>
                                    <input
                                        required
                                        type="tel"
                                        class="form-control form-control-lg"
                                        name="phone"
                                        placeholder="+20 1xx xxx xxxx" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-muted" data-i18n="contact.emailOptional">Email (optional)</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        placeholder="you@example.com" />
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small text-muted" data-i18n="contact.destination">Destination</label>
                                    <select
                                        required
                                        class="form-select form-select-lg"
                                        name="destination">
                                        <option value="" disabled selected data-i18n="contact.chooseDestination">
                                            Choose a destination
                                        </option>
                                        <option value="hurghada">Hurghada</option>
                                        <option value="sharm">Sharm El-Sheikh</option>
                                        <option value="sokhna">Ain Sokhna</option>
                                        <option value="daahab">Dahab</option>
                                        <option value="others">Other</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small text-muted" data-i18n="contact.adults">Adults</label>
                                    <input
                                        required
                                        type="number"
                                        min="1"
                                        class="form-control"
                                        name="adults"
                                        value="2" />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small text-muted" data-i18n="contact.children">Children</label>
                                    <input
                                        type="number"
                                        min="0"
                                        class="form-control"
                                        name="children"
                                        value="0" />
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label small text-muted" data-i18n="contact.preferredDate">Preferred date</label>
                                    <input
                                        required
                                        type="date"
                                        class="form-control"
                                        name="date" />
                                </div>

                                <div class="col-12">
                                    <label class="form-label small text-muted" data-i18n="contact.notes">Notes</label>
                                    <textarea
                                        name="notes"
                                        rows="3"
                                        class="form-control"
                                        placeholder="Any special requests (hotel standard, transfer, food...)"
                                        data-i18n-placeholder="contact.specialRequests"></textarea>
                                </div>

                                <div class="col-12 d-flex gap-3 align-items-center">
                                    <button type="submit" class="btn btn-cta btn-lg" data-i18n="contact.requestBooking">
                                        Request Booking
                                    </button>
                                    <div class="text-muted small">
                                        <span data-i18n="contact.or">Or</span>
                                        <a href="tel:+201000000000" class="fw-semibold" data-i18n="contact.callUs">call us</a>
                                        <span data-i18n="contact.bookInstantly">to book instantly</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div
                                        id="bookingAlert"
                                        class="alert d-none mb-0"
                                        role="alert"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Optional map / decorative -->
                <div class="mt-4">
                    <div class="map-placeholder rounded-4 overflow-hidden shadow-sm">
                        <!-- Put your iframe map here (Google Maps / OpenStreetMap). Placeholder image for now -->
                        <img
                            src="assets/img/map-placeholder.webp"
                            alt="Map"
                            class="w-100"
                            style="height: 180px; object-fit: cover" />
                    </div>
                </div>
            </div>
            <!-- soft decorative background -->
            <div class="contact-bg"></div>
        </section>
@endsection

@section('scripts')
<script>
    // Initialize AOS
    AOS.init({
        duration: 600,
        once: true
    });

    // Initialize latest tours swiper (existing popular section)
    new Swiper('.trips-swiper', {
        slidesPerView: 3,
        spaceBetween: 20,
        pagination: {
            el: '.trips-swiper .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.trips-swiper .swiper-button-next',
            prevEl: '.trips-swiper .swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });

    // Initialize latest tours swiper
    new Swiper('.latest-tours-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '.latest-tours-swiper .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.latest-tours-swiper .swiper-button-next',
            prevEl: '.latest-tours-swiper .swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
        autoplay: {
            delay: 4500,
            disableOnInteraction: false,
        },
    });

    // Initialize main popular trips swiper
    new Swiper('.trips-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '.trips-swiper .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.trips-swiper .swiper-button-next',
            prevEl: '.trips-swiper .swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
    });

    // Initialize testimonials swiper
    new Swiper('.t-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
            el: '.t-swiper .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.t-swiper .swiper-button-next',
            prevEl: '.t-swiper .swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
</script>
@endsection

</html>