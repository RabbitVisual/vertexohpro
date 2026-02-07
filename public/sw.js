const CACHE_NAME = 'vertex-oh-pro-v1';
const CACHE_ASSETS = [
    '/',
    '/manifest.json',
    '/resources/fonts/poppins-v24-latin-regular.woff2',
    '/resources/fonts/poppins-v24-latin-700.woff2',
    // Add other critical fonts here if needed
];

// Install Event
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('Service Worker: Caching Assets');
            return cache.addAll(CACHE_ASSETS);
        })
    );
});

// Activate Event
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    if (cache !== CACHE_NAME) {
                        console.log('Service Worker: Clearing Old Cache');
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
});

// Fetch Event
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    // Cache First for specific routes and assets
    if (
        url.pathname.startsWith('/teacherpanels') ||
        url.pathname.startsWith('/classrecord/students') ||
        url.pathname.startsWith('/build/') ||
        url.pathname.startsWith('/resources/')
    ) {
        event.respondWith(
            caches.match(event.request).then(response => {
                if (response) {
                    return response; // Return cached version
                }
                return fetch(event.request).then(networkResponse => {
                    // Clone and Cache the response
                    if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                        const responseToCache = networkResponse.clone();
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, responseToCache);
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    // Optional: Return fallback page if offline and not cached
                    if (url.pathname.startsWith('/teacherpanels')) {
                         return caches.match('/teacherpanels'); // Try to return the cached dashboard itself if available
                    }
                });
            })
        );
    } else {
        // Network First for API and other routes
        event.respondWith(
            fetch(event.request).catch(() => caches.match(event.request))
        );
    }
});
