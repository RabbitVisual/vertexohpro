<x-layouts.app :title="$title ?? 'TeacherPanel Module'">
    {{ $slot }}

    @push('head')
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4f46e5">
    @endpush

    @push('scripts')
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
    @endpush
</x-layouts.app>

<x-teacherpanel::offline-indicator />
