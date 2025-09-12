<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
<!-- <flux:header 
    container 
    class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 backdrop-blur-sm sticky top-0 z-50 transition-colors duration-200"
>
    <div class="flex items-center justify-between w-full">
        <div class="flex items-center gap-4">
            <flux:sidebar.toggle 
                class="lg:hidden" 
                icon="bars-3" 
                inset="left"
                aria-label="Toggle menu"
            />

            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <x-app-logo class="size-8 transition-transform duration-200 hover:scale-105" href="#"></x-app-logo>            
            </a>
        </div>

        <div class="hidden lg:block flex-1 mx-8">
            <flux:navbar class="justify-center">
                <flux:navbar.item 
                    icon="shopping-bag" 
                    href="{{ route('selforder.order') }}" 
                    :current="request()->routeIs('selforder.order')"
                    class="relative group px-4 py-2.5 transition-all duration-200"
                >
                    <span class="relative z-10">Self Order</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                </flux:navbar.item>

                @can('view products')
                    <flux:navbar.item 
                        icon="shopping-bag" 
                        href="{{ route('cashier.pos') }}" 
                        :current="request()->routeIs('cashier.pos')"
                        class="relative group px-4 py-2.5 transition-all duration-200"
                    >
                        <span class="relative z-10">POS</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                    </flux:navbar.item>
                @endcan
                @can('view transactions')
                    <flux:navbar.item 
                        icon="receipt-percent" 
                        href="{{ route('cashier.transactions.index') }}" 
                        :current="request()->routeIs('cashier.transactions.index')"
                        class="relative group px-4 py-2.5 transition-all duration-200"
                    >
                        <span class="relative z-10">Transactions</span>
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                    </flux:navbar.item>
                @endcan
            </flux:navbar>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden md:block" x-data="{ theme: $flux.appearance }" x-init="
                $watch('theme', value => $flux.appearance = value);
                $watch('$flux.appearance', value => theme = value);
            ">
                <flux:radio.group variant="segmented" x-model="theme" class="!border-transparent !bg-transparent !p-0 gap-1">
                    <flux:radio value="light" icon="sun" class="!bg-gray-100 dark:!bg-gray-800 !p-1.5 !px-3" />
                    <flux:radio value="dark" icon="moon" class="!bg-gray-100 dark:!bg-gray-800 !p-1.5 !px-3" />
                </flux:radio.group>
            </div>

            @auth
                @if (Session::has('admin_user_id'))
                    <div class="py-1">
                        <form id="stop-impersonating" class="flex" action="{{ route('impersonate.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <flux:button 
                                type="submit" 
                                size="sm" 
                                variant="soft" 
                                form="stop-impersonating"
                                class="text-red-500 hover:text-red-600 dark:hover:text-red-400 border-red-200 dark:border-red-900/30 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors"
                            >
                                <flux:icon.user-minus class="mr-1.5 h-4 w-4" />
                                {{ __('users.stop_impersonating') }}
                            </flux:button>
                        </form>
                    </div>
                @endif

                <flux:dropdown 
                    position="bottom" 
                    align="end"
                    class="transition-all duration-200"
                >
                    <flux:profile
                        class="cursor-pointer hover:ring-2 hover:ring-blue-500/20 dark:hover:ring-blue-400/20 transition-all duration-200"
                        :initials="auth()->user()->initials()"
                        aria-label="User menu"
                    />

                    <flux:menu class="w-64 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xl transition-colors duration-200">
                        <flux:menu.radio.group>
                            <div class="p-3 border-b border-gray-100 dark:border-gray-700/50">
                                <div class="flex items-center gap-3">
                                    <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-xl">
                                        <span class="flex h-full w-full items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>
                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator class="bg-gray-100 dark:bg-gray-700/50" />

                        @can('access dashboard admin')
                            <flux:menu.radio.group>
                                <flux:menu.item 
                                    href="{{ route('admin.index') }}" 
                                    icon="shield-check" 
                                    class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150"
                                >
                                    {{ __('global.admin_dashboard') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>
                        @endcan
                        @can('access dashboard manager')
                            <flux:menu.radio.group>
                                <flux:menu.item 
                                    href="{{ route('manager.index') }}" 
                                    icon="shield-check" 
                                    class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150"
                                >
                                    {{ __('global.manager_dashboard') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>
                        @endcan

                        <flux:menu.separator class="bg-gray-100 dark:bg-gray-700/50" />

                        <flux:menu.radio.group>
                            <flux:menu.item 
                                href="/settings/profile" 
                                icon="cog-6-tooth" 
                                class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150"
                            >
                                {{ __('settings.title') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator class="bg-gray-100 dark:bg-gray-700/50" />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item 
                                as="button" 
                                type="submit" 
                                icon="arrow-right-start-on-rectangle" 
                                class="w-full hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300"
                            >
                                {{ __('global.log_out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @endauth
        </div>
    </div>
</flux:header> -->

<!-- Mobile Menu -->
<!-- <flux:sidebar 
    stashable 
    sticky 
    class="lg:hidden border-r border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800/95 transition-colors duration-200"
>
    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
    </div>

    @auth
        <flux:navlist variant="outline" class="py-2 p-4">
            <flux:navlist.group 
                heading="Main Menu" 
                class="px-4 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider"
            >
                <flux:navlist.item 
                    icon="shopping-bag" 
                    href="{{ route('selforder.order') }}" 
                    :current="request()->routeIs('selforder.order')"
                    class="relative group px-4 py-2.5 transition-all duration-200"
                >
                    <span class="relative z-10">Self Order</span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 rounded-full transition-all duration-300 group-hover:w-full"></span>
                </flux:navlist.item>
                @can('view products')
                    <flux:navlist.item 
                        icon="shopping-bag" 
                        href="{{ route('cashier.pos') }}" 
                        :current="request()->routeIs('cashier.pos')"
                        class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                    >
                        POS
                    </flux:navlist.item>
                @endcan
                @can('view transactions')
                    <flux:navlist.item 
                        icon="receipt-percent" 
                        href="{{ route('cashier.transactions.index') }}" 
                        :current="request()->routeIs('cashier.transactions.index')"
                        class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                    >
                        Transaction History
                    </flux:navlist.item>
                @endcan
            </flux:navlist.group>
        </flux:navlist>
    @endauth

    <flux:spacer/>

    @guest
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="grid gap-2">
                <flux:button 
                    href="{{ route('login') }}" 
                    variant="outline" 
                    class="w-full text-gray-700 dark:text-gray-200 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors"
                >
                    {{ __('global.log_in') }}
                </flux:button>
                @if (Route::has('register'))
                    <flux:button 
                        href="{{ route('register') }}" 
                        variant="primary"
                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 transition-all duration-200"
                    >
                        {{ __('global.register') }}
                    </flux:button>
                @endif
            </div>
        </div>
    @endguest
</flux:sidebar> -->

<flux:main 
    container 
    class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900/50 transition-colors duration-200"
>
    <div class="flex-1 flex flex-col">
        {{ $slot }}
    </div>
    @include('partials.footer')
</flux:main>

@push('scripts')
<script>
    // Theme toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        const lightIcon = document.getElementById('light-icon');
        const darkIcon = document.getElementById('dark-icon');
        
        // Check for saved theme preference or respect OS preference
        const savedTheme = localStorage.getItem('theme');
        const osPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Apply the theme
        if (savedTheme === 'dark' || (!savedTheme && osPrefersDark)) {
            document.documentElement.classList.add('dark');
            lightIcon.classList.remove('hidden');
            darkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
        }
        
        // Toggle theme on button click
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            if (isDark) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        });
        
        // Listen for OS theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (!localStorage.getItem('theme')) {
                document.documentElement.classList.toggle('dark', event.matches);
            }
        });
    });
</script>
@endpush

@fluxScripts
</body>
</html>