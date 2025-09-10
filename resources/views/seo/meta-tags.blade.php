{{-- SEO Meta Tags Component for Dahab Dream Tours --}}

{{-- Basic Meta Tags --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

{{-- Primary Meta Tags --}}
<title>@yield('seo_title', $seoData['title'] ?? 'Dahab Dream Tours - رحلات مصر السياحية | Egypt Travel Tours')</title>
<meta name="title" content="@yield('seo_title', $seoData['title'] ?? 'Dahab Dream Tours - رحلات مصر السياحية | Egypt Travel Tours')">
<meta name="description" content="@yield('seo_description', $seoData['description'] ?? 'احجز رحلتك السياحية في مصر مع دهب دريم تورز. الغردقة، شرم الشيخ، الساحل الشمالي، رحلات شهر العسل والرحلات التاريخية. Book your Egypt travel with Dahab Dream Tours - Hurghada, Sharm El Sheikh, North Coast tours.')">
<meta name="keywords" content="@yield('seo_keywords', $seoData['keywords'] ?? 'دهب دريم تورز, رحلات مصر, الغردقة, شرم الشيخ, الساحل الشمالي, شهر العسل, رحلات تاريخية, Dahab Dream Tours, Egypt tours, Hurghada, Sharm El Sheikh, North Coast, honeymoon, historical tours, Ägypten Reisen, Hurghada Reisen, voyages Égypte, Hurghada voyages')">
<meta name="author" content="Dahab Dream Tours">
<meta name="robots" content="@yield('robots', 'index, follow')">
<meta name="language" content="{{ app()->getLocale() }}">
<meta name="revisit-after" content="7 days">
<meta name="rating" content="general">

{{-- Canonical URL --}}
<link rel="canonical" href="@yield('canonical', url()->current())">

{{-- Alternate Language URLs --}}
@if(isset($alternateUrls))
    @foreach($alternateUrls as $locale => $url)
        <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
    @endforeach
@endif
<link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:site_name" content="Dahab Dream Tours">
<meta property="og:title" content="@yield('og_title', $seoData['title'] ?? 'Dahab Dream Tours - رحلات مصر السياحية')">
<meta property="og:description" content="@yield('og_description', $seoData['description'] ?? 'احجز رحلتك السياحية في مصر مع دهب دريم تورز. الغردقة، شرم الشيخ، الساحل الشمالي، رحلات شهر العسل والرحلات التاريخية.')">
<meta property="og:url" content="@yield('og_url', url()->current())">
<meta property="og:image" content="@yield('og_image', asset('assets/images/dahab-dream-og.jpg'))">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="@yield('og_image_alt', 'Dahab Dream Tours - Egypt Travel Experience')">
<meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}">
@if(app()->getLocale() !== 'en')
<meta property="og:locale:alternate" content="en_US">
@endif
@if(app()->getLocale() !== 'ar')
<meta property="og:locale:alternate" content="ar_EG">
@endif
@if(app()->getLocale() !== 'de')
<meta property="og:locale:alternate" content="de_DE">
@endif
@if(app()->getLocale() !== 'fr')
<meta property="og:locale:alternate" content="fr_FR">
@endif

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@DahabDreamTours">
<meta name="twitter:creator" content="@DahabDreamTours">
<meta name="twitter:title" content="@yield('twitter_title', $seoData['title'] ?? 'Dahab Dream Tours - Egypt Travel Tours')">
<meta name="twitter:description" content="@yield('twitter_description', $seoData['description'] ?? 'Book your Egypt travel with Dahab Dream Tours - Hurghada, Sharm El Sheikh, North Coast tours.')">
<meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/dahab-dream-twitter.jpg'))">
<meta name="twitter:image:alt" content="@yield('twitter_image_alt', 'Dahab Dream Tours - Egypt Travel Experience')">

{{-- Additional Meta Tags --}}
<meta name="theme-color" content="#1e40af">
<meta name="msapplication-TileColor" content="#1e40af">
<meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

{{-- Geo Meta Tags --}}
<meta name="geo.region" content="EG">
<meta name="geo.placename" content="Egypt">
<meta name="geo.position" content="26.8206;30.8025">
<meta name="ICBM" content="26.8206, 30.8025">

{{-- Business Meta Tags --}}
<meta name="business:contact_data:street_address" content="Red Sea, Egypt">
<meta name="business:contact_data:locality" content="Hurghada">
<meta name="business:contact_data:region" content="Red Sea Governorate">
<meta name="business:contact_data:postal_code" content="84511">
<meta name="business:contact_data:country_name" content="Egypt">

{{-- Structured Data --}}
@yield('structured_data')

{{-- Preconnect for Performance --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="preconnect" href="https://cdnjs.cloudflare.com">

{{-- DNS Prefetch --}}
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

{{-- Favicon and Icons --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">

{{-- Additional SEO Meta Tags based on page type --}}
@stack('additional_meta')
