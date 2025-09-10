{{-- Additional SEO Enhancements for Dahab Dream Tours --}}

{{-- Google Analytics 4 --}}
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>

{{-- Google Search Console Verification --}}
<meta name="google-site-verification" content="YOUR_GOOGLE_VERIFICATION_CODE" />

{{-- Bing Webmaster Tools --}}
<meta name="msvalidate.01" content="YOUR_BING_VERIFICATION_CODE" />

{{-- Yandex Webmaster --}}
<meta name="yandex-verification" content="YOUR_YANDEX_VERIFICATION_CODE" />

{{-- Additional Travel-Specific Meta Tags --}}
<meta name="travel:destination" content="Egypt, Dahab, Hurghada, Sharm El Sheikh, Red Sea">
<meta name="travel:activities" content="Diving, Snorkeling, Desert Safari, Nile Cruise, Cultural Tours">
<meta name="travel:season" content="Year-round">
<meta name="travel:duration" content="1-14 days">
<meta name="travel:group_size" content="1-50 people">

{{-- Rich Snippets for Travel --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TouristDestination",
  "name": "Egypt Red Sea Coast",
  "description": "Discover the beauty of Egypt's Red Sea coast with Dahab Dream Tours - diving, snorkeling, desert adventures and cultural experiences.",
  "image": "{{ asset('assets/images/red-sea-coast.jpg') }}",
  "touristType": ["Divers", "Snorkelers", "Adventure Seekers", "Culture Enthusiasts", "Honeymooners"],
  "includesAttraction": [
    {
      "@type": "TouristAttraction",
      "name": "Blue Hole Dahab",
      "description": "World-famous diving site in Dahab"
    },
    {
      "@type": "TouristAttraction", 
      "name": "Giftun Island",
      "description": "Beautiful island near Hurghada for snorkeling"
    },
    {
      "@type": "TouristAttraction",
      "name": "Ras Mohammed National Park",
      "description": "Premier diving destination in Sharm El Sheikh"
    }
  ]
}
</script>

{{-- FAQ Schema for Travel Questions --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What are the best diving sites in the Red Sea?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "The Red Sea offers world-class diving sites including the Blue Hole in Dahab, Ras Mohammed National Park, Tiran Island, and the wrecks of the SS Thistlegorm and Giannis D."
      }
    },
    {
      "@type": "Question",
      "name": "When is the best time to visit Egypt for diving?",
      "acceptedAnswer": {
        "@type": "Answer", 
        "text": "Egypt offers excellent diving year-round. The best conditions are from March to May and September to November with calm seas and perfect visibility."
      }
    },
    {
      "@type": "Question",
      "name": "Do you offer tours for beginners?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, Dahab Dream Tours offers tours for all experience levels, from complete beginners to advanced divers, with certified instructors and safe equipment."
      }
    }
  ]
}
</script>

{{-- Breadcrumb Schema --}}
@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    @foreach($breadcrumbs as $index => $breadcrumb)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "name": "{{ $breadcrumb['name'] }}",
      "item": "{{ $breadcrumb['url'] }}"
    }@if(!$loop->last),@endif
    @endforeach
  ]
}
</script>
@endif

{{-- Local Business Schema --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "@id": "{{ url('/') }}",
  "name": "Dahab Dream Tours",
  "alternateName": "Gold Dream Tour",
  "description": "Premium Egypt travel agency specializing in Red Sea diving tours, desert safaris, and cultural experiences.",
  "url": "{{ url('/') }}",
  "telephone": "+20-xxx-xxx-xxxx",
  "email": "info@dahabdreamtours.com",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Red Sea Coast",
    "addressLocality": "Hurghada", 
    "addressRegion": "Red Sea Governorate",
    "postalCode": "84511",
    "addressCountry": "EG"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 26.8206,
    "longitude": 30.8025
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
    ],
    "opens": "08:00",
    "closes": "22:00"
  },
  "priceRange": "$$",
  "servesCuisine": "Travel Services",
  "acceptsReservations": true,
  "currenciesAccepted": ["USD", "EUR", "EGP"],
  "paymentAccepted": ["Cash", "Credit Card", "Bank Transfer"],
  "hasMap": "https://maps.google.com/?q=Hurghada,Egypt"
}
</script>

{{-- Website Schema --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Dahab Dream Tours",
  "alternateName": "Gold Dream Tour",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "{{ url('/search') }}?q={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  },
  "sameAs": [
    "https://www.facebook.com/DahabDreamTours",
    "https://www.instagram.com/dahabdreamtours", 
    "https://www.twitter.com/DahabDreamTours"
  ]
}
</script>

{{-- Performance Monitoring --}}
<script>
// Page Load Performance
window.addEventListener('load', function() {
  setTimeout(function() {
    const perfData = performance.getEntriesByType('navigation')[0];
    const loadTime = perfData.loadEventEnd - perfData.loadEventStart;
    
    // Send to analytics
    if (typeof gtag !== 'undefined') {
      gtag('event', 'page_load_time', {
        event_category: 'Performance',
        event_label: 'Load Time',
        value: Math.round(loadTime)
      });
    }
  }, 0);
});
</script>
