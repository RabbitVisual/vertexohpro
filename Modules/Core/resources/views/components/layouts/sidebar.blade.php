<div class="flex flex-col w-64 h-full bg-slate-900 text-slate-300 border-r border-slate-800 flex-shrink-0">
    <div class="flex items-center justify-center h-16 border-b border-slate-800">
        <span class="text-xl font-bold text-white">Vertex Oh Pro</span>
    </div>

    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
        @foreach(config('icons.modules', []) as $module => $config)
            @php
                $roles = $config['roles'] ?? ['*'];
                $user = auth()->user();

                // Skip if user doesn't have required roles (unless '*' is present or no user logged in - though sidebar usually requires auth)
                if ($user && !in_array('*', $roles) && !$user->hasAnyRole($roles)) {
                    continue;
                }

                $routeName = $module . '.index';
                // Some modules might have specific dashboard routes
                if ($module === 'admin') $routeName = 'admin.dashboard'; // Example override if needed, but sticking to index for now

                $isActive = request()->routeIs($module . '.*') || request()->is($module . '*');
                $icon = $config['icon'] ?? 'circle-question'; // Fallback
                $label = $config['label'] ?? ucfirst($module); // Fallback
            @endphp
            <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}"
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150 ease-in-out
                      {{ $isActive ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <x-icon name="{{ $icon }}" class="mr-3 flex-shrink-0 h-5 w-5 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" />
                <span class="capitalize">{{ $label }}</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-slate-800 p-4">
        <div class="flex items-center mb-4 px-3">
             <div class="flex-shrink-0">
                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()?->photo_url ?? asset('assets/images/default-avatar.png') }}" alt="">
             </div>
             <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ auth()->user()?->first_name ?? 'Usuário' }}</p>
                <p class="text-xs font-medium text-slate-400">{{ auth()->user()?->getRoleNames()->first() ?? 'Sem cargo' }}</p>
             </div>
        </div>
         <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
            @csrf
            <button type="submit" class="group flex w-full items-center px-3 py-2 text-sm font-medium text-slate-300 rounded-md hover:bg-slate-800 hover:text-white transition-colors duration-150 ease-in-out">
                <x-icon name="sign-out" class="mr-3 flex-shrink-0 h-5 w-5 text-slate-400 group-hover:text-white" />
                Sair
            </button>
        </form>
    </div>
</div>
