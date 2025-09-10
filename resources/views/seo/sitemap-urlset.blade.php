<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($urls as $url)
    <url>
        <loc>{{ $url['loc'] }}</loc>
        <lastmod>{{ $url['lastmod'] }}</lastmod>
        <changefreq>{{ $url['changefreq'] }}</changefreq>
        <priority>{{ $url['priority'] }}</priority>
        
        @if(isset($url['alternates']))
            @foreach($url['alternates'] as $lang => $altUrl)
                <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ $altUrl }}" />
            @endforeach
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ $url['loc'] }}" />
        @endif
        
        @if(isset($url['images']) && is_array($url['images']))
            @foreach($url['images'] as $image)
                <image:image>
                    <image:loc>{{ $image }}</image:loc>
                    <image:caption>{{ $url['image_caption'] ?? 'Dahab Dream Tours - Egypt Travel' }}</image:caption>
                </image:image>
            @endforeach
        @endif
    </url>
@endforeach
</urlset>
