<!-- Navbar -->
<header class="navbar-wrapper fixed-top shadow-sm">
    <nav class="navbar navbar-expand-lg py-2 bg-white">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold d-flex align-items-center me-4" href="{{ route('interface.main') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="48" class="me-2" />
                <span class="brand-text text-primary">Dahab Dream</span>
            </a>

            <!-- Language Dropdown (قبل أيقونة النافبار) -->
            <div class="dropdown d-lg-none me-2">
                <button
                    class="btn btn-outline-primary dropdown-toggle d-flex align-items-center"
                    type="button"
                    id="languageDropdownMobile"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-globe me-1"></i>
                    <span class="d-none d-sm-inline">{{ strtoupper(app()->getLocale()) }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="languageDropdownMobile">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}">🇺🇸 English</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'de']) }}">🇩🇪 Deutsch</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'fr']) }}">🇫🇷 Français</a></li>
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
                        <a href="{{ route('interface.main') }}#hero" class="nav-link {{ request()->routeIs('interface.main') ? 'active' : '' }}">{{ __('interface.nav.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('interface.main') }}#destinations" class="nav-link">{{ __('interface.nav.destinations') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('interface.main') }}#popular" class="nav-link">{{ __('interface.nav.tours') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('interface.main') }}#testimonials" class="nav-link">{{ __('interface.testimonials.title') }}</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="{{ route('interface.main') }}#contact" class="nav-link">{{ __('interface.nav.contact') }}</a>
                    </li> -->
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
                        <span class="d-none d-sm-inline language-display">{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}">🇺🇸 English</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'de']) }}">🇩🇪 Deutsch</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['locale' => 'fr']) }}">🇫🇷 Français</a></li>
                    </ul>
                </div>

                <!-- CTA Button -->
                <!-- <a href="{{ route('interface.main') }}#contact" class="btn btn-primary px-4 py-2 fw-semibold">
                    {{ __('interface.nav.book_now') }}
                </a> -->
            </div>
        </div>
    </nav>
</header>
