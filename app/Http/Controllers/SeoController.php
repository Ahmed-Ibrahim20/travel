<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SeoController extends Controller
{
    /**
     * Get SEO data for different page types
     */
    public function getSeoData($pageType = 'home', $entity = null)
    {
        $locale = App::getLocale();
        
        $seoData = [
            'home' => $this->getHomeSeoData($locale),
            'tours' => $this->getToursSeoData($locale),
            'destinations' => $this->getDestinationsSeoData($locale),
            'tour_detail' => $this->getTourDetailSeoData($locale, $entity),
            'destination_detail' => $this->getDestinationDetailSeoData($locale, $entity),
            'booking' => $this->getBookingSeoData($locale),
            'contact' => $this->getContactSeoData($locale),
        ];

        return $seoData[$pageType] ?? $seoData['home'];
    }

    private function getHomeSeoData($locale)
    {
        $seoData = [
            'ar' => [
                'title' => 'دهب دريم تورز - رحلات مصر السياحية | الغردقة، شرم الشيخ، الساحل الشمالي',
                'description' => 'احجز رحلتك السياحية في مصر مع دهب دريم تورز. رحلات الغردقة، شرم الشيخ، الساحل الشمالي، رحلات شهر العسل، الرحلات التاريخية. أفضل الأسعار وخدمة متميزة.',
                'keywords' => 'دهب دريم تورز, رحلات مصر, الغردقة, شرم الشيخ, الساحل الشمالي, شهر العسل, رحلات تاريخية, رحلات البحر الأحمر, سياحة مصر, عروض سياحية'
            ],
            'en' => [
                'title' => 'Dahab Dream Tours - Egypt Travel & Tours | Hurghada, Sharm El Sheikh, North Coast',
                'description' => 'Book your Egypt travel with Dahab Dream Tours. Hurghada tours, Sharm El Sheikh trips, North Coast holidays, honeymoon packages, historical tours. Best prices and premium service.',
                'keywords' => 'Dahab Dream Tours, Egypt tours, Hurghada, Sharm El Sheikh, North Coast, honeymoon, historical tours, Red Sea tours, Egypt travel, travel packages'
            ],
            'de' => [
                'title' => 'Dahab Dream Tours - Ägypten Reisen | Hurghada, Sharm El Sheikh, Nordküste',
                'description' => 'Buchen Sie Ihre Ägypten Reise mit Dahab Dream Tours. Hurghada Touren, Sharm El Sheikh Ausflüge, Nordküste Urlaub, Flitterwochen Pakete, historische Touren. Beste Preise und Premium Service.',
                'keywords' => 'Dahab Dream Tours, Ägypten Reisen, Hurghada, Sharm El Sheikh, Nordküste, Flitterwochen, historische Touren, Rotes Meer Touren, Ägypten Urlaub, Reisepakete'
            ],
            'fr' => [
                'title' => 'Dahab Dream Tours - Voyages Égypte | Hurghada, Sharm El Sheikh, Côte Nord',
                'description' => 'Réservez votre voyage en Égypte avec Dahab Dream Tours. Tours Hurghada, excursions Sharm El Sheikh, vacances Côte Nord, forfaits lune de miel, tours historiques. Meilleurs prix et service premium.',
                'keywords' => 'Dahab Dream Tours, voyages Égypte, Hurghada, Sharm El Sheikh, Côte Nord, lune de miel, tours historiques, tours Mer Rouge, voyage Égypte, forfaits voyage'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    private function getToursSeoData($locale)
    {
        $seoData = [
            'ar' => [
                'title' => 'جميع الرحلات السياحية في مصر - دهب دريم تورز',
                'description' => 'اكتشف جميع رحلاتنا السياحية في مصر. رحلات الغردقة، شرم الشيخ، الساحل الشمالي، القاهرة، الأقصر، أسوان. احجز الآن واستمتع بأفضل العروض.',
                'keywords' => 'رحلات مصر, جميع الرحلات, الغردقة, شرم الشيخ, الساحل الشمالي, القاهرة, الأقصر, أسوان, رحلات سياحية'
            ],
            'en' => [
                'title' => 'All Egypt Tours & Travel Packages - Dahab Dream Tours',
                'description' => 'Discover all our Egypt tours and travel packages. Hurghada tours, Sharm El Sheikh trips, North Coast holidays, Cairo, Luxor, Aswan. Book now and enjoy the best deals.',
                'keywords' => 'Egypt tours, all tours, Hurghada, Sharm El Sheikh, North Coast, Cairo, Luxor, Aswan, travel packages'
            ],
            'de' => [
                'title' => 'Alle Ägypten Touren & Reisepakete - Dahab Dream Tours',
                'description' => 'Entdecken Sie alle unsere Ägypten Touren und Reisepakete. Hurghada Touren, Sharm El Sheikh Ausflüge, Nordküste Urlaub, Kairo, Luxor, Assuan. Jetzt buchen und beste Angebote genießen.',
                'keywords' => 'Ägypten Touren, alle Touren, Hurghada, Sharm El Sheikh, Nordküste, Kairo, Luxor, Assuan, Reisepakete'
            ],
            'fr' => [
                'title' => 'Tous les Tours Égypte & Forfaits Voyage - Dahab Dream Tours',
                'description' => 'Découvrez tous nos tours Égypte et forfaits voyage. Tours Hurghada, excursions Sharm El Sheikh, vacances Côte Nord, Le Caire, Louxor, Assouan. Réservez maintenant et profitez des meilleures offres.',
                'keywords' => 'tours Égypte, tous les tours, Hurghada, Sharm El Sheikh, Côte Nord, Le Caire, Louxor, Assouan, forfaits voyage'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    private function getDestinationsSeoData($locale)
    {
        $seoData = [
            'ar' => [
                'title' => 'وجهات سياحية في مصر - دهب دريم تورز',
                'description' => 'اكتشف أجمل الوجهات السياحية في مصر. الغردقة، شرم الشيخ، الساحل الشمالي، دهب، مرسى علم، الجونة. اختر وجهتك المفضلة واحجز رحلتك.',
                'keywords' => 'وجهات سياحية مصر, الغردقة, شرم الشيخ, الساحل الشمالي, دهب, مرسى علم, الجونة, سياحة البحر الأحمر'
            ],
            'en' => [
                'title' => 'Egypt Travel Destinations - Dahab Dream Tours',
                'description' => 'Discover the most beautiful travel destinations in Egypt. Hurghada, Sharm El Sheikh, North Coast, Dahab, Marsa Alam, El Gouna. Choose your favorite destination and book your trip.',
                'keywords' => 'Egypt destinations, Hurghada, Sharm El Sheikh, North Coast, Dahab, Marsa Alam, El Gouna, Red Sea tourism'
            ],
            'de' => [
                'title' => 'Ägypten Reiseziele - Dahab Dream Tours',
                'description' => 'Entdecken Sie die schönsten Reiseziele in Ägypten. Hurghada, Sharm El Sheikh, Nordküste, Dahab, Marsa Alam, El Gouna. Wählen Sie Ihr Lieblingsziel und buchen Sie Ihre Reise.',
                'keywords' => 'Ägypten Reiseziele, Hurghada, Sharm El Sheikh, Nordküste, Dahab, Marsa Alam, El Gouna, Rotes Meer Tourismus'
            ],
            'fr' => [
                'title' => 'Destinations Voyage Égypte - Dahab Dream Tours',
                'description' => 'Découvrez les plus belles destinations de voyage en Égypte. Hurghada, Sharm El Sheikh, Côte Nord, Dahab, Marsa Alam, El Gouna. Choisissez votre destination préférée et réservez votre voyage.',
                'keywords' => 'destinations Égypte, Hurghada, Sharm El Sheikh, Côte Nord, Dahab, Marsa Alam, El Gouna, tourisme Mer Rouge'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    private function getTourDetailSeoData($locale, $tour)
    {
        if (!$tour || is_string($tour)) return $this->getHomeSeoData($locale);

        $tourName = $tour->getTranslatedTitle();
        $tourDescription = $tour->getTranslatedDescription();
        $destinationName = $tour->destination->getTranslatedName();

        $seoData = [
            'ar' => [
                'title' => $tourName . ' - رحلة ' . $destinationName . ' | دهب دريم تورز',
                'description' => $tourDescription . ' احجز رحلة ' . $destinationName . ' مع دهب دريم تورز. أفضل الأسعار وخدمة متميزة.',
                'keywords' => $tourName . ', رحلة ' . $destinationName . ', ' . $destinationName . ', دهب دريم تورز, رحلات مصر'
            ],
            'en' => [
                'title' => $tourName . ' - ' . $destinationName . ' Tour | Dahab Dream Tours',
                'description' => $tourDescription . ' Book ' . $destinationName . ' tour with Dahab Dream Tours. Best prices and premium service.',
                'keywords' => $tourName . ', ' . $destinationName . ' tour, ' . $destinationName . ', Dahab Dream Tours, Egypt tours'
            ],
            'de' => [
                'title' => $tourName . ' - ' . $destinationName . ' Tour | Dahab Dream Tours',
                'description' => $tourDescription . ' Buchen Sie ' . $destinationName . ' Tour mit Dahab Dream Tours. Beste Preise und Premium Service.',
                'keywords' => $tourName . ', ' . $destinationName . ' Tour, ' . $destinationName . ', Dahab Dream Tours, Ägypten Touren'
            ],
            'fr' => [
                'title' => $tourName . ' - Tour ' . $destinationName . ' | Dahab Dream Tours',
                'description' => $tourDescription . ' Réservez tour ' . $destinationName . ' avec Dahab Dream Tours. Meilleurs prix et service premium.',
                'keywords' => $tourName . ', tour ' . $destinationName . ', ' . $destinationName . ', Dahab Dream Tours, tours Égypte'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    private function getDestinationDetailSeoData($locale, $destination)
    {
        if (!$destination) return $this->getHomeSeoData($locale);

        $destinationName = $destination->getTranslatedName();
        $destinationDescription = $destination->getTranslatedDescription();

        $seoData = [
            'ar' => [
                'title' => 'رحلات ' . $destinationName . ' - أفضل العروض السياحية | دهب دريم تورز',
                'description' => $destinationDescription . ' اكتشف أفضل رحلات ' . $destinationName . ' مع دهب دريم تورز. احجز الآن واستمتع بأفضل الأسعار.',
                'keywords' => 'رحلات ' . $destinationName . ', ' . $destinationName . ', سياحة ' . $destinationName . ', دهب دريم تورز, رحلات مصر'
            ],
            'en' => [
                'title' => $destinationName . ' Tours - Best Travel Deals | Dahab Dream Tours',
                'description' => $destinationDescription . ' Discover the best ' . $destinationName . ' tours with Dahab Dream Tours. Book now and enjoy the best prices.',
                'keywords' => $destinationName . ' tours, ' . $destinationName . ', ' . $destinationName . ' tourism, Dahab Dream Tours, Egypt tours'
            ],
            'de' => [
                'title' => $destinationName . ' Touren - Beste Reiseangebote | Dahab Dream Tours',
                'description' => $destinationDescription . ' Entdecken Sie die besten ' . $destinationName . ' Touren mit Dahab Dream Tours. Jetzt buchen und beste Preise genießen.',
                'keywords' => $destinationName . ' Touren, ' . $destinationName . ', ' . $destinationName . ' Tourismus, Dahab Dream Tours, Ägypten Touren'
            ],
            'fr' => [
                'title' => 'Tours ' . $destinationName . ' - Meilleures Offres Voyage | Dahab Dream Tours',
                'description' => $destinationDescription . ' Découvrez les meilleurs tours ' . $destinationName . ' avec Dahab Dream Tours. Réservez maintenant et profitez des meilleurs prix.',
                'keywords' => 'tours ' . $destinationName . ', ' . $destinationName . ', tourisme ' . $destinationName . ', Dahab Dream Tours, tours Égypte'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    private function getBookingSeoData($locale)
    {
        $seoData = [
            'ar' => [
                'title' => 'احجز رحلتك الآن - دهب دريم تورز',
                'description' => 'احجز رحلتك السياحية في مصر بسهولة وأمان. دفع آمن، تأكيد فوري، خدمة عملاء 24/7. ابدأ مغامرتك مع دهب دريم تورز.',
                'keywords' => 'حجز رحلات, حجز سياحي, دهب دريم تورز, رحلات مصر, حجز آمن'
            ],
            'en' => [
                'title' => 'Book Your Trip Now - Dahab Dream Tours',
                'description' => 'Book your Egypt trip easily and securely. Secure payment, instant confirmation, 24/7 customer service. Start your adventure with Dahab Dream Tours.',
                'keywords' => 'book tours, travel booking, Dahab Dream Tours, Egypt tours, secure booking'
            ],
            'de' => [
                'title' => 'Buchen Sie Ihre Reise Jetzt - Dahab Dream Tours',
                'description' => 'Buchen Sie Ihre Ägypten Reise einfach und sicher. Sichere Zahlung, sofortige Bestätigung, 24/7 Kundenservice. Starten Sie Ihr Abenteuer mit Dahab Dream Tours.',
                'keywords' => 'Touren buchen, Reisebuchung, Dahab Dream Tours, Ägypten Touren, sichere Buchung'
            ],
            'fr' => [
                'title' => 'Réservez Votre Voyage Maintenant - Dahab Dream Tours',
                'description' => 'Réservez votre voyage Égypte facilement et en sécurité. Paiement sécurisé, confirmation instantanée, service client 24/7. Commencez votre aventure avec Dahab Dream Tours.',
                'keywords' => 'réserver tours, réservation voyage, Dahab Dream Tours, tours Égypte, réservation sécurisée'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    private function getContactSeoData($locale)
    {
        $seoData = [
            'ar' => [
                'title' => 'اتصل بنا - دهب دريم تورز | خدمة عملاء 24/7',
                'description' => 'تواصل مع فريق دهب دريم تورز. خدمة عملاء متاحة 24/7، استشارات مجانية، مساعدة في التخطيط لرحلتك. نحن هنا لمساعدتك.',
                'keywords' => 'اتصل بنا, دهب دريم تورز, خدمة عملاء, استشارات سياحية, مساعدة'
            ],
            'en' => [
                'title' => 'Contact Us - Dahab Dream Tours | 24/7 Customer Service',
                'description' => 'Get in touch with Dahab Dream Tours team. 24/7 customer service, free consultations, trip planning assistance. We are here to help you.',
                'keywords' => 'contact us, Dahab Dream Tours, customer service, travel consultations, help'
            ],
            'de' => [
                'title' => 'Kontaktieren Sie Uns - Dahab Dream Tours | 24/7 Kundenservice',
                'description' => 'Kontaktieren Sie das Dahab Dream Tours Team. 24/7 Kundenservice, kostenlose Beratungen, Reiseplanungshilfe. Wir sind hier, um Ihnen zu helfen.',
                'keywords' => 'kontaktieren Sie uns, Dahab Dream Tours, Kundenservice, Reiseberatungen, Hilfe'
            ],
            'fr' => [
                'title' => 'Contactez-Nous - Dahab Dream Tours | Service Client 24/7',
                'description' => 'Contactez l\'équipe Dahab Dream Tours. Service client 24/7, consultations gratuites, aide à la planification de voyage. Nous sommes là pour vous aider.',
                'keywords' => 'contactez-nous, Dahab Dream Tours, service client, consultations voyage, aide'
            ]
        ];

        return $seoData[$locale] ?? $seoData['en'];
    }

    /**
     * Generate alternate URLs for different languages
     */
    public function getAlternateUrls($currentRoute, $parameters = [])
    {
        $locales = ['ar', 'en', 'de', 'fr'];
        $alternateUrls = [];

        foreach ($locales as $locale) {
            $alternateUrls[$locale] = url('/' . $locale . '/' . ltrim($currentRoute, '/'));
        }

        return $alternateUrls;
    }

    /**
     * Generate breadcrumbs for SEO
     */
    public function generateBreadcrumbs($items)
    {
        $breadcrumbs = [
            [
                'name' => __('interface.nav.home'),
                'url' => url('/')
            ]
        ];

        foreach ($items as $item) {
            $breadcrumbs[] = $item;
        }

        return $breadcrumbs;
    }

    /**
     * Generate FAQ data for structured data
     */
    public function getFaqData($locale)
    {
        $faqs = [
            'ar' => [
                [
                    'question' => 'كيف يمكنني حجز رحلة مع دهب دريم تورز؟',
                    'answer' => 'يمكنك حجز رحلتك بسهولة من خلال موقعنا الإلكتروني أو الاتصال بخدمة العملاء على مدار 24 ساعة.'
                ],
                [
                    'question' => 'ما هي وسائل الدفع المتاحة؟',
                    'answer' => 'نقبل جميع وسائل الدفع الرئيسية بما في ذلك البطاقات الائتمانية والتحويل البنكي والدفع النقدي.'
                ],
                [
                    'question' => 'هل يمكنني إلغاء أو تعديل حجزي؟',
                    'answer' => 'نعم، يمكنك إلغاء أو تعديل حجزك وفقاً لسياسة الإلغاء الخاصة بنا. يرجى مراجعة الشروط والأحكام.'
                ]
            ],
            'en' => [
                [
                    'question' => 'How can I book a trip with Dahab Dream Tours?',
                    'answer' => 'You can easily book your trip through our website or by calling our 24/7 customer service.'
                ],
                [
                    'question' => 'What payment methods are available?',
                    'answer' => 'We accept all major payment methods including credit cards, bank transfer, and cash payment.'
                ],
                [
                    'question' => 'Can I cancel or modify my booking?',
                    'answer' => 'Yes, you can cancel or modify your booking according to our cancellation policy. Please review our terms and conditions.'
                ]
            ]
        ];

        return $faqs[$locale] ?? $faqs['en'];
    }
}
