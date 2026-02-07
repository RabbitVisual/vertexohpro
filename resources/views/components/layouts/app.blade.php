<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          sidebarCollapsed: false,
          syncTheme(val) {
              const theme = val ? 'dark' : 'light';
              localStorage.setItem('theme', theme);
              if (val) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }

              // Sync with backend if user is authenticated
              @auth
                  fetch('{{ route('theme.update') }}', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                      },
                      body: JSON.stringify({ theme: theme })
                  }).catch(console.error);
              @endauth
          }
      }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => syncTheme(val))"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Vertex Oh Pro') }}</title>

    <!-- Anti-Flicker Script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 bg-slate-100 dark:bg-slate-950 antialiased overflow-x-hidden">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-core::components.sidebar />

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300 w-full"
              :class="sidebarCollapsed ? 'ml-20' : 'ml-64'">

            {{ $slot }}

        </main>
    </div>

    <x-core::components.toasts />
    <x-loading-overlay />
    <livewire:command-palette />

    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/sw.js").then(reg => console.log("SW Registered")).catch(err => console.log("SW Fail", err));
            });
        }
    </script>
</body>
</html>
