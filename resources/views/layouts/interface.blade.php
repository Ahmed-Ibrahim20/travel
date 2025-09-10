<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" prefix="og: https://ogp.me/ns#">
<head>
    @php
        $seoController = new \App\Http\Controllers\SeoController();
        $pageType = request()->routeIs('interface.main') ? 'home' : 
                   (request()->routeIs('interface.tours*') ? 'tours' : 
                   (request()->routeIs('interface.details') ? 'tour_detail' : 'home'));
        $entity = isset($tour) ? $tour : (isset($destination) ? $destination : null);
        $seoData = $seoController->getSeoData($pageType, $entity);
        $alternateUrls = $seoController->getAlternateUrls(request()->getPathInfo());
        $faqs = $seoController->getFaqData(app()->getLocale());
        
        // Generate breadcrumbs
        $breadcrumbs = [];
        if (request()->routeIs('interface.details') && isset($tour)) {
            $breadcrumbs = $seoController->generateBreadcrumbs([
                ['name' => __('interface.nav.tours'), 'url' => route('interface.tours')],
                ['name' => $tour->destination->getTranslatedName(), 'url' => route('interface.toursByDestination', $tour->destination->slug)],
                ['name' => $tour->getTranslatedTitle(), 'url' => url()->current()]
            ]);
        }
    @endphp
    
    @include('seo.meta-tags', compact('seoData', 'alternateUrls'))
    @include('seo.performance-optimization')

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

    @yield('styles')
</head>

<body>
    @include('layouts.partials.header')

    <main>
        @yield('content')
    </main>
    @include('layouts.partials.footer')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>
