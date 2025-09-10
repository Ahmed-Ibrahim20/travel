{{-- Performance Optimization Tags for Dahab Dream Tours --}}

{{-- Resource Hints --}}
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

{{-- DNS Prefetch for external resources --}}
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
<link rel="dns-prefetch" href="//www.google-analytics.com">
<link rel="dns-prefetch" href="//www.googletagmanager.com">

{{-- Preload critical resources --}}
<link rel="preload" href="{{ asset('assets/css/main.css') }}" as="style">
<link rel="preload" href="{{ asset('assets/js/app.js') }}" as="script">
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">

{{-- Critical CSS inline for above-the-fold content --}}
<style>
/* Critical CSS for Dahab Dream Tours */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

.hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    min-height: 60vh;
    display: flex;
    align-items: center;
    color: white;
}

.navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

.btn-custom {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* Loading spinner */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #1e40af;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Lazy loading placeholder */
.lazy-placeholder {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>

{{-- Defer non-critical CSS --}}
<link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></noscript>

<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"></noscript>

{{-- Service Worker Registration --}}
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
                console.log('SW registered: ', registration);
            })
            .catch(function(registrationError) {
                console.log('SW registration failed: ', registrationError);
            });
    });
}
</script>

{{-- Lazy Loading Script --}}
<script>
// Intersection Observer for lazy loading
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    });
}
</script>

{{-- Web Vitals Monitoring --}}
<script>
// Core Web Vitals monitoring
function sendToAnalytics(metric) {
    // Send to your analytics service
    console.log('Web Vital:', metric);
}

// Largest Contentful Paint
new PerformanceObserver((entryList) => {
    for (const entry of entryList.getEntries()) {
        sendToAnalytics({
            name: 'LCP',
            value: entry.startTime,
            id: 'dahab-dream-tours'
        });
    }
}).observe({entryTypes: ['largest-contentful-paint']});

// First Input Delay
new PerformanceObserver((entryList) => {
    for (const entry of entryList.getEntries()) {
        sendToAnalytics({
            name: 'FID',
            value: entry.processingStart - entry.startTime,
            id: 'dahab-dream-tours'
        });
    }
}).observe({entryTypes: ['first-input']});

// Cumulative Layout Shift
let clsValue = 0;
let clsEntries = [];
new PerformanceObserver((entryList) => {
    for (const entry of entryList.getEntries()) {
        if (!entry.hadRecentInput) {
            clsValue += entry.value;
            clsEntries.push(entry);
        }
    }
    sendToAnalytics({
        name: 'CLS',
        value: clsValue,
        id: 'dahab-dream-tours'
    });
}).observe({entryTypes: ['layout-shift']});
</script>
