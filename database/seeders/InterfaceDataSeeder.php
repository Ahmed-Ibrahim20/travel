<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\RatePlan;

class InterfaceDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Destinations with multilingual support
        $destinations = [
            [
                'name' => [
                    'en' => 'Hurghada',
                    'de' => 'Hurghada',
                    'fr' => 'Hurghada'
                ],
                'slug' => 'hurghada',
                'description' => [
                    'en' => 'Beautiful Red Sea destination with pristine beaches and coral reefs',
                    'de' => 'Wunderschönes Rotes Meer Reiseziel mit unberührten Stränden und Korallenriffen',
                    'fr' => 'Belle destination de la mer Rouge avec des plages vierges et des récifs coralliens'
                ],
                'image' => 'destinations/hurghada.jpg',
                'user_add_id' => 1
            ],
            [
                'name' => [
                    'en' => 'Sharm El-Sheikh',
                    'de' => 'Sharm El-Sheikh',
                    'fr' => 'Sharm El-Sheikh'
                ],
                'slug' => 'sharm-el-sheikh',
                'description' => [
                    'en' => 'World-class diving destination at the southern tip of Sinai',
                    'de' => 'Weltklasse-Tauchziel an der Südspitze des Sinai',
                    'fr' => 'Destination de plongée de classe mondiale à la pointe sud du Sinaï'
                ],
                'image' => 'destinations/sharm_el_sheikh.jpg',
                'user_add_id' => 1
            ],
            [
                'name' => [
                    'en' => 'Ain Sokhna',
                    'de' => 'Ain Sokhna',
                    'fr' => 'Ain Sokhna'
                ],
                'slug' => 'ain-sokhna',
                'description' => [
                    'en' => 'Closest beach resort to Cairo with therapeutic hot springs',
                    'de' => 'Nächstgelegenes Strandresort zu Kairo mit therapeutischen heißen Quellen',
                    'fr' => 'Station balnéaire la plus proche du Caire avec des sources chaudes thérapeutiques'
                ],
                'image' => 'destinations/sokhna.webp',
                'user_add_id' => 1
            ],
            [
                'name' => [
                    'en' => 'Dahab',
                    'de' => 'Dahab',
                    'fr' => 'Dahab'
                ],
                'slug' => 'dahab',
                'description' => [
                    'en' => 'Laid-back diving paradise with the famous Blue Hole',
                    'de' => 'Entspanntes Tauchparadies mit dem berühmten Blue Hole',
                    'fr' => 'Paradis de plongée décontracté avec le célèbre Blue Hole'
                ],
                'image' => 'destinations/dahab.jpg',
                'user_add_id' => 1
            ],
            [
                'name' => [
                    'en' => 'Marsa Alam',
                    'de' => 'Marsa Alam',
                    'fr' => 'Marsa Alam'
                ],
                'slug' => 'marsa-alam',
                'description' => [
                    'en' => 'Pristine diving destination with untouched coral reefs',
                    'de' => 'Unberührtes Tauchziel mit intakten Korallenriffen',
                    'fr' => 'Destination de plongée vierge avec des récifs coralliens intacts'
                ],
                'image' => 'destinations/marsa_alam.jpg',
                'user_add_id' => 1
            ],
            [
                'name' => [
                    'en' => 'Maldives',
                    'de' => 'Malediven',
                    'fr' => 'Maldives'
                ],
                'slug' => 'maldives',
                'description' => [
                    'en' => 'Tropical paradise with overwater bungalows',
                    'de' => 'Ultimatives tropisches Paradies mit Überwasser-Bungalows',
                    'fr' => 'Paradis tropical avec des bungalows sur pilotis'
                ],
                'image' => 'destinations/maldives.jpg',
                'user_add_id' => 1
            ]
        ];

        foreach ($destinations as $destData) {
            $destination = Destination::create($destData);

            // Create tours for each destination
            $this->createToursForDestination($destination);
        }

        // Create testimonials
    }

    private function createToursForDestination($destination)
    {
        $tours = [];

        switch ($destination->slug) {
            case 'hurghada':
                $tours = [
                    [
                        'title' => [
                            'en' => 'Hurghada Beach Resort - 4 Days',
                            'de' => 'Hurghada Strandresort - 4 Tage',
                            'fr' => 'Resort de plage Hurghada - 4 jours'
                        ],
                        'description' => [
                            'en' => 'Enjoy pristine beaches and crystal clear waters at our premium beach resort',
                            'de' => 'Genießen Sie unberührte Strände und kristallklares Wasser in unserem Premium-Strandresort',
                            'fr' => 'Profitez de plages vierges et d\'eaux cristallines dans notre resort de plage premium'
                        ],
                        'image' => ['tours/hurghada-beach-1.jpg', 'tours/hurghada-beach-2.jpg'],
                        'duration_days' => 4,
                        'capacity' => 50,
                        'price' => 2500
                    ],
                    [
                        'title' => [
                            'en' => 'Hurghada Diving Adventure - 5 Days',
                            'de' => 'Hurghada Tauchabenteuer - 5 Tage',
                            'fr' => 'Aventure de plongée Hurghada - 5 jours'
                        ],
                        'description' => [
                            'en' => 'Explore the underwater world of the Red Sea with professional diving guides',
                            'de' => 'Erkunden Sie die Unterwasserwelt des Roten Meeres mit professionellen Tauchführern',
                            'fr' => 'Explorez le monde sous-marin de la mer Rouge avec des guides de plongée professionnels'
                        ],
                        'image' => ['tours/hurghada-diving-1.jpg', 'tours/hurghada-diving-2.jpg'],
                        'duration_days' => 5,
                        'capacity' => 30,
                        'price' => 3200
                    ],
                    [
                        'title' => [
                            'en' => 'Hurghada Luxury Resort - 6 Days',
                            'de' => 'Hurghada Luxusresort - 6 Tage',
                            'fr' => 'Resort de luxe Hurghada - 6 jours'
                        ],
                        'description' => [
                            'en' => 'Ultimate luxury experience with 5-star amenities and private beach access',
                            'de' => 'Ultimatives Luxuserlebnis mit 5-Sterne-Ausstattung und privatem Strandzugang',
                            'fr' => 'Expérience de luxe ultime avec des équipements 5 étoiles et accès privé à la plage'
                        ],
                        'image' => ['tours/hurghada-luxury-1.jpg', 'tours/hurghada-luxury-2.jpg'],
                        'duration_days' => 6,
                        'capacity' => 40,
                        'price' => 4500
                    ]
                ];
                break;

            case 'sharm-el-sheikh':
                $tours = [
                    [
                        'title' => [
                            'en' => 'Sharm El-Sheikh Deluxe - 5 Days',
                            'ar' => 'شرم الشيخ ديلوكس - 5 أيام',
                            'fr' => 'Sharm El-Sheikh Deluxe - 5 jours'
                        ],
                        'description' => [
                            'en' => 'Premium resort experience with world-class diving and entertainment',
                            'ar' => 'تجربة منتجع مميزة مع غوص وترفيه عالمي المستوى',
                            'fr' => 'Expérience de resort premium avec plongée et divertissement de classe mondiale'
                        ],
                        'image' => ['tours/sharm-deluxe-1.jpg', 'tours/sharm-deluxe-2.jpg'],
                        'duration_days' => 5,
                        'capacity' => 45,
                        'price' => 3800
                    ],
                    [
                        'title' => [
                            'en' => 'Sharm Family Package - 4 Days',
                            'ar' => 'باقة شرم العائلية - 4 أيام',
                            'fr' => 'Package familial Sharm - 4 jours'
                        ],
                        'description' => [
                            'en' => 'Perfect family vacation with kids club and family-friendly activities',
                            'ar' => 'عطلة عائلية مثالية مع نادي الأطفال وأنشطة مناسبة للعائلة',
                            'fr' => 'Vacances familiales parfaites avec club enfants et activités familiales'
                        ],
                        'image' => ['tours/sharm-family-1.jpg', 'tours/sharm-family-2.jpg'],
                        'duration_days' => 4,
                        'capacity' => 60,
                        'price' => 2800
                    ]
                ];
                break;

            case 'ain-sokhna':
                $tours = [
                    [
                        'title' => [
                            'en' => 'Ain Sokhna Getaway - 3 Days',
                            'ar' => 'رحلة العين السخنة - 3 أيام',
                            'fr' => 'Escapade Ain Sokhna - 3 jours'
                        ],
                        'description' => [
                            'en' => 'Quick escape to the Red Sea with therapeutic hot springs',
                            'ar' => 'هروب سريع إلى البحر الأحمر مع الينابيع الساخنة العلاجية',
                            'fr' => 'Évasion rapide vers la mer Rouge avec sources chaudes thérapeutiques'
                        ],
                        'image' => ['tours/sokhna-getaway-1.jpg', 'tours/sokhna-getaway-2.jpg'],
                        'duration_days' => 3,
                        'capacity' => 35,
                        'price' => 1800
                    ],
                    [
                        'title' => [
                            'en' => 'Sokhna Spa Retreat - 4 Days',
                            'ar' => 'خلوة سبا السخنة - 4 أيام',
                            'fr' => 'Retraite spa Sokhna - 4 jours'
                        ],
                        'description' => [
                            'en' => 'Relaxing spa experience with natural hot springs and wellness treatments',
                            'ar' => 'تجربة سبا مريحة مع الينابيع الساخنة الطبيعية وعلاجات العافية',
                            'fr' => 'Expérience spa relaxante avec sources chaudes naturelles et soins bien-être'
                        ],
                        'image' => ['tours/sokhna-spa-1.jpg', 'tours/sokhna-spa-2.jpg'],
                        'duration_days' => 4,
                        'capacity' => 25,
                        'price' => 2600
                    ]
                ];
                break;

            case 'dahab':
                $tours = [
                    [
                        'title' => [
                            'en' => 'Dahab Diving Experience - 4 Days',
                            'de' => 'Dahab Taucherlebnis - 4 Tage',
                            'fr' => 'Expérience de plongée Dahab - 4 jours'
                        ],
                        'description' => [
                            'en' => 'Explore the famous Blue Hole and Bells diving sites',
                            'de' => 'Erkunden Sie das berühmte Blue Hole und die Bells Tauchplätze',
                            'fr' => 'Explorez le célèbre Blue Hole et les sites de plongée Bells'
                        ],
                        'image' => ['tours/dahab-diving-1.jpg', 'tours/dahab-diving-2.jpg'],
                        'duration_days' => 4,
                        'capacity' => 20,
                        'price' => 2200
                    ]
                ];
                break;

            case 'marsa-alam':
                $tours = [
                    [
                        'title' => [
                            'en' => 'Marsa Alam Eco Resort - 5 Days',
                            'ar' => 'منتجع مرسى علم البيئي - 5 أيام',
                            'fr' => 'Eco Resort Marsa Alam - 5 jours'
                        ],
                        'description' => [
                            'en' => 'Eco-friendly resort with pristine coral reefs and marine life',
                            'ar' => 'منتجع صديق للبيئة مع الشعاب المرجانية البكر والحياة البحرية',
                            'fr' => 'Resort écologique avec récifs coralliens vierges et vie marine'
                        ],
                        'image' => ['tours/marsa-alam-eco-1.jpg', 'tours/marsa-alam-eco-2.jpg'],
                        'duration_days' => 5,
                        'capacity' => 30,
                        'price' => 3400
                    ]
                ];
                break;

            case 'maldives':
                $tours = [
                    [
                        'title' => [
                            'en' => 'Maldives Paradise - 7 Days',
                            'ar' => 'جنة المالديف - 7 أيام',
                            'fr' => 'Paradis des Maldives - 7 jours'
                        ],
                        'description' => [
                            'en' => 'Ultimate tropical paradise with overwater villas and pristine beaches',
                            'ar' => 'جنة استوائية مطلقة مع فيلات فوق الماء وشواطئ بكر',
                            'fr' => 'Paradis tropical ultime avec villas sur pilotis et plages vierges'
                        ],
                        'image' => ['tours/maldives-paradise-1.jpg', 'tours/maldives-paradise-2.jpg'],
                        'duration_days' => 7,
                        'capacity' => 15,
                        'price' => 8500
                    ]
                ];
                break;
        }

        foreach ($tours as $tourData) {
            $tour = Tour::create([
                'destination_id' => $destination->id,
                'title' => $tourData['title'],
                'description' => $tourData['description'],
                'image' => $tourData['image'],
                'duration_days' => $tourData['duration_days'],
                'capacity' => $tourData['capacity'],
                'user_add_id' => 1
            ]);

            // Create rate plans for each tour
            $ratePlans = [
                [
                    'name' => [
                        'en' => 'Standard Package',
                        'de' => 'Standard-Paket',
                        'fr' => 'Package Standard'
                    ],
                    'price' => $tourData['price'],
                    'currency' => 'EGP',
                    'details' => [
                        'en' => 'Includes accommodation, meals, and basic activities',
                        'de' => 'Beinhaltet Unterkunft, Mahlzeiten und grundlegende Aktivitäten',
                        'fr' => 'Comprend l\'hébergement, les repas et les activités de base'
                    ]
                ],
                [
                    'name' => [
                        'en' => 'Premium Package',
                        'de' => 'Premium-Paket',
                        'fr' => 'Package Premium'
                    ],
                    'price' => $tourData['price'] * 1.3,
                    'currency' => 'EGP',
                    'details' => [
                        'en' => 'Includes all standard features plus premium services and excursions',
                        'de' => 'Beinhaltet alle Standard-Features plus Premium-Services und Ausflüge',
                        'fr' => 'Comprend toutes les fonctionnalités standard plus les services premium et excursions'
                    ]
                ]
            ];

            foreach ($ratePlans as $planData) {
                RatePlan::create([
                    'tour_id' => $tour->id,
                    'name' => $planData['name'],
                    'price' => $planData['price'],
                    'currency' => $planData['currency'],
                    'details' => $planData['details']
                ]);
            }
        }
    }

}
