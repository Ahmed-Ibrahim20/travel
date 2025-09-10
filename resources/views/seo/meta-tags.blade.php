{{-- Basic Meta Tags --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

{{-- Primary Meta Tags --}}
<title>@yield('seo_title', $seoData['title'] ?? 'Dahab Dream Tours & Gold Dream Tour - رحلات مصر السياحية | Best Egypt Travel Tours')</title>
<meta name="title" content="@yield('seo_title', $seoData['title'] ?? 'Dahab Dream Tours & Gold Dream Tour - رحلات مصر السياحية | Best Egypt Travel Tours')">
<meta name="description" content="@yield('seo_description', $seoData['description'] ?? 'احجز رحلتك السياحية في مصر مع دهب دريم تورز وذهب دريم تور. الغردقة، شرم الشيخ، دهب، الساحل الشمالي، رحلات البحر الأحمر، سفاري الصحراء، الغوص والسنوركلينج، رحلات نيلية، الأقصر وأسوان. Book your Egypt travel with Dahab Dream Tours & Gold Dream Tour - Best Egypt tours, Hurghada diving, Sharm El Sheikh excursions, Dahab adventures, Red Sea holidays, desert safaris, Nile cruises.')">
<meta name="keywords" content="@yield('seo_keywords', $seoData['keywords'] ?? 'دهب دريم تورز, ذهب دريم تور, رحلات مصر, الغردقة, شرم الشيخ, دهب, الساحل الشمالي, شهر العسل, رحلات تاريخية, رحلات البحر الأحمر, سفاري الصحراء, الغوص والسنوركلينج, رحلات نيلية, الأقصر وأسوان, الجيزة والأهرامات, Dahab Dream Tours, Gold Dream Tour, Egypt tours, Egypt travel, Hurghada tours, Sharm El Sheikh tours, Dahab tours, Red Sea diving, desert safari, Nile cruise, Luxor Aswan tours, Giza pyramids, North Coast Egypt, Egyptian tourism, travel Egypt, visit Egypt, Egypt vacation, Egypt holidays, Ägypten Reisen, Hurghada Reisen, Dahab Reisen, Ägypten Urlaub, voyages Égypte, Hurghada voyages, Dahab voyages, vacances Égypte, tourisme Égypte')">
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
<meta property="og:title" content="@yield('og_title', $seoData['title'] ?? 'Dahab Dream Tours & Gold Dream Tour - Best Egypt Travel')">
<meta property="og:description" content="@yield('og_description', $seoData['description'] ?? 'احجز رحلتك السياحية في مصر مع دهب دريم تورز وذهب دريم تور. الغردقة، شرم الشيخ، دهب، رحلات البحر الأحمر، سفاري الصحراء، الغوص والسنوركلينج، رحلات نيلية.')">
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
<meta name="twitter:title" content="@yield('twitter_title', $seoData['title'] ?? 'Dahab Dream Tours & Gold Dream Tour - Best Egypt Travel')">
<meta name="twitter:description" content="@yield('twitter_description', $seoData['description'] ?? 'Book your Egypt travel with Dahab Dream Tours & Gold Dream Tour - Hurghada diving, Sharm El Sheikh tours, Dahab adventures, Red Sea holidays, desert safaris.')">
<meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/dahab-dream-twitter.jpg'))">
<meta name="twitter:image:alt" content="@yield('twitter_image_alt', 'Dahab Dream Tours - Egypt Travel Experience')">

{{-- Additional Meta Tags --}}
<meta name="theme-color" content="#1e40af">
<meta name="msapplication-TileColor" content="#1e40af">
<meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">

{{-- Geo Meta Tags --}}
<meta name="geo.region" content="EG">
<meta name="geo.placename" content="Egypt, Dahab, Hurghada, Red Sea">
<meta name="geo.position" content="26.8206;30.8025">
<meta name="ICBM" content="26.8206, 30.8025">
<meta name="geo.position" content="28.5009;34.5130">
<meta name="ICBM" content="28.5009, 34.5130">

{{-- Business Meta Tags --}}
<meta name="business:contact_data:street_address" content="Red Sea, Egypt">
<meta name="business:contact_data:locality" content="Hurghada">
<meta name="business:contact_data:region" content="Red Sea Governorate">
<meta name="business:contact_data:postal_code" content="84511">
<meta name="business:contact_data:country_name" content="Egypt">

{{-- Structured Data --}}
<script type="application/ld+json">
@php
echo json_encode([
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "TravelAgency",
            "name" => "Dahab Dream Tours",
            "alternateName" => "Gold Dream Tour",
            "description" => "Premium Egypt travel agency specializing in Red Sea tours, desert safaris, diving excursions, and cultural experiences in Dahab, Hurghada, Sharm El Sheikh, and throughout Egypt.",
            "url" => url('/'),
            "logo" => asset('assets/images/dahab-dream-logo.png'),
            "image" => asset('assets/images/dahab-dream-og.jpg'),
            "telephone" => "+20-xxx-xxx-xxxx",
            "email" => "info@dahabdreamtours.com",
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => "Red Sea Coast",
                "addressLocality" => "Hurghada",
                "addressRegion" => "Red Sea Governorate",
                "postalCode" => "84511",
                "addressCountry" => "EG"
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => 26.8206,
                "longitude" => 30.8025
            ],
            "areaServed" => [
                ["@type" => "Place", "name" => "Egypt"],
                ["@type" => "Place", "name" => "Hurghada"],
                ["@type" => "Place", "name" => "Dahab"],
                ["@type" => "Place", "name" => "Sharm El Sheikh"],
                ["@type" => "Place", "name" => "Red Sea"],
            ],
            "serviceType" => [
                "Egypt Tours",
                "Red Sea Diving",
                "Desert Safari",
                "Nile Cruise",
                "Cultural Tours",
                "Honeymoon Packages",
                "Snorkeling Tours",
                "Historical Tours"
            ],
            "sameAs" => [
                "https://www.facebook.com/DahabDreamTours",
                "https://www.instagram.com/dahabdreamtours",
                "https://www.twitter.com/DahabDreamTours"
            ],
            "priceRange" => "$$",
            "currenciesAccepted" => ["USD", "EUR", "EGP"],
            "paymentAccepted" => ["Cash", "Credit Card", "Bank Transfer"],
            "openingHours" => "Mo-Su 08:00-22:00",
            "hasOfferCatalog" => [
                "@type" => "OfferCatalog",
                "name" => "Egypt Travel Packages",
                "itemListElement" => [
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "TouristTrip",
                            "name" => "Hurghada Red Sea Tours",
                            "description" => "Diving and snorkeling tours in the Red Sea"
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "TouristTrip",
                            "name" => "Dahab Adventure Tours",
                            "description" => "Desert safari and Blue Hole diving experiences"
                        ]
                    ],
                    [
                        "@type" => "Offer",
                        "itemOffered" => [
                            "@type" => "TouristTrip",
                            "name" => "Sharm El Sheikh Excursions",
                            "description" => "Ras Mohammed and Tiran Island tours"
                        ]
                    ]
                ]
            ]
        ],
        [
            "@type" => "Organization",
            "name" => "Dahab Dream Tours",
            "alternateName" => ["Gold Dream Tour", "دهب دريم تورز", "ذهب دريم تور"],
            "url" => url('/'),
            "logo" => asset('assets/images/dahab-dream-logo.png'),
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+20-xxx-xxx-xxxx",
                "contactType" => "customer service",
                "availableLanguage" => ["English", "Arabic", "German", "French"]
            ],
            "foundingLocation" => [
                "@type" => "Place",
                "name" => "Egypt"
            ],
            "knowsAbout" => [
                "Egypt Tourism",
                "Red Sea Diving",
                "Desert Safari",
                "Nile Cruises",
                "Egyptian History",
                "Underwater Photography",
                "Marine Life",
                "Bedouin Culture"
            ]
        ]
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
@endphp
</script>



{{-- @yield('structured_data') --}}

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

{{-- Additional SEO Meta Tags based on page type --}}
{{--@stack('additional_meta')
--}}