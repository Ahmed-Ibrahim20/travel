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
                <!-- Destination Card - triggers modal -->
                <button
                    type="button"
                    class="card destination-card border-0 shadow-sm text-start p-0 btn-open-types"
                    data-bs-toggle="modal"
                    data-bs-target="#typeModal"
                    data-slug="{{ $destination->slug }}"
                    data-name="{{ $destination->getTranslatedName() }}"
                    aria-label="{{ $destination->getTranslatedName() }}">
                    <div class="image-wrapper position-relative">
                        <img
                            src="{{ asset($destination->image) }}"
                            class="card-img-top"
                            alt="{{ $destination->getTranslatedName() }}" style="height:220px; object-fit:cover;" />
                        <div class="overlay d-flex align-items-end p-3">
                            <h4 class="overlay-text text-white m-0">{{ $destination->getTranslatedName() }} {{ __('Trips') }}</h4>
                        </div>
                    </div>
                </button>
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
            <div class="swiper-wrapper" style="height: auto;">
                @foreach($popularTours as $tour)
                <div class="swiper-slide" style="height: fit-content;">
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
                                        @if($i <=($tour->rating ?? 4))
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
                      aria-label="Rating: 4.9 out of 5"
                    >
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
                    class="d-flex align-items-center justify-content-between"
                  >
                    <span class="text-muted" data-i18n="testimonials.service">Service</span>
                    <div class="t-bar"><span style="width: 95%"></span></div>
                  </div>
                  <div
                    class="d-flex align-items-center justify-content-between"
                  >
                    <span class="text-muted" data-i18n="testimonials.value">Value</span>
                    <div class="t-bar"><span style="width: 92%"></span></div>
                  </div>
                  <div
                    class="d-flex align-items-center justify-content-between"
                  >
                    <span class="text-muted" data-i18n="testimonials.organization">Organization</span>
                    <div class="t-bar"><span style="width: 96%"></span></div>
                  </div>
                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
                  <span class="badge t-badge"
                    ><i class="fa-solid fa-shield-check me-1"></i> <span data-i18n="testimonials.verifiedAgency">Verified
                    Agency</span></span
                  >
                  <span class="badge t-badge"
                    ><i class="fa-solid fa-globe me-1"></i> <span data-i18n="testimonials.redSeaTrips">Red Sea Trips</span></span
                  >
                  <span class="badge t-badge"
                    ><i class="fa-regular fa-clock me-1"></i> <span data-i18n="testimonials.support24">24/7 Support</span></span
                  >
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
                          src="{{ asset('assets/img/main.jpg') }}"
                          alt="Ahmed"
                          class="t-avatar"
                        />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bold">Ahmed M.</h6>
                          <small class="text-muted"
                            >Cairo • Hurghada Adventure</small
                          >
                        </div>
                        <span class="ms-auto chip-verified"
                          ><i class="fa-solid fa-circle-check me-1"></i>Verified
                          Traveler</span
                        >
                      </header>

                      <div class="t-stars mt-3" aria-hidden="true">
                        <i class="fa-solid fa-star"></i
                        ><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i
                        ><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                      </div>

                      <p class="t-text mt-3">
                        “Everything was smooth & professional. Snorkeling was
                        breathtaking and the team was super helpful. Highly
                        recommended!”
                      </p>

                      <footer
                        class="d-flex align-items-center justify-content-between mt-3"
                      >
                        <span class="t-trip-tag"
                          ><i class="fa-solid fa-location-dot me-1"></i>
                          Hurghada • 4D/3N</span
                        >
                        <small class="text-muted">June 2025</small>
                      </footer>
                    </article>
                  </div>

                  <!-- Slide -->
                  <div class="swiper-slide">
                    <article class="t-card rounded-4 shadow-sm bg-white">
                      <header class="d-flex align-items-center">
                        <img
                          src="{{ asset('assets/img/woman.jpg') }}"
                          alt="Sara"
                          class="t-avatar"
                        />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bold">Sara K.</h6>
                          <small class="text-muted">Giza • Sharm Deluxe</small>
                        </div>
                        <span class="ms-auto chip-verified"
                          ><i class="fa-solid fa-circle-check me-1"></i>Verified
                          Traveler</span
                        >
                      </header>

                      <div class="t-stars mt-3">
                        <i class="fa-solid fa-star"></i
                        ><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i
                        ><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                      </div>

                      <p class="t-text mt-3">
                        “Great value and perfectly organized itinerary. Hotel
                        choice and transfers were spot on. Will book again!”
                      </p>

                      <footer
                        class="d-flex align-items-center justify-content-between mt-3"
                      >
                        <span class="t-trip-tag"
                          ><i class="fa-solid fa-location-dot me-1"></i> Sharm •
                          5D/4N</span
                        >
                        <small class="text-muted">May 2025</small>
                      </footer>
                    </article>
                  </div>

                  <!-- Slide -->
                  <div class="swiper-slide">
                    <article class="t-card rounded-4 shadow-sm bg-white">
                      <header class="d-flex align-items-center">
                        <img
                          src="{{ asset('assets/img/slide-2.png') }}"
                          alt="Omar"
                          class="t-avatar"
                        />
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bold">Omar A.</h6>
                          <small class="text-muted"
                            >Alexandria • Sokhna Escape</small
                          >
                        </div>
                        <span class="ms-auto chip-verified"
                          ><i class="fa-solid fa-circle-check me-1"></i>Verified
                          Traveler</span
                        >
                      </header>

                      <div class="t-stars mt-3">
                        <i class="fa-solid fa-star"></i
                        ><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i
                        ><i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                      </div>

                      <p class="t-text mt-3">
                        “Family trip done right. Kids loved the beach day & boat
                        ride. Friendly crew and clean buses.”
                      </p>

                      <footer
                        class="d-flex align-items-center justify-content-between mt-3"
                      >
                        <span class="t-trip-tag"
                          ><i class="fa-solid fa-location-dot me-1"></i> Ain
                          Sokhna • 3D/2N</span
                        >
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




