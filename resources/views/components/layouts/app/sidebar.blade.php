<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
<flux:sidebar 
    sticky 
    stashable 
    class="border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 backdrop-blur-sm transition-colors duration-200"
>
    <!-- Header Section -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <x-app-logo class="size-8 transition-transform duration-200 hover:scale-105"></x-app-logo>
            </a>
            <flux:sidebar.toggle 
                class="lg:hidden" 
                icon="x-mark" 
                aria-label="Close menu"
            />
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="flex-1 overflow-y-auto py-2">
        <flux:navlist variant="outline" class="space-y-1 px-2">
            <!-- Back to Frontend Button -->
            <div class="px-3 py-2 mb-2">
                <a href="{{ route('home') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <flux:icon.arrow-left class="h-4 w-4" />
                    <span>Back to Frontend</span>
                </a>
            </div>

            @can('access dashboard manager')
                <flux:navlist.group 
                    heading="Dashboard" 
                    class="px-3 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider mb-2"
                >
                    <flux:navlist.item 
                        icon="home" 
                        :href="route('manager.index')" 
                        :current="request()->routeIs('manager.index')"
                        class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                    >
                        <span class="flex items-center">
                            <span class="mr-3 transition-transform duration-200 group-hover:scale-110">Dashboard</span>
                            <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </span>
                    </flux:navlist.item>
                </flux:navlist.group>
            @endcan
            
            @canany(['view products', 'view discounts', 'view transactions'])
                <flux:navlist.group 
                    heading="Sales Management" 
                    class="px-3 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider mb-2"
                >
                    @can('view products')
                        <flux:navlist.item 
                            icon="cube" 
                            :href="route('manager.products.index')" 
                            :current="request()->routeIs('manager.products.*')"
                            class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                        >
                            <span class="flex items-center">
                                <span class="mr-3 transition-transform duration-200 group-hover:scale-105">Products</span>
                                <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </span>
                        </flux:navlist.item>
                    @endcan
                    @can('view discounts')
                        <flux:navlist.item 
                            icon="tag" 
                            :href="route('manager.discounts.index')" 
                            :current="request()->routeIs('manager.discounts.*')"
                            class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                        >
                            <span class="flex items-center">
                                <span class="mr-3 transition-transform duration-200 group-hover:scale-105">Discounts</span>
                                <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </span>
                        </flux:navlist.item>
                    @endcan
                    @can('view transactions')
                        <flux:navlist.item 
                            icon="document-text" 
                            :href="route('manager.transactions.index')" 
                            :current="request()->routeIs('manager.transactions.*')"
                            class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                        >
                            <span class="flex items-center">
                                <span class="mr-3 transition-transform duration-200 group-hover:scale-105">Transactions</span>
                                <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </span>
                        </flux:navlist.item>
                    @endcan
                </flux:navlist.group>
            @endcanany
            
            @canany(['view users', 'view roles', 'view permissions'])
                <flux:navlist.group 
                    heading="User Management" 
                    class="px-3 font-semibold text-gray-600 dark:text-gray-400 text-sm uppercase tracking-wider mb-2"
                >
                    @can('view users')
                        <flux:navlist.item 
                            icon="user" 
                            :href="route('admin.users.index')" 
                            :current="request()->routeIs('admin.users.*')"
                            class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                        >
                            <span class="flex items-center">
                                <span class="mr-3 transition-transform duration-200 group-hover:scale-105">{{ __('users.title') }}</span>
                                <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </span>
                        </flux:navlist.item>
                    @endcan
                    @can('view roles')
                        <flux:navlist.item 
                            icon="shield-user" 
                            :href="route('admin.roles.index')" 
                            :current="request()->routeIs('admin.roles.*')"
                            class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                        >
                            <span class="flex items-center">
                                <span class="mr-3 transition-transform duration-200 group-hover:scale-105">{{ __('roles.title') }}</span>
                                <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </span>
                        </flux:navlist.item>
                    @endcan
                    @can('view permissions')
                        <flux:navlist.item 
                            icon="shield-check" 
                            :href="route('admin.permissions.index')" 
                            :current="request()->routeIs('admin.permissions.*')"
                            class="group px-3 py-2.5 rounded-xl transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700/50"
                        >
                            <span class="flex items-center">
                                <span class="mr-3 transition-transform duration-200 group-hover:scale-105">{{ __('permissions.title') }}</span>
                                <span class="ml-auto opacity-0 group-[.active]:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </span>
                        </flux:navlist.item>
                    @endcan
                </flux:navlist.group>
            @endcanany
        </flux:navlist>
    </div>

    <!-- Footer Section -->
    <div class="border-t border-gray-200 dark:border-gray-700/50 pt-4 pb-6 px-4 mt-auto">
        @if (Session::has('admin_user_id'))
            <div class="py-3 px-3 bg-red-50 dark:bg-red-900/20 rounded-lg mb-4">
                <form id="stop-impersonating" class="flex flex-col" action="{{ route('impersonate.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="text-xs text-red-700 dark:text-red-300 mb-2">
                        {{ __('users.you_are_impersonating') }}:
                        <strong class="text-red-900 dark:text-red-100">{{ auth()->user()->name }}</strong>
                    </p>
                    <flux:button 
                        type="submit" 
                        size="sm" 
                        variant="soft" 
                        form="stop-impersonating"
                        class="w-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                    >
                        <flux:icon.user-minus class="mr-1.5 h-4 w-4" />
                        {{ __('users.stop_impersonating') }}
                    </flux:button>
                </form>
            </div>
        @endif

        <!-- User Menu -->
        <flux:dropdown 
            position="bottom" 
            align="start"
            class="w-full"
        >
            <flux:profile
                class="w-full cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors duration-200 px-3 py-2"
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down"
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

                <flux:menu.radio.group>
                    <flux:menu.item 
                        href="/settings/profile" 
                        icon="cog-6-tooth" 
                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150"
                    >
                        {{ __('global.settings') }}
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
    </div>
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="lg:hidden border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left" aria-label="Toggle menu"/>
    <flux:spacer/>
    @auth
        <flux:dropdown position="top" align="end">
            <flux:profile
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down"
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

                <flux:menu.radio.group>
                    <flux:menu.item 
                        href="/settings/profile" 
                        icon="cog-6-tooth" 
                        class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150"
                    >
                        {{ __('global.settings') }}
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
</flux:header>

{{ $slot }}

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add active state styling to current nav items
        const activeItems = document.querySelectorAll('[aria-current="page"]');
        activeItems.forEach(item => {
            item.closest('.group').classList.add('active');
        });
        
        // Add smooth scrolling for long sidebar content
        const sidebar = document.querySelector('flux-sidebar');
        if (sidebar) {
            sidebar.style.scrollBehavior = 'smooth';
        }
    });
</script>
@endpush

@fluxScripts
<x-livewire-alert::scripts />
<x-livewire-alert::flash />
</body>
</html>