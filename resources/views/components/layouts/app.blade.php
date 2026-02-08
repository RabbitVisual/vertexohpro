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
    @stack('head')
    @stack('styles')
</head>
<body class="font-sans text-text bg-background antialiased overflow-x-hidden transition-colors duration-500"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true'
      }"
      :class="{ 'dark': darkMode }"
      x-init="
          $nextTick(() => {
              if (darkMode) document.documentElement.classList.add('dark');
              else document.documentElement.classList.remove('dark');
          });
          $watch('darkMode', val => {
              localStorage.setItem('theme', val ? 'dark' : 'light');
              if (val) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          });
          $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val))
      "
>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300 w-full"
              :class="sidebarCollapsed ? 'ml-20' : 'ml-64'">

            {{ $slot }}

            <!-- Command Center (CMD+K) -->
            <livewire:command-palette />

        </main>
    </div>

    <x-loading-overlay />
    <x-toast />

    @stack('scripts')
</body>
</html>