<!-- Modal: Choose Tour Type -->
<div class="modal fade" id="typeModal" tabindex="-1" aria-labelledby="typeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            
            <!-- Header -->
            <div class="modal-header border-0 bg-gradient py-3 px-4">
                <h5 class="modal-title fw-bold text-white mb-0" id="typeModalLabel">
                    <!-- سيتم تحديثه من JS -->
                </h5>
                <button type="button" class="btn-close text-dark bg-dark" style="color: black !important;" data-bs-dismiss="modal"
                    aria-label="{{ __('interface.modals.close') }}"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <p class="text-muted mb-4 fs-6" id="typeModalSub"></p>

                <div class="row g-4">
                    <!-- HOTEL -->
                    <div class="col-md-4">
                        <a href="#" class="type-select-link" data-type="hotel">
                            <div class="tour-card h-100">
                                <div class="tour-image">
                                    <img src="{{ asset('assets/images/hotel-presidente.jpg') }}" alt="{{ __('interface.types.hotel') }}">
                                    <div class="overlay"></div>
                                </div>
                                <div class="tour-content text-center">
                                    <h6 class="fw-bold">{{ __('interface.types.hotel') }}</h6>
                                    <p class="small text-muted">{{ __('interface.types.hotel_desc') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- HONEYMOON -->
                    <div class="col-md-4">
                        <a href="#" class="type-select-link" data-type="honeymoon">
                            <div class="tour-card h-100">
                                <div class="tour-image">
                                    <img src="{{ asset('assets/images/HONEYMOON.jpg') }}" alt="{{ __('interface.types.honeymoon') }}">
                                    <div class="overlay"></div>
                                </div>
                                <div class="tour-content text-center">
                                    <h6 class="fw-bold">{{ __('interface.types.honeymoon') }}</h6>
                                    <p class="small text-muted">{{ __('interface.types.honeymoon_desc') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- TRIP -->
                    <div class="col-md-4">
                        <a href="#" class="type-select-link" data-type="trip">
                            <div class="tour-card h-100">
                                <div class="tour-image">
                                    <img src="{{ asset('assets/images/trips.jpg') }}" alt="{{ __('interface.types.trip') }}">
                                    <div class="overlay"></div>
                                </div>
                                <div class="tour-content text-center">
                                    <h6 class="fw-bold">{{ __('interface.types.trip') }}</h6>
                                    <p class="small text-muted">{{ __('interface.types.trip_desc') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

<!-- Store translation data for JavaScript -->
<!-- <div id="modal-data"
    data-url-template="{{ url('/interface/tours') }}/__SLUG__/__TYPE__"
    data-title-template="{{ __('interface.modals.select_type_title') }}"
    data-sub-template="{{ __('interface.modals.choose') }}"
    style="display: none;"></div> -->

@section('scripts')
<script>
    // Initialize AOS + Swipers (as before)...
    AOS.init({ duration: 600, once: true });

    // modal wiring
document.addEventListener('DOMContentLoaded', function () {
    const urlTemplate = @json(url('/interface/tours/__SLUG__/__TYPE__'));
    const subTemplate = @json(__('interface.modals.choose')); // "اختر ما يناسبك"

    document.querySelectorAll('.btn-open-types').forEach(btn => {
        btn.addEventListener('click', function () {
            const slug = this.dataset.slug;
            const name = this.dataset.name;

            // عنوان ديناميكي
            const title = `اختر ما يناسبك في ${name}`;
            document.getElementById('typeModalLabel').textContent = title;

            // Subtitle
            document.getElementById('typeModalSub').textContent = subTemplate;

            // تحديث اللينكات
            document.querySelectorAll('#typeModal .type-select-link').forEach(a => {
                const type = a.dataset.type;
                a.setAttribute('href', urlTemplate.replace('__SLUG__', slug).replace('__TYPE__', type));
            });
        });
    });

    // highlight selection effect
    document.querySelectorAll('#typeModal .tour-card').forEach(card => {
        card.addEventListener('click', function () {
            document.querySelectorAll('#typeModal .tour-card').forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
});


</script>


@endsection 

@section('styles')
<style>
    /* زر الإغلاق يبقى دايمًا ظاهر */
.modal-header .btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: 0.9;
}

.modal-header .btn-close:hover {
    opacity: 1;
}

/* العنوان يبقى واضح */
#typeModalLabel {
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff !important;
}

    /* مودال الهيدر بخلفية عصرية */
.bg-gradient {
    background: linear-gradient(135deg, #4a90e2, #6c63ff);
}

/* ستايل الكروت */
.tour-card {
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
}

.tour-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}

/* صورة الكارت */
.tour-image {
    position: relative;
    height: 160px;
    overflow: hidden;
}

.tour-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: scale 0.4s ease;
}

.tour-card:hover img {
    transform: scale(1.05);
}

/* Overlay عشان يخلي الصورة احترافية */
.tour-image .overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.35);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.tour-card:hover .overlay {
    opacity: 1;
}

/* محتوى الكارت */
.tour-content {
    padding: 15px;
    transition: color 0.3s ease;
}

.tour-card:hover .tour-content h6 {
    color: #4a90e2;
}

/* لما اختار كارت */
.tour-card.selected {
    border: 2px solid #4a90e2;
    box-shadow: 0 0 12px rgba(74,144,226,0.5);
}

    /**end */
    .destination-card {
        cursor: pointer;
        border-radius: 12px;
        overflow: hidden;
    }

    .destination-card .overlay {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 1rem;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.45) 60%);
    }

    .trip-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ff6b6b;
        color: #fff;
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 600;
    }

    /* modal cards */
    .type-select-link .card {
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .type-select-link .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
</style>
@endsection