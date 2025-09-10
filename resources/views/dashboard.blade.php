<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar','ar_EG','ar-SA']) ? 'rtl' : 'ltr' }}"
    data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'TravelApp'))</title>
    <meta name="description" content="@yield('meta_description', 'Dashboard of ' . config('app.name', 'TravelApp'))">
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Fonts --}}
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    {{-- Bootstrap (LTR/RTL depending on language) --}}
    @if(in_array(app()->getLocale(), ['ar','ar_EG','ar-SA']))
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-p8GfD1xk8lqv7o5Hq8f8yC9KJQz1Q+QxqkXc6k2zfr4m4sDk5m7S8y9oK3q8n9el"
        crossorigin="anonymous">
    @else
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    @endif

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHsQ0sKQ4ZC2H0V2bYlU2QyqR5j1k0l6b9xv7bIh2mJwH2u2tZ2dXq5m8fC6j8Qf0l1PjK5a5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- SweetAlert2 --}}
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- UI Colors + Small Enhancements --}}
    <style>
        .image-upload-wrapper {
            background: #f9f9fb;
            transition: all 0.3s ease;
        }

        .image-upload-wrapper:hover {
            background: #eef6ff;
            border-color: #0d6efd;
        }

        :root {
            --primary: #4f46e5;
            --primary-700: #4338ca;
            --accent: #f59e0b;
            --bg: #f6f7fb;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --hover: rgba(79, 70, 229, .08);
            --active: rgba(79, 70, 229, .16);
        }

        [data-theme="dark"] {
            --bg: #0b1220;
            --card: #121a2a;
            --text: #e5e7eb;
            --muted: #9ca3af;
            --hover: rgba(99, 102, 241, .15);
            --active: rgba(99, 102, 241, .25);
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Figtree', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
            background: var(--bg);
            color: var(--text);
        }

        .navbar-modern {
            background: var(--card);
            border-bottom: 1px solid rgba(0, 0, 0, .06);
            transition: all .25s ease;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: .2px;
        }

        .navbar-modern .nav-link {
            font-weight: 600;
            border-radius: .6rem;
            padding: .5rem .85rem;
            color: var(--muted);
            transition: .2s;
        }

        .navbar-modern .nav-link:hover {
            background: var(--hover);
            color: var(--primary);
        }

        .navbar-modern .nav-link.active {
            background: var(--active);
            color: var(--primary);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .12);
            object-fit: cover;
        }

        .content-wrap {
            min-height: calc(100vh - 64px);
            padding: 1.25rem 0 2rem;
        }

        .card-soft {
            background: var(--card);
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: .9rem;
            box-shadow: 0 6px 16px -8px rgba(0, 0, 0, .12);
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-700);
            border-color: var(--primary-700);
        }

        .dropdown-menu {
            border: none;
            background: var(--card);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .12);
            border-radius: .8rem;
        }

        /* Toast position fix for RTL */
        .swal2-top-end {
            inset-inline-start: auto !important;
            inset-inline-end: 1.25rem !important;
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased">

    <nav class="navbar navbar-expand-lg navbar-modern sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-compass text-warning"></i>
                <span>{{ config('app.name', 'TravelApp') }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-lg-1" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                            href="{{ route('users.index') }}">Users</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}"
                            href="{{ route('destinations.index') }}">Destinations</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tours.*') ? 'active' : '' }}"
                            href="{{ route('tours.index') }}">Tours</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rateplans.*') ? 'active' : '' }}"
                            href="{{ route('rateplans.index') }}">Rate Plans</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}"
                            href="{{ route('bookings.index') }}">Bookings</a>
                    </li>
                </ul>

                @auth
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                            <img class="avatar"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                                alt="Avatar">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('profile.edit') }}">
                                    <i class="fa-solid fa-user text-muted"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                {{-- Logout Form --}}
                                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                    @csrf
                                </form>
                                <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                    onclick="confirmLogout()">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>Logout</span>
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Breadcrumb (Optional) --}}
    @if(View::hasSection('breadcrumb'))
    <div class="container mt-3">
        <div class="card-soft p-3">
            @yield('breadcrumb')
        </div>
    </div>
    @endif

    <div class="container content-wrap">
        {{-- Flash Messages -> SweetAlert Toast --}}
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'success',
                    title: @json(session('success'))
                });
            });
        </script>
        @endif
        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    icon: 'error',
                    title: @json(session('error'))
                });
            });
        </script>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    <footer class="py-4 mt-auto">
        <div class="container text-center text-muted small">
            <span class="d-inline-flex align-items-center gap-2">
                <i class="fa-solid fa-plane-departure"></i>
                <span>{{ config('app.name', 'TravelApp') }} &copy; {{ now()->year }}</span>
            </span>
        </div>
    </footer>

    {{-- Bootstrap Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        // Confirm Logout
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Dark/Light Theme Toggle with LocalStorage
        (function themeBoot() {
            const storageKey = 'travelapp-theme';
            const html = document.documentElement;
            const saved = localStorage.getItem(storageKey);
            if (saved === 'dark' || saved === 'light') html.setAttribute('data-theme', saved);

            const btn = document.getElementById('themeToggle');

            // Sync icon on load
            if (btn) {
                btn.innerHTML = html.getAttribute('data-theme') === 'dark' ?
                    '<i class="fa-solid fa-sun"></i>' :
                    '<i class="fa-solid fa-moon"></i>';
            }
        })();
    </script>

    @stack('scripts')
    @yield('scripts')
</body>

</html>