  @extends('layouts.interface')

  @section('title', ($tour->getTranslatedTitle() ?? 'Tour Details') . ' — Sun & Sea Tours')
  @section('description', ($tour->getTranslatedDescription() ?? 'Trip details, gallery, packages & book now. Sun & Sea Tours'))

  @section('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/details.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/booking-modal.css') }}" />
  @endsection

  @section('content')

  <!-- HERO -->
  <section class="hero mt-5">
    <div class="container container-lg text-white" data-aos="fade-up">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="mb-2">
            <span class="badge-location"><i class="fa-solid fa-location-dot"></i> {{ $tour->destination->getTranslatedName() }}</span>
          </div>
          <h1>{{ $tour->getTranslatedTitle() }}</h1>
          <p class="lead">
            {{ $tour->getTranslatedDescription() }}
          </p>

          <div class="d-flex gap-3">
            <a
              href="#packages"
              class="btn btn-custom btn-lg"
              onclick="document.querySelector('#packages').scrollIntoView({behavior:'smooth'})">View Packages</a>
            <button
              class="btn btn-outline-light btn-lg"
              onclick="openBookingQuick('default')">
              Book Now
            </button>
          </div>
        </div>

        <div class="col-lg-4 d-none d-lg-block text-end">
          <div
            class="bg-white p-3 rounded-4 shadow-sm"
            style="display: inline-block">
            <div class="small muted">Rating</div>
            <div class="h4 mb-0 text-primary-strong">
              {{ $tour->rating ?? 4.0 }}
              <small class="text-warning ms-2">
                @for($i = 1; $i <= 5; $i++)
                  @if($i <=($tour->rating ?? 4))
                  ★
                  @else
                  ☆
                  @endif
                  @endfor
              </small>
            </div>
            <div class="muted small mt-2">From {{ $tour->capacity ?? 100 }}+ capacity</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MAIN CONTENT -->
  <main class="container container-lg py-5">
    <div class="row g-4">
      <!-- LEFT: Gallery + Hotel Info + Packages -->
      <div class="col-lg-8">
        <!-- Gallery -->
        <div class="gallery-card p-3 mb-4" data-aos="fade-up">
          <h5 class="mb-3">Photo Gallery</h5>

          <!-- Main swiper -->
          <div class="swiper gallery-swiper mb-3">
            <div class="swiper-wrapper">
              @if($tour->image_urls && count($tour->image_urls) > 0)
              @foreach($tour->image_urls as $image)
              <div class="swiper-slide">
                <img src="{{ $image }}" alt="{{ $tour->getTranslatedTitle() }}" />
              </div>
              @endforeach
              @else
              <div class="swiper-slide">
                <img src="{{ asset('assets/images/default-tour.jpg') }}" alt="{{ $tour->getTranslatedTitle() }}" />
              </div>
              @endif
            </div>
            <div class="swiper-pagination"></div>
          </div>

          <!-- Thumbnails -->
          <div class="swiper thumbs mt-2">
            <div class="swiper-wrapper">
              @if($tour->image_urls && count($tour->image_urls) > 0)
              @foreach($tour->image_urls as $image)
              <div class="swiper-slide">
                <img src="{{ $image }}" alt="{{ $tour->getTranslatedTitle() }}" />
              </div>
              @endforeach
              @else
              <div class="swiper-slide">
                <img src="{{ asset('assets/images/default-tour.jpg') }}" alt="{{ $tour->getTranslatedTitle() }}" />
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Hotel information -->
        <section class="hotel-info mb-4" data-aos="fade-up">
          <h3>About {{ $tour->getTranslatedTitle() }}</h3>
          <p class="lead muted">
            {{ $tour->getTranslatedDescription() }}
          </p>

          @if($tour->hotel_info)
          <div class="row mt-3">
            <div class="col-md-6">
              <h6 class="mb-2">Hotel Information</h6>
              <ul class="list-unstyled muted">
                @if(is_array($tour->hotel_info))
                @foreach($tour->hotel_info as $locale => $info)
                @if($locale == app()->getLocale() && $info)
                @if(is_string($info))
                @foreach(explode("\n", $info) as $line)
                @if(trim($line))
                <li>
                  <i class="fa-solid fa-check me-2 text-primary"></i>{{ trim($line) }}
                </li>
                @endif
                @endforeach
                @elseif(is_array($info))
                @foreach($info as $line)
                @if(trim($line))
                <li>
                  <i class="fa-solid fa-check me-2 text-primary"></i>{{ trim($line) }}
                </li>
                @endif
                @endforeach
                @else
                <li>
                  <i class="fa-solid fa-check me-2 text-primary"></i>{{ $info }}
                </li>
                @endif
                @endif
                @endforeach
                @endif
              </ul>
            </div>
            <div class="col-md-6">
              @if($tour->package_info)
              <h6 class="mb-2">Package Information</h6>
              <ul class="list-unstyled muted">
                @if(is_array($tour->package_info))
                @foreach($tour->package_info as $locale => $info)
                @if($locale == app()->getLocale() && $info)
                @if(is_string($info))
                @foreach(explode("\n", $info) as $line)
                @if(trim($line))
                <li>
                  <i class="fa-solid fa-star me-2 text-primary"></i>{{ trim($line) }}
                </li>
                @endif
                @endforeach
                @elseif(is_array($info))
                @foreach($info as $line)
                @if(trim($line))
                <li>
                  <i class="fa-solid fa-star me-2 text-primary"></i>{{ trim($line) }}
                </li>
                @endif
                @endforeach
                @else
                <li>
                  <i class="fa-solid fa-star me-2 text-primary"></i>{{ $info }}
                </li>
                @endif
                @endif
                @endforeach
                @endif
              </ul>
              @endif
            </div>
          </div>
          @endif
        </section>

        <!-- Packages / Seasonal Rates -->
        <section id="packages" class="mb-4" data-aos="fade-up">
          <h4 class="mb-3">Packages & Seasonal Rates</h4>
          <p class="muted small mb-3">
            Note: Hotel prices are subject to confirmation at booking time due
            to frequent updates by hotels. Upgrade options and child policy
            shown below.
          </p>

          <div class="row g-3">
            @forelse($tour->ratePlans as $ratePlan)
            <!-- Rate Plan Card -->
            <div class="col-md-6">
              <div class="season-card">
                <div
                  class="d-flex justify-content-between align-items-start mb-2">
                  <div>
                    <div class="text-muted small">{{ $ratePlan->getTranslatedName() }}</div>
                    <div class="rate-title">
                      @if($ratePlan->start_date && $ratePlan->end_date)
                      {{ $ratePlan->start_date->format('d M Y') }} — {{ $ratePlan->end_date->format('d M Y') }}
                      @else
                      Available Now
                      @endif
                    </div>
                  </div>
                  <div class="text-end">
                    <div class="muted small">Board</div>
                    <div class="text-primary-strong">{{ ucfirst($ratePlan->board_type ?? 'All inclusive') }}</div>
                  </div>
                </div>

                <div class="mt-2">
                  <div class="rate-row mb-2">
                    <div class="muted">{{ ucfirst($ratePlan->room_type ?? 'Standard') }} Room</div>
                    <div class="rate-price">{{ $ratePlan->formatted_price }}</div>
                  </div>
                  @if($ratePlan->transportation)
                  <div class="rate-row mb-2">
                    <div class="muted">Transportation</div>
                    <div class="text-primary">{{ ucfirst($ratePlan->transportation) }}</div>
                  </div>
                  @endif
                  @if($ratePlan->getTranslatedDetails())
                  <div class="rate-row mb-2">
                    <div class="muted small">{{ $ratePlan->getTranslatedDetails() }}</div>
                  </div>
                  @endif
                </div>

                <div
                  class="mt-3 d-flex justify-content-between align-items-center">
                  <button
                    class="btn btn-outline-primary btn-sm booking-btn"
                    data-package="{{ $ratePlan->getTranslatedName() }}"
                    data-price="{{ $ratePlan->price }}"
                    data-rate-plan-id="{{ $ratePlan->id }}">
                    Book Now
                  </button>
                  <small class="muted">{{ $ratePlan->currency ?? 'EGP' }}</small>
                </div>
              </div>
            </div>
            @empty
            <div class="col-12">
              <div class="text-center py-4">
                <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                <h5 class="text-muted">No rate plans available</h5>
                <p class="text-muted">Please contact us for custom pricing and availability.</p>
              </div>
            </div>
            @endforelse
          </div>

          <!-- Upgrades & child policy -->
          <div
            class="mt-4 p-3 rounded-3"
            style="background: #fff; border: 1px solid #eef4f7">
            <h6 class="mb-2">Upgrade Options</h6>
            <ul class="muted small mb-2">
              <li>Upgrade to Pool/Sea view room: +EGP 400 / room / night</li>
              <li>Upgrade to Sea-facing room: +EGP 500 / room / night</li>
              <li>Upgrade to Superior room: +EGP 700 / room / night</li>
            </ul>

            <h6 class="mb-2">Child Policy</h6>
            <ul class="muted small mb-0">
              <li>First child (up to 11.99 yrs): free.</li>
              <li>Second child (6 – 11.99 yrs): 50% of adult price.</li>
            </ul>
          </div>
        </section>

        <!-- Trip highlights / nature -->
        <section class="mb-4" data-aos="fade-up">
          <h5>Nature & highlights</h5>
          <p class="muted small">
            Taba's unique location makes it a jewel on the Red Sea. The area
            features a dramatic fjord-like bay for diving, the colorful canyon
            with spectacular sandstone formations, mountain caves and trails
            in Taba Protectorate, and Pharaoh's Island — a small historic
            island with excellent snorkeling.
          </p>
        </section>
      </div>

      <!-- RIGHT: Sticky booking summary / quick book -->
      <aside class="col-lg-4">
        <div class="sticky-right">
          <div class="summary-box mb-3">
            <h6 class="mb-2">Quick Booking</h6>
            <p class="muted small mb-3">
              Select dates & options in the booking modal to calculate the
              total. Click “Proceed to payment” to continue to checkout.
            </p>

            <div class="d-grid gap-2">
              <button class="btn btn-custom" onclick="openBookingQuick()">
                Quick Book
              </button>
              <a class="btn btn-outline-primary" href="tel:16715"><i class="fa-solid fa-phone me-2"></i>Call 16715</a>
            </div>
          </div>

          <div class="summary-box">
            <h6 class="mb-2">Contact</h6>
            <div class="muted small mb-2">
              <i class="fa-solid fa-phone me-2 text-primary"></i>+20 100 000
              0000
            </div>
            <div class="muted small mb-2">
              <i class="fa-solid fa-envelope me-2 text-primary"></i>info@example.com
            </div>
            <a href="#contact" class="small text-primary-strong">More help & support →</a>
          </div>
        </div>
      </aside>
    </div>
  </main>

  @include('components.booking-modal')

  <!-- ===========================
   Premium Footer (paste into <body>)
   =========================== -->

  <!-- SCRIPTS -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <!-- i18next -->
  <script src="https://unpkg.com/i18next@21.6.14/i18next.min.js"></script>
  <script src="https://unpkg.com/i18next-browser-languagedetector@6.1.4/i18nextBrowserLanguageDetector.min.js"></script>
  <!-- <script src="{{ asset('assets/js/app.js') }}"></script> -->

  <script>
    AOS.init({
      duration: 600,
      once: true
    });

    // Initialize Swiper gallery + thumbs
    const thumbs = new Swiper(".thumbs", {
      spaceBetween: 8,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
      breakpoints: {
        576: {
          slidesPerView: 5
        },
        768: {
          slidesPerView: 6
        }
      },
    });
    const gallery = new Swiper(".gallery-swiper", {
      loop: true,
      spaceBetween: 16,
      pagination: {
        el: ".swiper-pagination",
        clickable: true
      },
      thumbs: {
        swiper: thumbs
      },
      autoplay: {
        delay: 3500,
        disableOnInteraction: false
      },
    });
  </script>
  @endsection

  @section('scripts')
  <script src="{{ asset('assets/js/booking-modal.js') }}"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 600,
      once: true
    });
  </script>
  @endsection