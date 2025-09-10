<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
@foreach($images as $image)
    <url>
        <loc>{{ $image['loc'] }}</loc>
        <image:image>
            <image:loc>{{ $image['image_loc'] }}</image:loc>
            <image:caption>{{ $image['image_caption'] }}</image:caption>
            <image:title>{{ $image['image_title'] }}</image:title>
            <image:geo_location>{{ $image['image_geo_location'] }}</image:geo_location>
        </image:image>
    </url>
@endforeach
</urlset>
