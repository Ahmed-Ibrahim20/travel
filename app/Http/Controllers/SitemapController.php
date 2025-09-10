<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Tour;
use App\Models\Destination;
use Carbon\Carbon;

class SitemapController extends Controller
{
    /**
     * Generate main sitemap index
     */
    public function index()
    {
        $sitemaps = [
            [
                'loc' => url('/sitemap-static.xml'),
                'lastmod' => now()->toISOString()
            ],
            [
                'loc' => url('/sitemap-destinations.xml'),
                'lastmod' => Destination::latest('updated_at')->first()?->updated_at?->toISOString() ?? now()->toISOString()
            ],
            [
                'loc' => url('/sitemap-tours.xml'),
                'lastmod' => Tour::latest('updated_at')->first()?->updated_at?->toISOString() ?? now()->toISOString()
            ]
        ];

        $xml = view('seo.sitemap-index', compact('sitemaps'))->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate static pages sitemap
     */
    public function static()
    {
        $urls = [
            [
                'loc' => url('/'),
                'lastmod' => now()->toISOString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
                'alternates' => [
                    'ar' => url('/ar'),
                    'en' => url('/en'),
                    'de' => url('/de'),
                    'fr' => url('/fr')
                ]
            ],
            [
                'loc' => url('/tours'),
                'lastmod' => Tour::latest('updated_at')->first()?->updated_at?->toISOString() ?? now()->toISOString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
                'alternates' => [
                    'ar' => url('/ar/tours'),
                    'en' => url('/en/tours'),
                    'de' => url('/de/tours'),
                    'fr' => url('/fr/tours')
                ]
            ],
            [
                'loc' => url('/destinations'),
                'lastmod' => Destination::latest('updated_at')->first()?->updated_at?->toISOString() ?? now()->toISOString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
                'alternates' => [
                    'ar' => url('/ar/destinations'),
                    'en' => url('/en/destinations'),
                    'de' => url('/de/destinations'),
                    'fr' => url('/fr/destinations')
                ]
            ],
            [
                'loc' => url('/contact'),
                'lastmod' => now()->subDays(30)->toISOString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
                'alternates' => [
                    'ar' => url('/ar/contact'),
                    'en' => url('/en/contact'),
                    'de' => url('/de/contact'),
                    'fr' => url('/fr/contact')
                ]
            ]
        ];

        $xml = view('seo.sitemap-urlset', compact('urls'))->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate destinations sitemap
     */
    public function destinations()
    {
        $destinations = Destination::all();
        $urls = [];

        foreach ($destinations as $destination) {
            $urls[] = [
                'loc' => url('/destinations/' . $destination->slug),
                'lastmod' => $destination->updated_at->toISOString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
                'alternates' => [
                    'ar' => url('/ar/destinations/' . $destination->slug),
                    'en' => url('/en/destinations/' . $destination->slug),
                    'de' => url('/de/destinations/' . $destination->slug),
                    'fr' => url('/fr/destinations/' . $destination->slug)
                ]
            ];

            // Add tour type specific pages
            $tourTypes = ['hotel', 'honeymoon', 'trip'];
            foreach ($tourTypes as $type) {
                $urls[] = [
                    'loc' => url('/tours/' . $destination->slug . '/' . $type),
                    'lastmod' => $destination->updated_at->toISOString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                    'alternates' => [
                        'ar' => url('/ar/tours/' . $destination->slug . '/' . $type),
                        'en' => url('/en/tours/' . $destination->slug . '/' . $type),
                        'de' => url('/de/tours/' . $destination->slug . '/' . $type),
                        'fr' => url('/fr/tours/' . $destination->slug . '/' . $type)
                    ]
                ];
            }
        }

        $xml = view('seo.sitemap-urlset', compact('urls'))->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate tours sitemap
     */
    public function tours()
    {
        $tours = Tour::with('destination')->get();
        $urls = [];

        foreach ($tours as $tour) {
            $urls[] = [
                'loc' => url('/tours/' . $tour->id),
                'lastmod' => $tour->updated_at->toISOString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
                'alternates' => [
                    'ar' => url('/ar/tours/' . $tour->id),
                    'en' => url('/en/tours/' . $tour->id),
                    'de' => url('/de/tours/' . $tour->id),
                    'fr' => url('/fr/tours/' . $tour->id)
                ],
                'images' => $tour->image_urls ?? []
            ];
        }

        $xml = view('seo.sitemap-urlset', compact('urls'))->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate images sitemap
     */
    public function images()
    {
        $tours = Tour::whereNotNull('image_urls')->get();
        $destinations = Destination::whereNotNull('image')->get();
        $images = [];

        // Tour images
        foreach ($tours as $tour) {
            if ($tour->image_urls && is_array($tour->image_urls)) {
                foreach ($tour->image_urls as $imageUrl) {
                    $images[] = [
                        'loc' => url('/tours/' . $tour->id),
                        'image_loc' => $imageUrl,
                        'image_caption' => $tour->getTranslatedTitle(),
                        'image_title' => $tour->getTranslatedTitle(),
                        'image_geo_location' => $tour->destination->getTranslatedName() . ', Egypt'
                    ];
                }
            }
        }

        // Destination images
        foreach ($destinations as $destination) {
            if ($destination->image) {
                $images[] = [
                    'loc' => url('/destinations/' . $destination->slug),
                    'image_loc' => $destination->image,
                    'image_caption' => $destination->getTranslatedName(),
                    'image_title' => $destination->getTranslatedName(),
                    'image_geo_location' => $destination->getTranslatedName() . ', Egypt'
                ];
            }
        }

        $xml = view('seo.sitemap-images', compact('images'))->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
