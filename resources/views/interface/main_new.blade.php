@extends('layouts.interface')

@section('title', 'Sun & Sea Tours — Egypt Trips')
@section('description', 'Book trips to Hurghada, Sharm El-Sheikh, and Ain Sokhna. Easy booking, fair prices, trusted by travelers.')

@section('content')
<!-- Hero -->
<section id="hero" class="hero-section position-relative text-white text-center">
    <img src="{{ asset('assets/img/hero.jpg') }}" class="hero-bg" alt="Beach" />
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
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-1">{{ __('interface.popular_trips.title') }}</h2>
            <p class="text-muted fs-5">{{ __('interface.popular_trips.subtitle') }}</p>
        </div>

        <div class="swiper trips-swiper">
            <div class="swiper-wrapper">
                @foreach($popularTours as $tour)
                <div class="swiper-slide">
                    <a href="{{ route('interface.details', $tour->id) }}" class="text-decoration-none">
                        <div class="card trip-card shadow-lg border-0 h-100 rounded-4 overflow-hidden">
                            <div class="trip-img-wrapper position-relative">
                                <img
                                    src="{{ is_array($tour->image) ? asset($tour->image[0]) : asset($tour->image) }}"
                                    class="card-img-top fixed-img"
                                    alt="{{ $tour->getTranslatedTitle() }}" />
                                @if($tour->is_popular)
                                    <span class="trip-badge">{{ __('interface.popular') }}</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark mb-1">
                                    {{ $tour->getTranslatedTitle() }}
                                </h5>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($tour->rating ?? 4))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($tour->getTranslatedDescription(), 100) }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($tour->ratePlans->isNotEmpty())
                                            <span class="price fw-bold text-primary fs-5">
                                                ${{ number_format($tour->ratePlans->first()->price, 0) }}
                                            </span>
                                            <small class="text-muted"> / per person</small>
                                        @endif
                                    </div>
                                    <span class="btn btn-primary btn-sm px-3 fw-semibold">
                                        {{ __('interface.nav.book_now') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- Latest Tours -->
<section id="latest" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold fs-1">{{ __('interface.latest.title') }}</h2>
            <p class="text-muted fs-5">{{ __('interface.latest.subtitle') }}</p>
        </div>

        <div class="swiper latest-tours-swiper">
            <div class="swiper-wrapper">
                @foreach($popularTours->take(6) as $tour)
                <div class="swiper-slide">
                    <a href="{{ route('interface.details', $tour->id) }}" class="text-decoration-none">
                        <div class="card trip-card shadow-lg border-0 h-100 rounded-4 overflow-hidden">
                            <div class="trip-img-wrapper position-relative">
                                <img
                                    src="{{ is_array($tour->image) ? asset($tour->image[0]) : asset($tour->image) }}"
                                    class="card-img-top fixed-img"
                                    alt="{{ $tour->getTranslatedTitle() }}" />
                                <span class="trip-badge">{{ __('interface.new') }}</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark mb-1">
                                    {{ $tour->getTranslatedTitle() }}
                                </h5>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= ($tour->rating ?? 4))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($tour->getTranslatedDescription(), 80) }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($tour->ratePlans->isNotEmpty())
                                            <span class="price fw-bold text-primary fs-5">
                                                ${{ number_format($tour->ratePlans->first()->price, 0) }}
                                            </span>
                                            <small class="text-muted"> / per person</small>
                                        @endif
                                    </div>
                                    <span class="btn btn-primary btn-sm px-3 fw-semibold">
                                        {{ __('interface.nav.book_now') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-5 bg-light">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">{{ __('interface.testimonials.title') }}</h2>
            <p class="text-muted mb-0">
                {{ __('interface.testimonials.subtitle') }}
            </p>
        </div>

        <!-- Testimonials Swiper -->
        <div class="swiper t-swiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
                <!-- Testimonial 1 -->
                <div class="swiper-slide">
                    <div class="testimonial-card text-center p-4 bg-white rounded-4 shadow-sm">
                        <div class="testimonial-avatar mb-3">
                            <img
                                src="{{ asset('assets/img/testimonial-1.jpg') }}"
                                alt="Sarah Johnson"
                                class="rounded-circle"
                                width="80"
                                height="80" />
                        </div>
                        <div class="stars text-warning mb-3">★★★★★</div>
                        <p class="testimonial-text text-muted mb-3">
                            "Amazing experience! The trip to Hurghada was perfectly organized. Great hotels, beautiful beaches, and excellent service."
                        </p>
                        <h6 class="testimonial-name fw-bold mb-1">Sarah Johnson</h6>
                        <small class="text-muted">Hurghada Trip, March 2024</small>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="swiper-slide">
                    <div class="testimonial-card text-center p-4 bg-white rounded-4 shadow-sm">
                        <div class="testimonial-avatar mb-3">
                            <img
                                src="{{ asset('assets/img/testimonial-2.jpg') }}"
                                alt="Ahmed Hassan"
                                class="rounded-circle"
                                width="80"
                                height="80" />
                        </div>
                        <div class="stars text-warning mb-3">★★★★★</div>
                        <p class="testimonial-text text-muted mb-3">
                            "Fantastic family vacation! Kids loved the beach and activities. Highly recommend Sun & Sea Tours."
                        </p>
                        <h6 class="testimonial-name fw-bold mb-1">Ahmed Hassan</h6>
                        <small class="text-muted">Sharm El-Sheikh Trip, February 2024</small>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="swiper-slide">
                    <div class="testimonial-card text-center p-4 bg-white rounded-4 shadow-sm">
                        <div class="testimonial-avatar mb-3">
                            <img
                                src="{{ asset('assets/img/testimonial-3.jpg') }}"
                                alt="Maria Schmidt"
                                class="rounded-circle"
                                width="80"
                                height="80" />
                        </div>
                        <div class="stars text-warning mb-3">★★★★★</div>
                        <p class="testimonial-text text-muted mb-3">
                            "Professional service and great value for money. The Ain Sokhna trip exceeded our expectations!"
                        </p>
                        <h6 class="testimonial-name fw-bold mb-1">Maria Schmidt</h6>
                        <small class="text-muted">Ain Sokhna Trip, January 2024</small>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="py-5 position-relative">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4">Ready to Book Your Trip?</h2>
                <p class="text-muted mb-4">
                    Contact us now and let's plan your perfect Red Sea vacation. We're here to help 24/7.
                </p>

                <div class="contact-info">
                    <div class="contact-item d-flex align-items-center mb-3">
                        <div class="contact-icon me-3">
                            <i class="fas fa-phone text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Phone</h6>
                            <a href="tel:+201000000000" class="text-decoration-none">+20 100 000 0000</a>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-center mb-3">
                        <div class="contact-icon me-3">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Email</h6>
                            <a href="mailto:info@example.com" class="text-decoration-none">info@example.com</a>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-center mb-4">
                        <div class="contact-icon me-3">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Location</h6>
                            <span>Mit Abid, Egypt</span>
                        </div>
                    </div>

                    <a href="tel:+201000000000" class="btn btn-primary btn-lg">
                        <i class="fas fa-phone me-2"></i>Call Now
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="contact-map bg-light rounded-4 p-3">
                    <img
                        src="{{ asset('assets/img/map-placeholder.webp') }}"
                        alt="Map"
                        class="w-100"
                        style="height: 180px; object-fit: cover" />
                </div>
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

    // Initialize popular trips swiper
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
