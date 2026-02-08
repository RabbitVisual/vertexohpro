<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body class="font-sans text-text bg-background antialiased overflow-x-hidden transition-colors duration-500"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          syncTheme(val) {
              const theme = val ? 'dark' : 'light';
              localStorage.setItem('theme', theme);
              if (val) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      :class="{ 'dark': darkMode }"
      x-init="
          $nextTick(() => {
              if (darkMode) document.documentElement.classList.add('dark');
              else document.documentElement.classList.remove('dark');
          });
          $watch('darkMode', val => syncTheme(val))
      "
>

    <div class="min-h-screen">
        {{ $slot }}
    </div>

    {{-- <x-core::components.toasts /> --}}
    <x-loading-overlay />

</body>
</html>
