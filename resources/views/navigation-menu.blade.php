<nav x-data="{ open: false }" class="bg-[#0D3453] border-b border-[#47663B] shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-7 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links (visible on larger screens) -->
                <div class="hidden  sm:space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-white hover:text-[#EED3B1]">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('skupiny.index') }}" :active="request()->routeIs('skupiny.index')" class="text-white hover:text-[#EED3B1]">
                        {{ __('Skupiny') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('lokality.index') }}" :active="request()->routeIs('lokality.index')" class="text-white hover:text-[#EED3B1]">
                        {{ __('Lokality') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('ulovky.index') }}" :active="request()->routeIs('ulovky.index')" class="text-white hover:text-[#EED3B1]">
                        {{ __('Úlovky') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('ulozene') }}" :active="request()->routeIs('ulozene')" class="text-white hover:text-[#EED3B1]">
                        {{ __('Uložené') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('zavody.index') }}" :active="request()->routeIs('zavody.index')" class="text-white hover:text-[#EED3B1]">
                        {{ __('Závody') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#47663B] bg-[#E8ECD7] hover:bg-[#EED3B1] rounded-md">
                                    {{ Auth::user()->currentTeam->name }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <div class="block px-4 py-2 text-xs text-[#47663B]">
                                        {{ __('Manage Team') }}
                                    </div>
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="text-[#47663B] hover:text-[#EED3B1]">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>
                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}" class="text-[#47663B] hover:text-[#EED3B1]">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-[#47663B]"></div>
                                        <div class="block px-4 py-2 text-xs text-[#47663B]">
                                            {{ __('Switch Teams') }}
                                        </div>
                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-[#47663B] transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md bg-primarniDarker">
                                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium text-white bg-primarniDarker hover:bg-primarni focus:outline-none focus:bg-primarni transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot  name="content">
                            <div class="block px-4 py-2 text-xs text-[#47663B]">
                                {{ __('Manage Account') }}
                            </div>
                            <x-dropdown-link href="{{ route('profile.show') }}" class="text-[#47663B] hover:text-[#EED3B1]">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}" class="text-[#47663B] hover:text-[#EED3B1]">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif
                            <div class="border-t border-[#47663B]"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-[#47663B] hover:text-[#EED3B1]">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-[#47663B] hover:text-[#EED3B1] hover:bg-[#E8ECD7] focus:outline-none focus:bg-[#EED3B1] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" class="text-white hover:text-[#EED3B1]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('skupiny.index') }}" :active="request()->routeIs('skupiny.index')" class="text-white hover:text-[#EED3B1]">
                {{ __('Skupiny') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('lokality.index') }}" :active="request()->routeIs('lokality.index')" class="text-white hover:text-[#EED3B1]">
                {{ __('Lokality') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('ulovky.index') }}" :active="request()->routeIs('ulovky.index')" class="text-white hover:text-[#EED3B1]">
                {{ __('Úlovky') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('ulozene') }}" :active="request()->routeIs('ulozene')" class="text-white hover:text-[#EED3B1]">
                {{ __('Uložené') }}
            </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route('zavody.index') }}" :active="request()->routeIs('zavody.index')" class="text-white hover:text-[#EED3B1]">
                {{ __('Závody') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-[#47663B]">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-white hover:text-[#EED3B1]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="text-white hover:text-[#EED3B1]">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-white hover:text-[#EED3B1]">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
