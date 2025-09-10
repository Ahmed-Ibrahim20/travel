@extends('layouts.interface')

@section('title', ($destination ? ucfirst($destination) : 'All') . ' ' . __('interface.nav.tours') . ' — Sun & Sea Tours')
@section('description', 'Explore ' . ($destination ? $destination : 'all') . ' trips. Book your Red Sea adventure with Sun & Sea Tours. Trusted, easy, and fair prices.')

@section('content')
      <section class="py-5 container" style="margin-top: 80px">
        <div class="row">
          <!-- Sidebar Filters -->
          <aside class="col-lg-3 mb-4 mb-lg-0">
            <div
              class="card shadow-lg border-0 p-4 sticky-top"
              style="top: 100px; border-radius: 15px; background: #ffffff"
            >
              <h5 class="fw-bold mb-4 text-primary">Filter Your Trip</h5>

              <form id="filterForm" method="GET" action="{{ route('interface.tours', $destination) }}">
                <!-- Search by hotel or place -->
                <div class="mb-4">
                  <label class="form-label fw-semibold">Search by name</label>
                  <input
                    type="text"
                    class="form-control"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Hotel or Place name..."
                  />
                </div>

                <!-- Duration -->
                <div class="mb-4">
                  <label class="form-label fw-semibold">Duration</label>
                  <select class="form-select" name="duration">
                    <option value="">All</option>
                    <option value="1">1 Night</option>
                    <option value="2">2 Nights</option>
                    <option value="3">3 Nights</option>
                    <option value="4">4 Nights</option>
                    <option value="5">5 Nights</option>
                    <option value="6">6 Nights</option>
                    <option value="7">1 Week</option>
                  </select>
                </div>

                <!-- Trip Type -->
                <div class="mb-4">
                  <label class="form-label fw-semibold">Trip Type</label>
                  <select class="form-select" name="type">
                    <option value="">All</option>
                    <option value="hotel" {{ (isset($type) && $type == 'hotel') ? 'selected' : '' }}>Hotel</option>
                    <option value="honeymoon" {{ (isset($type) && $type == 'honeymoon') ? 'selected' : '' }}>Honeymoon</option>
                    <option value="trip" {{ (isset($type) && $type == 'trip') ? 'selected' : '' }}>Trip</option>
                  </select>
                </div>

                <!-- Stars -->
                <div class="mb-4">
                  <label class="form-label fw-semibold">Hotel Rating</label>
                  <div class="d-flex flex-wrap gap-2">
                    <button
                      type="button"
                      class="btn btn-outline-warning btn-sm"
                    >
                      <i class="fa fa-star"></i> 1
                    </button>
                    <button
                      type="button"
                      class="btn btn-outline-warning btn-sm"
                    >
                      <i class="fa fa-star"></i> 2
                    </button>
                    <button
                      type="button"
                      class="btn btn-outline-warning btn-sm"
                    >
                      <i class="fa fa-star"></i> 3
                    </button>
                    <button
                      type="button"
                      class="btn btn-outline-warning btn-sm"
                    >
                      <i class="fa fa-star"></i> 4
                    </button>
                    <button
                      type="button"
                      class="btn btn-outline-warning btn-sm"
                    >
                      <i class="fa fa-star"></i> 5
                    </button>
                  </div>
                </div>

                <!-- Price per Night -->
                <div class="mb-4">
                  <label class="form-label fw-semibold">Price per Night</label>
                  <div class="d-flex gap-2">
                    <input
                      type="number"
                      class="form-control"
                      name="price_min"
                      placeholder="Min $"
                      min="0"
                    />
                    <input
                      type="number"
                      class="form-control"
                      name="price_max"
                      placeholder="Max $"
                      min="0"
                    />
                  </div>
                </div>

                <!-- Apply Button -->
                <button
                  type="submit"
                  class="btn btn-primary w-100 py-2 fw-bold"
                >
                  Apply Filters
                </button>
                
                @if(!empty(array_filter($filters)))
                <a href="{{ route('interface.tours', $destination) }}" class="btn btn-outline-secondary w-100 mt-2">
                  Clear Filters
                </a>
                @endif
              </form>
            </div>
          </aside>

          <!-- Trips Grid -->
          <div class="col-lg-9">
            <div class="text-center mb-5">
              <h2 class="fw-bold fs-1 text-primary">
                @if($destination)
                  {{ ucfirst($destination) }} {{ __('interface.nav.tours') }}
                @else
                  {{ __('interface.destinations.title') }}
                @endif
              </h2>
              <p class="text-muted fs-5">
                @if($destination)
                  Choose from our top-rated {{ $destination }} packages
                @else
                  {{ __('interface.destinations.subtitle') }}
                @endif
              </p>
            </div>

            <div class="row g-4">
              @forelse($tours as $tour)
              <div class="col-md-6 col-xl-4">
                <a href="{{ route('interface.details', $tour->id) }}" class="text-decoration-none">
                  <div class="card trip-card shadow-lg border-0 h-100 rounded-4 overflow-hidden">
                    <div class="trip-img-wrapper position-relative">
                      <img
                        src="{{ is_array($tour->image_urls) ? $tour->image_urls[0]: ($tour->image_urls) }}"
                        class="card-img-top fixed-img"
                        alt="{{ $tour->getTranslatedTitle() }}"
                      />
                      @if($tour->is_popular)
                        <span class="trip-badge">{{ __('interface.popular') }}</span>
                      @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                      <h5 class="card-title fw-bold text-dark mb-1">
                        {{ $tour->getTranslatedTitle() }}
                      </h5>
                      <!-- Stars -->
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
                        {{ $tour->getTranslatedDescription() }}
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
              @empty
              <div class="col-12">
                <div class="text-center py-5">
                  <i class="fas fa-search fa-3x text-muted mb-3"></i>
                  <h4 class="text-muted">No tours found</h4>
                  <p class="text-muted">Try adjusting your filters or search criteria.</p>
                </div>
              </div>
              @endforelse
            </div>
          </div>
        </div>
      </section>

      
@endsection
