<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="{{ $font }} min-h-screen bg-body">
        <flux:sidebar sticky stashable class="border-r border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
            </a>

            <flux:navlist variant="outline">

                {{-- <flux:navlist.item icon="home-plate" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>{{ __('Home Plate') }}</flux:navlist.item> --}}
                <flux:navlist.item icon="table-properties" :href="route('scores')" :current="request()->routeIs('scores')" wire:navigate>{{ __('Scores') }}</flux:navlist.item>
                <flux:navlist.item icon="flag" :href="route('teams')" :current="request()->routeIs('teams')" wire:navigate>{{ __('Teams') }}</flux:navlist.item>
                <flux:navlist.item icon="rectangle-group" :href="route('standings')" :current="request()->routeIs('standings')" wire:navigate>{{ __('Standings') }}</flux:navlist.item>
                <flux:navlist.item icon="hashtag" :href="route('rankings')" :current="request()->routeIs('rankings')" wire:navigate>{{ __('Rankings') }}</flux:navlist.item>

                <flux:navlist.group heading="Favorites" class="mt-4">

                    <!-- User Favorites -->
                    @auth
                        @if(auth()->user()->favorites())
                            @foreach(auth()->user()->favorites() as $favorite)

                                <flux:navlist.item href="{{ route('team', $favorite->id) }}" :current="request()->is('/teams/{{ $favorite->id }}')" wire:navigate>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <x-game.team-logo :team="$favorite" size="5" />
                                            <span>{{ $favorite->location }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400">
                                            {{ $favorite->record->summary }}
                                        </span>
                                    </div>

                                    @isset($favorite->live)

                                        <div class="absolute flex items-center top-3 left-0">
                                            <div class="flex">
                                                <span class="relative flex size-1.5">
                                                    <span
                                                        class="absolute flex inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex size-1.5 rounded-full bg-red-700 opacity-60"></span>
                                                </span>
                                            </div>
                                        </div>
                                    @endisset

                                </flux:navlist.item>

                            @endforeach
                        @endif
                    @endauth

                </flux:navlist.group>

            </flux:navlist>

            @auth    
                <flux:spacer />

                <flux:navlist variant="outline">
                    <flux:navlist.item icon="arrows-up-down" href="{{ route('feeds') }}">Feeds</flux:navlist.item>
                    <flux:navlist.item icon="cog-6-tooth" href="{{ route('settings.profile') }}">Settings</flux:navlist.item>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                            {{ __('Log Out') }}
                        </flux:navlist.item>
                    </form>
                    {{-- <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item> --}}
                </flux:navlist>
            @endauth

        </flux:sidebar>

        <!-- Desktop Header -->
        <flux:header class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 hidden lg:block">
            
            <flux:navbar>

                <div class="flex w-full items-center justify-around">
                    <flux:input class="max-w-md" placeholder="Search..." icon="magnifying-glass" />
                </div>
                <flux:spacer />

                <flux:radio.group x-data size="sm" variant="segmented" x-model="$flux.appearance">
                    <flux:radio value="light" icon="sun"></flux:radio>
                    <flux:radio value="dark" icon="moon"></flux:radio>
                    <flux:radio value="system" icon="computer-desktop"></flux:radio>
                </flux:radio.group>
                
                <flux:spacer />

                @auth
                    <flux:dropdown position="top" align="end">
                        <flux:profile
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                            icon-trailing="chevrons-up-down"
                        />

                        <flux:menu class="w-[220px]">
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                            >
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-left text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                            </flux:menu.radio.group>

                            {{-- <flux:menu.separator /> --}}

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>

                            <livewire:fonts />

                        </flux:menu>
                    </flux:dropdown>
                @else                    
                    <div class="flex space-x-2">
                        <flux:button href="{{ route('login') }}" variant="primary">Log in</flux:button>
                        <flux:button href="{{ route('register') }}">Register</flux:button>
                    </div>
                @endauth

            </flux:navbar>
            
        </flux:header>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        
            <flux:spacer />

            <flux:navbar>
                <flux:input placeholder="Search..." icon="magnifying-glass" class="mx-2"/>
            </flux:navbar>

            <flux:spacer />

            @auth
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevron-down"
                    />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                        </flux:menu.radio.group>

                        {{-- <flux:menu.separator /> --}}

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <div class="flex space-x-2">
                    <flux:button href="{{ route('login') }}" size="sm" variant="primary">Log in</flux:button>
                    <flux:button href="{{ route('register') }}" size="sm">Register</flux:button>
                </div>
            @endauth
        </flux:header>

        {{ $slot }}

        @fluxScripts
        <flux:toast position="top right"/>
    </body>
</html>
